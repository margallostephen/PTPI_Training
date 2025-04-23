<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_password'])) {
    session_start();

    $login_user_id = $_SESSION['user_id'] ?? null;
    if (!$login_user_id) {
        echo json_encode([
            'success' => false,
            'message' => 'Not logged in.'
        ]);
        exit;
    }

    require_once '../../config/conn.php';

    $user_id = intval($_POST['user_id']);
    $new_password = trim($_POST['new_password']);

    if (empty($new_password)) {
        echo json_encode([
            'success' => false,
            'message' => 'New password is required.'
        ]);
        exit;
    }

    $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE users SET PASSWORD = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
    $stmt->bind_param("sii", $hashedPassword, $login_user_id, $user_id);

    $response = $stmt->execute()
        ? [
            'success' => true,
            'message' => 'Password reset successful.'
        ]
        : [
            'success' => false,
            'message' => 'Failed to reset password.'
        ];

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
}
?>