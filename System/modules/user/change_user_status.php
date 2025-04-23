<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
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

    $user_id = intval($_POST['user_id']);
    $select = $conn->prepare("SELECT IS_DISABLED FROM users WHERE RID = ?");
    $select->bind_param("i", $user_id);
    $select->execute();
    $select->bind_result($is_disabled);
    $select->fetch();
    $select->close();

    if ($is_disabled === null) {
        echo json_encode([
            'success' => false,
            'message' => 'User not found.'
        ]);
        exit();
    }

    $new_status = ($is_disabled == 0) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE users SET IS_DISABLED = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
    $stmt->bind_param("iii", $new_status, $login_user_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'User status changed successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to change user status.'
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