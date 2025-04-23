<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role_id'], $_POST['role_name'])) {

    session_start();

    $login_user_id = $_SESSION['user_id'];

    if (!isset($login_user_id)) {
        echo json_encode([
            'success' => false,
            'message' => "User is not logged in."
        ]);
        exit();
    }

    require_once '../../config/conn.php';

    $role_id = (int) $_POST['role_id'];
    $role_name = htmlspecialchars(trim($_POST['role_name']));

    if (empty($role_name)) {
        echo json_encode([
            'success' => false,
            'message' => "Role name is required."
        ]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE roles SET ROLE_NAME = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
    $stmt->bind_param("sii", $role_name, $login_user_id, $role_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Role updated successfully!" : "Error: " . $stmt->error
    ]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing fields."
    ]);
}
?>