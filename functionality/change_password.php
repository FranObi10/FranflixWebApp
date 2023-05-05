<!-- /**
This script updates the password of a user in the database. It first checks if the new password and confirm password
fields match. If they do, it hashes the new password and updates the password field in the database for the user with
the given user_id. It then returns a JSON response indicating whether the update was successful or not.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
session_start();

// Replace with your own database connection
require 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Get the current user's ID
    $user_id = $_SESSION['user_id'];

    // Fetch user data
    $query = $connection->prepare("SELECT * FROM users WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($new_password === $confirm_password) {
        // Hash the new password using SHA-256
        $new_password_hash = hash('sha256', $new_password);
    
        // Update password
        $update_query = $connection->prepare("UPDATE users SET pass = ? WHERE user_id = ?");
        $update_query->bind_param("si", $new_password_hash, $user_id);
        $update_query->execute();
    
        // Check if password is updated
        if ($update_query->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Password updated successfully!');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to update password!');
        }
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>