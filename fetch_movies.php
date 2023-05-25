<?php
header('Content-Type: application/json');

require('functionality/connect_db.php');

$category = isset($_POST['category']) ? $_POST['category'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$language = isset($_POST['language']) ? $_POST['language'] : '';

// Create the SQL query
$sql = "SELECT * FROM movies WHERE 1";

// Add conditions based on the user inputs
if (!empty($category)) {
    $sql .= " AND category = '{$category}'";
}

if (!empty($year)) {
    $sql .= " AND release_year = '{$year}'";
}

if (!empty($language)) {
    $sql .= " AND language = '{$language}'";
}

// Run the query and fetch the results
$result = mysqli_query($connection, $sql);

// Prepare the results for JSON output
$output = [];

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $output[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'category' => $row['category'],
            'release_year' => $row['release_year'],
            'language' => $row['language'],
            'image' => $row['image']
        ];
    }
}

// Return the JSON data
echo json_encode($output);

// Close the database connection
mysqli_close($connection);
?>