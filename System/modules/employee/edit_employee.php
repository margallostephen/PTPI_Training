<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'], $_POST['firstname'], $_POST['lastname'], $_POST['department'])) {

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

    $employee_id = htmlspecialchars(trim($_POST['employee_id']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $middlename = htmlspecialchars(trim($_POST['middlename']));
    $department = htmlspecialchars(trim($_POST['department']));

    if (empty($employee_id) || empty($firstname) || empty($lastname) || empty($department)) {
        echo json_encode([
            'success' => false,
            'message' => "All fields are required."
        ]);
        exit();
    }

    if (empty($middlename))
        $middlename = null;

    $stmt = $conn->prepare("UPDATE employees SET LASTNAME = ?, FIRSTNAME = ?, MIDDLENAME = ?, DEPARTMENT = ?, UPDATED_BY = ?, UPDATED_AT = NOW() WHERE RID = ?");
    $stmt->bind_param("sssiii", $lastname, $firstname, $middlename, $department, $login_user_id, $employee_id);
    $result = $stmt->execute();

    echo json_encode([
        'success' => $result,
        'message' => $result ? "Employee updated successfully!" : "Error: " . $stmt->error
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