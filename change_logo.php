<?php
session_start();

require_once 'connect_db.php';

if (isset($_POST['logo_id'])) {
    $logo_id = $_POST['logo_id'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE users SET logo_id = '$logo_id' WHERE user_id = '$user_id'";

    if ($connection->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error updating logo: " + $connection->error;
    }
}
?>