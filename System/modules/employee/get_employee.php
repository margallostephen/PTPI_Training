<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'])) {
    require_once '../../config/conn.php';

    $employee_id = (int) $_POST['employee_id'];

    if (!is_numeric($employee_id)) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid employee ID."
        ]);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM employees WHERE RID = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = $result && $result->num_rows > 0
        ? [
            'success' => true,
            'data' => $result->fetch_assoc()
        ]
        : [
            'success' => false,
            'message' => "Employee not found."
        ];

    $stmt->close();
    $conn->close();
    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing employee ID."
    ]);
}
?>