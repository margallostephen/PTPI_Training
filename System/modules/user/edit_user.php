<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['username'], $_POST['email'], $_POST['user_role'], $_POST['employee_id'])) {

    session_start();

    $login_user_id = $_SESSION['user_id'] ?? null;

    if (!$login_user_id) {
        echo json_encode([
            'success' => false,
            'message' => 'User is not logged in.'
        ]);
        exit();
    }

    require_once '../../config/conn.php';
    require_once '../../config/helper.php';

    $user_id = intval($_POST['user_id']);
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $user_role = htmlspecialchars(trim($_POST['user_role']));
    $employee_id = htmlspecialchars(trim($_POST['employee_id']));
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : null;

    if (empty($username) || empty($email) || empty($user_role) || empty($employee_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'All fields are required.'
        ]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email format.'
        ]);
        exit();
    }

    $checkStmt = $conn->prepare("SELECT RID FROM users WHERE (EMAIL = ? OR USERNAME = ?) AND RID != ?");
    $checkStmt->bind_param("ssi", $email, $username, $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Username or email already exists.'
        ]);
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET USERNAME = ?, EMAIL = ?, PASSWORD = ?, USER_ROLE = ?, EMPLOYEE_ID = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
        $stmt->bind_param("ssssiii", $username, $email, $hashedPassword, $user_role, $employee_id, $login_user_id, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET USERNAME = ?, EMAIL = ?, USER_ROLE = ?, EMPLOYEE_ID = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
        $stmt->bind_param("sssiii", $username, $email, $user_role, $employee_id, $login_user_id, $user_id);
    }

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'User updated successfully.'
        ]);
    } else {
        error_log("Update error: " . $stmt->error);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update user.'
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request or missing fields.'
    ]);
}
?>