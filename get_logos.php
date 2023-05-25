<?php
require_once 'functionality/connect_db.php';

$sql = "SELECT logo_id, logo_name FROM logos"; // Remove logo_url from the SELECT clause
$result = $connection->query($sql);

$logos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $logos[] = array(
            'logo_id' => $row['logo_id'],
            //'logo_url' => $row['logo_url'], // Comment out this line
            'logo_name' => $row['logo_name']
        );
    }
} else {
    echo "0 results";
}

header('Content-Type: application/json');
echo json_encode($logos);

$connection->close();
?>