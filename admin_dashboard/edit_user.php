<?php

# Open database connection.
require('../functionality/connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["edit_user_id"];
    $first_name = $_POST["edit_first_name"];
    $last_name = $_POST["edit_last_name"];
    $email = $_POST["edit_email"];
    $role = $_POST["edit_role"];

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
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    // Fetch user data from the database
    $sql = "SELECT * FROM users WHERE user_id = ?";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Assign the user data to variables
            $edit_user_id = $row["user_id"];
            $edit_first_name = $row["first_name"];
            $edit_last_name = $row["last_name"];
            $edit_email = $row["email"];
            $edit_role = $row["role"];
        } else {
            echo "User not found.";
            exit();
        }
    } else {
        echo "Error: " . $connection->error;
        exit();
    }
} else {
    header("Location: users.php");
    exit();
}
?>

<!-- Rest of your HTML code -->