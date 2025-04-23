<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {

    session_start();

    $user_id = (int) $_POST['user_id'];
    $login_user_id = $_SESSION['user_id'];

    if (!isset($login_user_id)) {
        echo json_encode([
            'success' => false,
            'message' => "User is not logged in."
        ]);
        exit();
    }

    require_once '../../config/conn.php';

    $stmt = $conn->prepare("UPDATE users SET DELETED_AT = NOW(), DELETED_BY = ? WHERE RID = ? AND DELETED_AT IS NULL");
    $stmt->bind_param("si", $login_user_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = [
            'success' => true,
            'message' => "User deleted successfully."
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "User not found or already deleted."
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing user ID."
    ]);
}
?>