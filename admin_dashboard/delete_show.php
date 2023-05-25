<?php
require('../functionality/connect_db.php');

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    $table = $type === 'movie' ? 'movies' : 'tv_shows';

    // The $connection variable should be available from the included connect_db.php
    if (!$connection) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    $query = "DELETE FROM " . $table . " WHERE id = " . mysqli_real_escape_string($connection, $id);
    $result = mysqli_query($connection, $query);

    if ($result) {
        header('Location: shows.php?deleted=true'); // Redirect to the shows page after deletion
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    header('Location: shows.php');
}
?>