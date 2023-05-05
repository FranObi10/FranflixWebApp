<!-- /**
* This is not part of the app project. It's a test for me. Compares the entered password with the stored password hash and returns a message indicating whether the old password
is correct or not.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
// Include your database connection file
require_once 'connect_db.php';

// Replace these variables with the actual values from your database
$entered_old_password = '123';
$stored_password_hash = 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e99...';

echo "Entered password: " . $entered_old_password . "<br>";
echo "Stored password hash: " . $stored_password_hash . "<br>";

if (hash('sha256', $entered_password) === $stored_password_hash) {
    echo "Old password is correct!";
} else {
    echo "Old password is incorrect!";
}
?>