<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstname'], $_POST['lastname'], $_POST['department'])) {

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

    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $middlename = htmlspecialchars(trim($_POST['middlename']));
    $department = htmlspecialchars(trim($_POST['department']));

    if (empty($firstname) || empty($lastname) || empty($department)) {
        echo json_encode([
            'success' => false,
            'message' => "All fields are required."
        ]);
        exit();
    }

    $rid = generateUnique7DigitCode($conn, "employees", "RID");

    $stmt = $conn->prepare("INSERT INTO employees (RID, LASTNAME, FIRSTNAME, MIDDLENAME, DEPARTMENT, CREATED_BY) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssii", $rid, $lastname, $firstname, $middlename, $department, $login_user_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Employee added successfully!" : "Error: " . $stmt->error
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