<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die('Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content_id'])) {
    require('connect_db.php');

    $user_id = $_SESSION['user_id'];
    $tv_show_id = mysqli_real_escape_string($connection, $_POST['content_id']);

    // Check if the user has already liked this TV show
    $q = "SELECT * FROM user_likes WHERE user_id = $user_id AND movie_id = $tv_show_id AND content_type = 'tv_show'";
$r = mysqli_query($connection, $q);

    if (mysqli_num_rows($r) > 0) {
        // If the user has already liked the TV show, remove the like
        $q = "DELETE FROM user_likes WHERE user_id = $user_id AND movie_id = $tv_show_id AND content_type = 'tv_show'";
mysqli_query($connection, $q);
        // Set the response text to indicate that the like was removed
        $response_text = "removed";
    } else {
        // If the user has not liked the TV show yet, add a like
        $q = "INSERT INTO user_likes (user_id, movie_id, content_type) VALUES ($user_id, $tv_show_id, 'tv_show')";
mysqli_query($connection, $q);

        // Set the response text to indicate that the like was added
        $response_text = "added";
    }

    echo $response_text;
} else {
    http_response_code(400);
    die('Bad Request');
}
?>