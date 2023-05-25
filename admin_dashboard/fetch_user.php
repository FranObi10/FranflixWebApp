<?php
# Open database connection.
require('../functionality/connect_db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM users WHERE user_id = ?";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) {
                // Return the user data as JSON response
                echo json_encode($user);
            } else {
                echo json_encode(['error' => 'User not found']);
            }
        } else {
            echo json_encode(['error' => 'Database query failed']);
        }
    } else {
        echo json_encode(['error' => 'Database query preparation failed']);
    }

    $stmt->close();
    $connection->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>