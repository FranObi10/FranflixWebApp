<?php
# Access session.
session_start() ;

# Set page title and display header section.
$page_title = 'Admin Dashboard' ;

#include ( 'includes/logout.html' ) ;
include ( '../includes/admin_header.html' ) ;

# Redirect if not logged in or not an admin.
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    require('../functionality/login_tools.php');
    load();
}


# Open database connection.
require('../functionality/connect_db.php');

# Get the count of movies
$movies_query = "SELECT COUNT(*) as count FROM movies";
$movies_result = mysqli_query($connection, $movies_query);
$movies_count = mysqli_fetch_assoc($movies_result)['count'];

# Get the count of TV shows
$tv_shows_query = "SELECT COUNT(*) as count FROM tv_shows";
$tv_shows_result = mysqli_query($connection, $tv_shows_query);
$tv_shows_count = mysqli_fetch_assoc($tv_shows_result)['count'];

# Get the count of users
$users_query = "SELECT COUNT(*) as count FROM users";
$users_result = mysqli_query($connection, $users_query);
$users_count = mysqli_fetch_assoc($users_result)['count'];

# Query to get the most liked shows in the table
$sql = "SELECT ul.id, ul.movie_id, ul.content_type, COALESCE(m.title, tv.title) as title, COUNT(ul.movie_id) as total_likes
FROM user_likes ul
LEFT JOIN movies m ON ul.movie_id = m.id AND ul.content_type = 'movie'
LEFT JOIN tv_shows tv ON ul.movie_id = tv.id AND ul.content_type = 'tv_show'
GROUP BY ul.movie_id, ul.content_type
ORDER BY total_likes DESC
LIMIT 10";

$result = $connection->query($sql);

$liked_shows = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $liked_shows[] = $row;
    }
} else {
    echo "0 results";
}
?>


<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fa-solid fa-pen"></i>
                </i>FRANFLIX</div>
            <div class="list-group list-group-flush my-3">
                <a href="admin_dashboard.php"
                    class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="users.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-users"></i> Users</a>
                <a href="shows.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-film"></i> Shows</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-shopping-cart me-2"></i>Memberships</a>
                <a href="../logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Admin Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 justify-content-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="../home.php">Home</a></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $movies_count; ?></h3>
                                <p class="fs-5">Movies</p>
                            </div>
                            <i class="fas fa-film fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $tv_shows_count; ?></h3>
                                <p class="fs-5">TV Shows</p>
                            </div>
                            <i class="fas fa-couch fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $users_count; ?></h3>
                                <p class="fs-5">Users</p>
                            </div>
                            <i class="fas fa-users fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <!-- Substitute this table with my database content -->
                    <div class="row my-5">
                        <h3 class="fs-4 mb-3">Most Liked Shows</h3>
                        <div class="col">
                            <table class="table bg-white rounded shadow-sm  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50">#</th>
                                        <th scope="col">Movie ID</th>
                                        <th scope="col">Content Type</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Total Likes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($liked_shows as $index => $liked_show): ?>
                                    <tr>
                                        <th scope="row"><?php echo $index + 1; ?></th>
                                        <td><?php echo $liked_show['movie_id']; ?></td>
                                        <td><?php echo ucfirst($liked_show['content_type']); ?></td>
                                        <td><?php echo $liked_show['title']; ?></td>
                                        <td><?php echo $liked_show['total_likes']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function() {
        el.classList.toggle("toggled");
    };
    </script>


    <?php

include('../includes/admin_footer.html');

?>