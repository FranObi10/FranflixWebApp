<?php
ob_start(); // Add this line at the beginning of the file.
require(__DIR__ . '/../includes/header.php');
require('connect_db.php');

$search = trim($_GET['search']);

if ($search) {
    $search = mysqli_real_escape_string($connection, $search);

    $query = "SELECT *, 'movie' as content_type FROM movies WHERE title LIKE '%$search%'
          UNION
          SELECT *, 'tv_show' as content_type FROM tv_shows WHERE title LIKE '%$search%'";

    $result = mysqli_query($connection, $query);
    $num_results = mysqli_num_rows($result);

    if ($num_results > 0) {
        if ($num_results == 1) {
            $row = mysqli_fetch_assoc($result);
            $content_type = ($row['content_type'] === 'movie') ? 'display_movie' : 'display_show';
            header("Location: ../$content_type.php?id=" . $row['id']);
            exit();
        } else {
            // Handle multiple results here
        }
    } else {
        $_SESSION['search_error'] = 'No movie or TV show found with the title: ' . $search;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    header('Location: home.php');
    exit();
}
ob_end_flush(); // Add this line at the end of the file.
?>