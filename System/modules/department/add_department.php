<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['department'])) {

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

    $department = htmlspecialchars(trim($_POST['department']));

    if (empty($department)) {
        echo json_encode([
            'success' => false,
            'message' => "Department name is required."
        ]);
        exit();
    }

    $rid = generateUnique7DigitCode($conn, "departments", "RID");

    $stmt = $conn->prepare("INSERT INTO departments (RID, DEPT_DESC, CREATED_BY) VALUES(?, ?, ?)");
    $stmt->bind_param("isi", $rid, $department, $login_user_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Department added successfully!" : "Error: " . $stmt->error
    ]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid rquest or missing fields."
    ]);
}