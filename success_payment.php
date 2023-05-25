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

<style>
.video-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
}

.video-background video {
    position: absolute;
    min-width: 100%;
    min-height: 100%;
    object-fit: cover;
}

.container {
    height: 100vh;
}

.centered-row {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}
</style>

<main id="main">
    <div class="video-background">
        <video autoplay muted loop>
            <source src="assets/img/backgrounds/success_payment_bg.mp4" type="video/mp4">
        </video>
    </div>
    <div class="container">
        <div class="row centered-row">
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h2 class="text-center mb-4">Payment Successful</h2>
                    <p class="text-center">Your payment was successful, and your membership has been updated. Thank you
                        for joining our
                        membership program! Now explore our <a href="home.php">Catalog</a></p>
                </div>
            </div>
        </div>
    </div>
</main>


<?php include('includes/footer.html'); ?>