<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role'])) {

    session_start();

    $login_user_id = $_SESSION['user_id'];

    if (!isset($login_user_id)) {
        echo json_encode([
            'success' => false,
            'message' => "User is not logged in."
        ]);
        exit();
    }

    require_once '../../config/conn.php';
    require_once '../../config/helper.php';

    $role_name = htmlspecialchars(trim($_POST['role']));

    if (empty($role_name)) {
        echo json_encode([
            'success' => false,
            'message' => "Role name is required."
        ]);
        exit();
    }

    $rid = generateUnique7DigitCode($conn, "roles", "RID");

    $stmt = $conn->prepare("INSERT INTO roles (RID, ROLE_NAME, CREATED_BY) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $rid, $role_name, $login_user_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Role added successfully!" : "Error: " . $stmt->error
    ]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request or missing fields."
    ]);
}
?>