<?php
// Include your database connection file
require('../functionality/connect_db.php');

$id = $_GET['id'];
$type = $_GET['type'];
$table = $type === 'movie' ? 'movies' : 'tv_shows';

$query = "SELECT * FROM {$table} WHERE id={$id}";
$result = mysqli_query($connection, $query);
$show = mysqli_fetch_assoc($result);
?>