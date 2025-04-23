<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['department_id'])) {

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

    $stmt = $conn->prepare("UPDATE departments SET DELETED_AT = NOW(), DELETED_BY = ? WHERE RID = ? AND DELETED_AT IS NULL");
    $stmt->bind_param("si", $login_user_id, $department_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            'success' => true,
            'message' => "Department deleted successfully."
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "Department not found or already deleted."
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing department ID."
    ]);
}
?>