<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['user_role'], $_POST['employee_id'])) {

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

    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $user_role = htmlspecialchars(trim($_POST['user_role']));
    $employee_id = htmlspecialchars(trim($_POST['employee_id']));

    if (empty($username) || empty($email) || empty($password) || empty($user_role) || empty($employee_id)) {
        echo json_encode([
            'success' => false,
            'message' => "All fields are required."
        ]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => "Invalid email format."
        ]);
        exit();
    }

    $checkStmt = $conn->prepare("SELECT RID FROM users WHERE EMAIL = ? OR USERNAME = ?");
    $checkStmt->bind_param("ss", $email, $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => "Username or email already exists."
        ]);
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    $rid = generateUnique7DigitCode($conn, "users", "RID");
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (RID, USERNAME, EMAIL, PASSWORD, USER_ROLE, CREATED_BY, EMPLOYEE_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisi", $rid, $username, $email, $hashedPassword, $user_role, $login_user_id, $employee_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error registering user: ' . $stmt->error]);
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