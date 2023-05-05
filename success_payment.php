<!-- /**
* Displays a success message after a payment has been successfully processed and updates the user's membership status.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
session_start();

$page_title = 'Payment Success';

# Open database connection.
require('functionality/connect_db.php');

include ( 'includes/header.php' ) ;

?>

<main id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h2 class="text-center mb-4">Payment Successful</h2>
                    <p>Your payment was successful, and your membership has been updated. Thank you for joining our
                        membership program!</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            </div>
        </div>
    </div>
</main>