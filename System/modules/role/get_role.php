<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['role_id'])) {
    require_once '../../config/conn.php';

    $role_id = (int) $_POST['role_id'];

    if (!is_numeric($role_id)) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid role ID."
        ]);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM roles WHERE RID = ?");
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = $result && $result->num_rows > 0
        ? [
            'success' => true,
            'data' => $result->fetch_assoc() 
        ]
        : [
            'success' => false,
            'message' => "Role not found."
        ];

    $stmt->close();
    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing role ID."
    ]);
}
?>