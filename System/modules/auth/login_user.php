<?php
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'], $_POST['password'])) {
    require_once '../../config/conn.php';

    $user = htmlspecialchars(trim($_POST['user']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($user) || empty($password)) {
        $response['message'] = 'Username/Email/ID and password are required.';
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare("
        SELECT users.*, roles.ROLE_NAME 
        FROM users 
        LEFT JOIN roles ON users.USER_ROLE = roles.RID
        WHERE users.USERNAME = ? OR users.EMAIL = ? OR users.RID = ?
    ");
    $stmt->bind_param("sss", $user, $user, $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['IS_DISABLED'] == 1) {
            $response['message'] = 'Your account is disabled. Please contact the administrator.';
        } else {
            if (password_verify($password, $user['PASSWORD'])) {
                session_start();

                $_SESSION['user_id'] = $user['RID'];
                $_SESSION['username'] = $user['USERNAME'];
                $_SESSION['email'] = $user['EMAIL'];
                $_SESSION['user_role'] = $user['USER_ROLE'];
                $_SESSION['user_role_name'] = $user['ROLE_NAME'];

                unset($user['PASSWORD']);
                $response['user'] = $user;
                $response['success'] = true;
                $response['message'] = 'Login successful.';
            } else {
                $response['message'] = 'Incorrect password.';
            }
        }
    } else {
        $response['message'] = 'User not found.';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Invalid request or missing fields.';
}

echo json_encode($response);
?>