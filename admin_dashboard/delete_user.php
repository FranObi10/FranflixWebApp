<?php

# Open database connection.
require('../functionality/connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];

    $sql = "DELETE FROM users WHERE user_id=?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            header("Location: users.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $connection->close();
}
?>