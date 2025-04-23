<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    require_once '../../config/conn.php';

    $user_id = (int) $_POST['user_id'];

    if (!is_numeric($user_id)) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid user ID."
        ]);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE RID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = $result && $result->num_rows > 0
        ? [
            'success' => true,
            'data' => $result->fetch_assoc()
        ]
        : [
            'success' => false,
            'message' => "User not found."
        ];

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