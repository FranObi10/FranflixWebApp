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
?>

<body>
    <div id="alert-container"></div>

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
                </div>
                <!-- Filter form -->
                <form method="post" action="shows.php">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label for="show_type">Show Type:</label>
                            <select name="show_type" id="show_type" class="form-control">
                                <option value="all">All</option>
                                <option value="movie">Movie</option>
                                <option value="tv_show">TV Show</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="category">Category:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="all">All</option>
                                <option value="Spy thriller">Spy thriller</option>
                                <option value="Sitcom">Sitcom</option>
                                <option value="Medical drama">Medical drama</option>
                                <option value="Historical drama">Historical drama</option>
                                <option value="Thriller">Thriller</option>
                                <option value="Science fiction">Science fiction</option>
                                <option value="Drama">Drama</option>
                                <option value="Romance">Romance</option>
                                <option value="Animation">Animation</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <button type="submit" class="btn apply-filter-button mt-4">Apply Filter</button>
                            <button type="button" class="btn add-movie-button mt-4 ms-2" data-bs-toggle="modal"
                                data-bs-target="#addMovieModal">Add Movie</button>
                            <button type="button" class="btn add-show-button mt-4 ms-2" data-bs-toggle="modal"
                                data-bs-target="#addTvShowModal">Add TV Show</button>

                        </div>

                    </div>
                </form>
                <!-- end filter form -->


                <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $show_type = $_POST['show_type'];
        $category = $_POST['category'];
    
        $show_type_filter = "";
        $category_filter = "";
    
        if (!empty($show_type) && $show_type != "all") {
            $show_type_filter = " AND type='" . mysqli_real_escape_string($connection, $show_type) . "'";
        }
    
        if (!empty($category) && $category != "all") {
            $category_filter = " AND category='" . mysqli_real_escape_string($connection, $category) . "'";
        }
    
        $q = "SELECT * FROM (
                (SELECT id, title, category, 'movie' as type FROM movies)
                UNION ALL
                (SELECT id, title, category, 'tv_show' as type FROM tv_shows)
              ) AS all_shows
              WHERE 1=1" . $show_type_filter . $category_filter;
    } else {
        $q = "SELECT * FROM (
                (SELECT id, title, category, 'movie' as type FROM movies)
                UNION ALL
                (SELECT id, title, category, 'tv_show' as type FROM tv_shows)
              ) AS all_shows";
    }
    
    $r = mysqli_query($connection, $q);
    
    ?>

                <!-- Shows table -->
                <div class="row my-5">

                    <?php
