<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['department_id'])) {
    require_once '../../config/conn.php';

    $department_id = (int) $_POST['department_id'];

    if (!is_numeric($department_id)) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid role ID."
        ]);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM departments WHERE RID = ?");
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = $result && $result->num_rows > 0
        ? [
            'success' => true,
            'data' => $result->fetch_assoc()
        ]
        : [
            'success' => false,
            'message' => "Department not found."
        ];

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