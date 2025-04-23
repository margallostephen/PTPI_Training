<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../config/conn.php';

    $status = isset($_POST['status']) && $_POST['status'] !== '' ? (int) $_POST['status'] : null;
    $sql = "SELECT * FROM users WHERE DELETED_AT IS NULL" . ($status !== null ? " AND IS_DISABLED = ?" : "") . " ORDER BY CREATED_AT DESC";

    $stmt = $conn->prepare($sql);
    if ($status !== null)
        $stmt->bind_param("i", $status);

    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

    foreach ($users as &$user)
        unset($user['PASSWORD']);

    echo json_encode([
        'success' => count($users) > 0,
        'data' => $users,
        'message' => count($users) > 0 ? null : 'No users found.'
    ]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
