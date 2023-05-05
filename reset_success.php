<!-- /**
* Displays a success message after a password reset and provides a link to the login page.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
#DISPLAY COMPLETE LOGIN PAGE.

# Set page title and display header section.
$page_title = 'Reset Success' ;

#include ( 'includes/logout.html' ) ;
include ( 'includes/header_landing_page.html' ) ;

?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success">
                Your password has been successfully changed! <a href="login.php" class="alert-link">Go to Login</a>
            </div>

        </div>
    </div>


    <?php
include 'includes/footer.html';
?>