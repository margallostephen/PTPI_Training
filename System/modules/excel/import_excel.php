<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['table']) || !isset($input['data']) || !is_array($input['data'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid or missing data/table."]);
        exit;
    }

    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $input['table']);
    $data = $input['data'];

    if (empty($data)) {
        echo json_encode(["success" => false, "message" => "No data to insert."]);
        exit;
    }

    $columns = array_keys($data[0]);
    $columns[] = 'CREATED_BY';

    $columnList = implode(',', $columns);
    $placeholders = implode(',', array_fill(0, count($columns), '?'));

    $types = implode('', array_map(fn($val) => is_numeric($val) ? 'i' : 's', $data[0])) . 'i';

    $stmt = $conn->prepare("INSERT INTO `$table` ($columnList) VALUES ($placeholders)");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        exit;
    }


    foreach ($data as $row) {
        $values = [];

        foreach ($row as $val) {
            if ($val === "N/A" || $val == "") {
                $values[] = null;
            } elseif (is_string($val)) {
                $values[] = strtoupper($val);
            } else {
                $values[] = $val;
            }
        }

        $values[] = $login_user_id;

        if (!$stmt->bind_param($types, ...$values)) {
            echo json_encode(["success" => false, "message" => "Binding failed: " . $stmt->error]);
            exit;
        }

        if (!$stmt->execute()) {
            echo json_encode(["success" => false, "message" => "Insert failed: " . $stmt->error]);
            exit;
        }
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["success" => true, "message" => "Data imported to {$table} successfully."]);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request method."
    ]);
}
