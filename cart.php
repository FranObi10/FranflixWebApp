<!-- /**
This script generates a page that displays the items in the cart and allows the user to pay using PayPal. It starts by
setting the page title and including the header. If the user is not logged in, it redirects to the login page.
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
ob_start(); // Start output buffering

session_start();

# Set page title
$page_title = 'Cart';

# Open database connection and include header.
require('functionality/connect_db.php');
include('includes/header.php');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('login_tools.php');
    load();
}


?>

<!-- Leave style here, it was interfering with other pages -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif
}

.table.activitites th,
.table.activitites td {
    width: 25%;
}

.white-text {
    color: #ffffff;
}
</style>

<style>
.table.activitites th,
.table.activitites td {
    width: 25%;
}

tr th {
    color: #ea580c;
}
</style>

<main id="main">
    <div class="container mt-5 mb-5">
        <div class="table-responsive">
            <table class="table activitites white-text" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" class="text-uppercase header">item</th>
                        <th scope="col" class="text-uppercase">Quantity</th>
                        <th scope="col" class="text-uppercase">price</th>
                        <th scope="col" class="text-uppercase">total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="item">
                            <div class="d-flex">
                                <div class="pl-2">
                                    Starter
                                    <div class="d-flex flex-column justify-content-center">

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>1</td>
                        <td class="text-right"><span class="red">£9,99</span>
                        </td>
                        <td class="font-weight-bold">
                            £9.99
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td class="font-weight-bold text-right">
                            <form id="paypal-form" style="display: inline-block; float: right; margin-top: 40px;">
                                <!-- Add the PayPal button container -->
                                <div id="paypal-button-container" style="display: inline-block;"></div>
                            </form>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</main><!-- End #main -->

<!-- PayPal script -->
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
// Render PayPal button
paypal.Button.render({
    // Set environment
    env: 'sandbox', // sandbox | production

    // Style of the button
    style: {
        layout: 'vertical', // horizontal | vertical
        size: 'medium', // medium | large | responsive
        shape: 'rect', // pill | rect
        color: 'gold' // gold | blue | silver | white | black
    },

    funding: {
        allowed: [paypal.FUNDING.CARD, paypal.FUNDING.CREDIT],
        disallowed: []
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // PayPal Client IDs
    client: {
        sandbox: 'AZluxHWq59_oJtBobNgEaMVBMjHLvW-bmN_so7F1xsOW7Jlu9AXhGy0M0nP894c1u65Hv5ObKZDJ8Z6y',
        production: '<insert production client id>'
    },

    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [{
                    amount: {
                        total: '9.99',
                        currency: 'GBP'
                    }
                }]
            }
        });
    },

    onAuthorize: function(data, actions) {
        return actions.payment.execute()
            .then(function() {
                // Append the first and last name to the URL
                var url = "payment.php";

                // Redirect the user to the payment processing page
                window.location.href = url;
            });
    }
}, '#paypal-button-container');
</script>

<!-- Other scripts. Not sure if I need this -->
<script src="assets/web_app/glightbox/js/glightbox.min.js"></script>

<?php

include('includes/footer.html');

ob_end_flush(); // End output buffering and flush the buffer

?>