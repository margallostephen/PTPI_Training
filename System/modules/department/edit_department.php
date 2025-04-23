<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['department_id'], $_POST['department_name'])) {

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

    $department_id = (int) $_POST['department_id'];
    $department_name = htmlspecialchars(trim($_POST['department_name']));

    if (empty($department_name)) {
        echo json_encode([
            'success' => false,
            'message' => "Department name is required."
        ]);
        exit();
    }

    $stmt = $conn->prepare("UPDATE departments SET DEPT_DESC = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
    $stmt->bind_param("sii", $department_name, $login_user_id, $department_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Department updated successfully!" : "Error: " . $stmt->error
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