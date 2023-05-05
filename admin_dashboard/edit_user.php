<?php

# Open database connection.
require('../functionality/connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, role=? WHERE user_id=?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $role, $user_id);

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
