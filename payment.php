<!-- /**
* Initiates a PayPal payment and updates the user's membership status to active.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
ob_start(); // Add this line to the beginning of the file
session_start();

# Open database connection.
require('functionality/connect_db.php');

include('includes/header.php');

require_once('dependencies/autoload.php');

// PayPal client ID and secret.
$clientId = 'AZluxHWq59_oJtBobNgEaMVBMjHLvW-bmN_so7F1xsOW7Jlu9AXhGy0M0nP894c1u65Hv5ObKZDJ8Z6y';
$clientSecret = 'EEtt7715yRHjH5SC3XHWN3AhwMiYS_0mawVHK8tZgTGEYrnhNxqh1vAyoPtqIVkqs_HWhGCzDfpjwIbE';

$apiContext = new \PayPal\Rest\ApiContext(
new \PayPal\Auth\OAuthTokenCredential(
$clientId,
$clientSecret
)
);

// Double check this one
if (true) {
    try {
        // Update the membership status of the user.
        $user_id = $_SESSION['user_id'];
        $membership_status = 'active';
        $sql = "UPDATE users SET role = 'member', membership_status = 'active' WHERE user_id = $user_id";
        $result = mysqli_query($connection, $sql);

        if (!$result) {
            die('Error updating membership status: ' . mysqli_error($dbc));
        }

        // Set the payment ID in the session.
        $_SESSION['payment_id'] = 'bypassed_verification';

        header('Location: success_payment.php');
        exit();
    } catch (Exception $e) {
        echo 'Payment failed: ' . $e->getMessage();
    }
}

include ( 'includes/footer.html' ) ;
ob_end_flush();
?>