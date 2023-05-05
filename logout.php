<!-- /**
* Displays a complete logged out page.
* Accesses session and redirects to login page if user is not logged in.
* Destroys the session and displays a goodbye message.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php

# Access session.

session_start();

# Redirect if not logged in
if(!isset($_SESSION['user_id']))
{
    require('login_tools.php');
    load();
}

# Set page title and display header section.
$page_title="Home";
include('includes/header_landing_page.html');

# Clear existing variables

$_SESSION = array();

# Destroy the session.

session_destroy();

# Display body section
echo '<h1>Goodbye!</h1><p>You are now logged out.</p>
<p><a href="login.php">Login</a></p>';
?>

<?php
# Display footer section
include('includes/footer.html');
?>