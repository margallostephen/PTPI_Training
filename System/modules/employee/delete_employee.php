<?php
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {

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

    $employee_id = $_POST['employee_id'];

    $stmt = $conn->prepare("UPDATE employees SET DELETED_AT = NOW(), DELETED_BY = ? WHERE RID = ? AND DELETED_AT IS NULL");
    $stmt->bind_param("si", $login_user_id, $employee_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response['success'] = true;
        $response['message'] = "Employee deleted successfully.";
    } else {
        $response['message'] = "Employee not found or already deleted.";
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = "Employee ID is missing!";
}

echo json_encode($response);
?>