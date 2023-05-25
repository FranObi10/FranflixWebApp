<?php
header('Content-Type: application/json');

require('functionality/connect_db.php');

// Fetch categories
$categories_sql = "SELECT DISTINCT category FROM movies ORDER BY category";
$categories_result = mysqli_query($connection, $categories_sql);
$categories = [];

while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row['category'];
}

// Fetch years
$years_sql = "SELECT DISTINCT release_year FROM movies ORDER BY release_year";
$years_result = mysqli_query($connection, $years_sql);
$years = [];

while ($row = mysqli_fetch_assoc($years_result)) {
    $years[] = $row['release_year'];
}

// Fetch languages
$languages_sql = "SELECT DISTINCT language FROM movies ORDER BY language";
$languages_result = mysqli_query($connection, $languages_sql);
$languages = [];

while ($row = mysqli_fetch_assoc($languages_result)) {
    $languages[] = $row['language'];
}

// Prepare the JSON output
$output = [
    'categories' => $categories,
    'years' => $years,
    'languages' => $languages
];

// Return the JSON data
echo json_encode($output);

// Close the database connection
mysqli_close($connection);
?>