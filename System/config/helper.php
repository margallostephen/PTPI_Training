<?php
function generateUnique7DigitCode($conn, $table, $column)
{
    do {
        $code = rand(1000000, 9999999);

        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM $table WHERE $column = ?");
        $stmt->bind_param("i", $code);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    } while ($row['total'] > 0);

    return $code;
}
?>