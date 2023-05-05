<!-- /**
* Updates the membership status of the user to 'member' in the database.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit;
}

require('../functionality/connect_db.php');

$user_id = $_SESSION['user_id'];

$query = "UPDATE users SET role = 'member' WHERE user_id = $user_id";
$result = mysqli_query($connection, $query);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update membership status.']);
}


mysqli_close($connection);

?>