if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Show deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
}
?>
                    <h3 class="fs-4 mb-3">Shows</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        echo '<tr>
                        <th scope="row">' . $row['id'] . '</th>
                        <td>' . $row['title'] . '</td>
                        <td>' . $row['category'] . '</td>
                        <td>' . ucwords(str_replace('_', ' ', $row['type'])) . '</td>
                        <td>
                        <a href="#" class="edit-link" data-bs-toggle="modal" data-bs-target="#editShowModal" data-show-id="' . $row['id'] . '" data-show-type="' . $row['type'] . '">Edit</a>
                        <a href="delete_show.php?id=' . $row['id'] . '&type=' . $row['type'] . '" class="delete-link">Delete</a>
                        
                        </td>
                    </tr>';
                }
                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Show Modal -->
                <div class="modal fade" id="editShowModal" tabindex="-1" aria-labelledby="editShowModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editShowModalLabel">Edit Show</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="editShowModalBody">
                                <!-- The edit form caricata qua con JavaScript -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveChangesButton">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Add Movie Modal -->
                <div class="modal fade" id="addMovieModal" tabindex="-1" role="dialog"
                    aria-labelledby="addMovieModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMovieModalLabel">Add Movie</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addMovieForm" action="add_movie.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <!-- Movie form inputs -->
                                    <label for="movie_title">Title</label>
                                    <input type="text" name="title" id="movie_title" class="form-control" required>
                                    <label for="movie_creator">Creator</label>
                                    <input type="text" name="creator" id="movie_creator" class="form-control">
                                    <label for="movie_image">Image</label>
                                    <input type="text" name="image" id="movie_image" class="form-control">
                                    <label for="movie_category">Category</label>
                                    <input type="text" name="category" id="movie_category" class="form-control">
                                    <label for="movie_description">Description</label>
                                    <textarea name="description" id="movie_description" class="form-control"></textarea>
                                    <label for="movie_release_year">Release Year</label>
                                    <input type="text" name="release_year" id="movie_release_year" class="form-control">
                                    <label for="movie_language">Language</label>
                                    <input type="text" name="language" id="movie_language" class="form-control">
                                    <label for="movie_duration">Duration</label>
                                    <input type="time" name="duration" id="movie_duration" class="form-control">
                                    <label for="movie_youtube_link">YouTube Link</label>
                                    <input type="text" name="youtube_link" id="movie_youtube_link" class="form-control">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="submitMovieForm()">Save
                                        changes</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add TV Show Modal -->
                <div class="modal fade" id="addTvShowModal" tabindex="-1" role="dialog"
                    aria-labelledby="addTvShowModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTvShowModalLabel">Add TV Show</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addTVShowForm" action="add_tv_show.php" method="post"
                                enctype="multipart/form-data">
                                <div class="modal-body">
                                    <!-- TV Show form inputs -->
                                    <label for="tv_show_title">Title</label>
                                    <input type="text" name="title" id="tv_show_title" class="form-control" required>
                                    <label for="tv_show_creator">Creator</label>
                                    <input type="text" name="creator" id="tv_show_creator" class="form-control">
                                    <label for="tv_show_image">Image</label>
                                    <input type="text" name="image" id="tv_show_image" class="form-control">
                                    <label for="tv_show_category">Category</label>
                                    <input type="text" name="category" id="tv_show_category" class="form-control">
                                    <label for="tv_show_description">Description</label>
                                    <textarea name="description" id="tv_show_description"
                                        class="form-control"></textarea>
                                    <label for="tv_show_release_year">Release Year</label>
                                    <input type="text" name="release_year" id="tv_show_release_year"
                                        class="form-control">
                                    <label for="tv_show_language">Language</label>
                                    <input type="text" name="language" id="tv_show_language" class="form-control">
                                    <label for="tv_show_num_seasons">Number of Seasons</label>
                                    <input type="number" name="num_seasons" id="tv_show_num_seasons"
                                        class="form-control">
                                    <label for="tv_show_num_episodes">Number of Episodes</label>
                                    <input type="number" name="num_episodes" id="tv_show_num_episodes"
                                        class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="submitTVShowForm()">Save
                                        changes</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- JS Scripts -->
                <script>
                var el = document.getElementById("wrapper");
                var toggleButton = document.getElementById("menu-toggle");

                toggleButton.onclick = function() {
                    el.classList.toggle("toggled");
                };

                function submitMovieForm() {
                    const form = document.getElementById("addMovieForm");
                    const formData = new FormData(form);

                    fetch("add_movie.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Display a Bootstrap alert on success
                            const alertContainer = document.getElementById("alert-container");
                            const alertHTML = `
<div class="alert alert-success alert-dismissible fade show" role="alert">
    Movie added successfully!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

                            alertContainer.innerHTML = alertHTML;

                            // Close the modal and reset the form
                            const addMovieModal = bootstrap.Modal.getInstance(document.getElementById(
                                "addMovieModal"));
                            addMovieModal.hide();
                            form.reset();
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                }

                function submitTVShowForm() {
                    const form = document.getElementById("addTVShowForm");
                    const formData = new FormData(form);

                    fetch("add_tv_show.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Display a Bootstrap alert on success
                            const alertContainer = document.getElementById("alert-container");
                            const alertHTML = `
<div class="alert alert-success alert-dismissible fade show" role="alert">
    TV show added successfully!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`;

                            alertContainer.innerHTML = alertHTML;

                            // Close the modal and reset the form
                            const addTvShowModal = bootstrap.Modal.getInstance(document.getElementById(
                                "addTvShowModal"));
                            addTvShowModal.hide();
                            form.reset();
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                }

                document.getElementById('addMovieModal').addEventListener('hidden.bs.modal', () => {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                });

                document.getElementById('addTvShowModal').addEventListener('hidden.bs.modal', () => {
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                });

                // Per modale EDIT SHOW
                document.addEventListener('DOMContentLoaded', function() {
                    var editShowModal = document.getElementById('editShowModal');
                    editShowModal.addEventListener('show.bs.modal', function(event) {
                        // Get the show ID and type from the Edit link
                        var editButton = event.relatedTarget;
                        var showId = editButton.getAttribute('data-show-id');
                        var showType = editButton.getAttribute('data-show-type');

                        // Load edit form for the show
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState === 4 && this.status === 200) {
                                document.getElementById('editShowModalBody').innerHTML = this
                                    .responseText;
                            }
                        };
                        xhttp.open("GET", "load_edit_form.php?id=" + showId + "&type=" + showType,
                            true);
                        xhttp.send();
                    });
                });

                document.getElementById('saveChangesButton').addEventListener('click', function() {
                    document.querySelector('#editShowModal .modal-body form').submit();
                });
                </script>




</body>


<?php
include('../includes/admin_footer.html');
?>