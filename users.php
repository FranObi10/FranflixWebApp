<!-- /**
Renders a table of all users in the database. Only users with an 'admin' role can access this page.
Not using this page at the moment
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
session_start();

// Check if the user is logged in and has an admin role.
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'config.php'; // Your database configuration file.

// Fetch all users from the database.
$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>

<body>
    <div class="container">
        <h1 class="my-4">Users</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Card Number</th>
                    <th>Expiry Month</th>
                    <th>Expiry Year</th>
                    <th>CVV</th>
                    <th>Role</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['first_name']; ?></td>
                    <td><?php echo $user['last_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['card_number']; ?></td>
                    <td><?php echo $user['exp_month']; ?></td>
                    <td><?php echo $user['exp_year']; ?></td>
                    <td><?php echo $user['cvv']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['reg_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>