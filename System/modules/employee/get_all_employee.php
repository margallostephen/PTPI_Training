<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../../config/conn.php';

    $result = $conn->query("SELECT * FROM employees WHERE DELETED_AT IS NULL ORDER BY CREATED_AT DESC");

    if ($result && $result->num_rows > 0) {
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $response = [
            'success' => true,
            'data' => $employees
        ];
    } else {
        $response = [
            'success' => false,
            'message' => $result ? "No employees found." : "Error executing query."
        ];
    }

    $conn->close();

    echo json_encode($response);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
}
?>