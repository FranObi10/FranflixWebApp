<!-- /**
* This script handles the user's like/unlike action on a movie. 

* @Francesca Obino
* @Franflix WebApp

*/ -->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die('Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id'])) {
    require('connect_db.php');

    $user_id = $_SESSION['user_id'];
    $movie_id = mysqli_real_escape_string($connection, $_POST['movie_id']);

    // Check if the user has already liked this movie
    $q = "SELECT * FROM user_likes WHERE user_id = $user_id AND movie_id = $movie_id";
    $r = mysqli_query($connection, $q);

    if (mysqli_num_rows($r) > 0) {
        // If the user has already liked the movie, remove the like
        $q = "DELETE FROM user_likes WHERE user_id = $user_id AND movie_id = $movie_id";
        mysqli_query($connection, $q);

        // Set the response text to indicate that the like was removed
        $response_text = "removed";
    } else {
        // If the user has not liked the movie yet, add a like
        $q = "INSERT INTO user_likes (user_id, movie_id) VALUES ($user_id, $movie_id)";
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