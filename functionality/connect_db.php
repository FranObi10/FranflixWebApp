<!-- /**
* Connects to a MySQL database using the provided credentials.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php # CONNECT TO MySQL DATABASE.


# Credentials
$dbhost = "localhost";
$dbuser = "hdnsofts2a4";
$dbpass = "1234";
$dbname = "franflix";

# Connect on 'localhost' 
$connection = mysqli_connect($dbhost, $dbuser, $dbpass,
$dbname);
if (!$connection) {
# Otherwise fail gracefully and explain the error.
die('Could not connect to MySQL: ' . mysqli_error());
}
echo '';
?>