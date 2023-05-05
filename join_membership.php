<!-- /**
This script generates a membership page that displays two subscription plans: Starter and Premium. The page is only
accessible to logged-in users, and if a user is not logged in, they will be redirected to the login page.

* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
ob_start(); // Start output buffering

session_start();

# Set page title
$page_title = 'Membership';

# Open database connection and include header.
require('functionality/connect_db.php');
include('includes/header.php');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('login_tools.php');
    load();
}

?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif
}

.card-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card-content {
    width: 100%;
    max-width: 1200px;
}


.card {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 250px;
    height: 380px;
    position: relative;
    padding: 20px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}

.h-1 {
    text-transform: uppercase
}

.h2 {
    color: #fff;
}

.ribon {
    position: absolute;
    left: 50%;
    top: 0;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background-color: #ea580c;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center
}

.card .price {
    color: #ea580c;
    font-size: 30px
}

.card ul {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center
}

.card ul li {
    font-size: 12px;
    margin-bottom: 8px
}

.card ul .fa.fa-check {
    font-size: 8px;
    color: gold
}

.fa-face-grin-stars {
    font-size: 30px;
}

.fa-star {
    font-size: 30px;
}


.card:hover {
    background-color: gold
}

.card:hover .fa.fa-check {
    color: #2b98f0
}

.card .btn {
    width: 200px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ea580c;
    border: none;
    border-radius: 5px;
    box-shadow: none
}

@media (max-width:500px) {
    .card {
        max-width: 100%
    }
}
</style>

<div class="card-container">
    <div class="card-content">
        <p class="h2 text-center mb-5">Choose Your Perfect Plan</p>
        <div class="row mt-3 justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="ribon">
                        <span class="fa-solid fa-face-grin-stars"></span>
                    </div>
                    <p class="h-1 pt-5">STARTER</p>
                    <span class="price">
                        <sup class="sup">£</sup>
                        <span class="number">9.99</span>
                    </span>
                    <ul class="mb-5 list-unstyled text-muted">
                        <li><span class="fa fa-check me-2"></span>Access to all shows</li>
                        <li><span class="fa fa-check me-2"></span>Basic video quality</li>
                        <li><span class="fa fa-check me-2"></span>Access to content with ads</li>
                    </ul>
                    <a href="cart.php" class="btn btn-primary">SUBSCRIBE NOW</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="ribon">
                        <span class="fa-solid fa-star"></span>
                    </div>
                    <p class="h-1 pt-5">PREMIUM</p>
                    <span class="price">
                        <sup class="sup">£</sup>
                        <span class="number">19.99</span>
                    </span>
                    <ul class="mb-5 list-unstyled text-muted">
                        <li><span class="fa fa-check me-2"></span>Exclusive content</li>
                        <li><span class="fa fa-check me-2"></span>Personalized experience</li>
                        <li><span class="fa fa-check me-2"></span>high-definition video quality</li>
                        <li><span class="fa fa-check me-2"></span>Flexible membership</li>
                    </ul>
                    <a href="cart.php" class="btn btn-primary">SUBSCRIBE NOW</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

include('includes/footer.html');

ob_end_flush(); // End output buffering and flush the buffer

?>