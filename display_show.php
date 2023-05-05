<?php
# Access session.
session_start();

function convert_youtube_link($link) {
    $video_id = str_replace('https://www.youtube.com/watch?v=', '', $link);
    return 'https://www.youtube.com/embed/' . $video_id;
}

# Set page title and display header section.
$page_title = 'TV Show Details';

include('includes/header.php');

# Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    require('functionality/login_tools.php');
    load();
}

# Open database connection.
require('functionality/connect_db.php');

# Retrieve TV show details.
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $q = "SELECT * FROM tv_shows WHERE id=$id";
    $r = mysqli_query($connection, $q);
    if ($r) {
        if (mysqli_num_rows($r) == 1) {
            $show = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $creator = $show['creator'];
            $release_year = $show['release_year'];
            $language = $show['language'];
            $num_seasons = $show['num_seasons'];
            $num_episodes = $show['num_episodes'];
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
            include('includes/footer.html');
            exit();
        }
    } else {
        echo '<p class="error">This page has been accessed in error.</p>';
        include('includes/footer.html');
        exit();
    }
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    include('includes/footer.html');
    exit();
}

# Handle form submission.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Code to handle form submission here.
    # Redirect to appropriate page upon completion.
}

?>

<main id="main">
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="video-overlay-container">
            <div class="image-wrapper">
                <img src="<?= $show['image'] ?>" alt="<?= $show['title'] ?>" />
            </div>
            <div class="overlay">
                <div class="show-details">
                    <h1><?= $show['title'] ?></h1>
                    <h4>(<?= $show['release_year'] ?>), <?= $show['category'] ?></h4>
                    <hr>
                    <h5 class="mb-4" style="margin-bottom: 20px;"><?= $show['description'] ?></h5>
                    <?php
                    $duration_minutes = $num_episodes * 30;
                    ?>
                    <h6><strong>Duration:</strong> <?= $duration_minutes ?> minutes, <strong>Language:</strong>
                        <?= $show['language'] ?></h6>
                    <h6><strong>Creator:</strong> <?= $show['creator'] ?></h6>
                    <h6><strong>Number of seasons:</strong> <?= $show['num_seasons'] ?></h6>
                    <h6><strong>Number of episodes:</strong> <?= $show['num_episodes'] ?></h6>

                    <div id="upgradeAlert" class="alert alert-warning alert-dismissible fade" role="alert"
                        style="display: none;">
                        You need to <a href="join_membership.php">upgrade your membership</a> to watch the full show.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="mt-5">
                        <button id="playButton" class="btn-play">PLAY SHOW</button>
                        <button id="likeButton" class="btn-like" data-show-id="<?= $show['id'] ?>">&#x2665;</button>
                    </div>
                </div>
            </div>
    </section><!-- End Hero -->
</main>

<style>
#hero {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    max-height: 1000px;
    position: relative;
    overflow: hidden;
}
</style>

        <!-- Js Scrips to manage video and like system -->
<script>
function showUpgradeAlert() {
    var upgradeAlert = document.getElementById("upgradeAlert");

    upgradeAlert.style.display = "block";
    upgradeAlert.classList.add("show");
}

document.getElementById("playButton").addEventListener("click", function() {
    var userRole = '<?= $_SESSION['user_role'] ?>';

    if (userRole === 'registered') {
        showUpgradeAlert();
    } else {
        var videoSrc = '<?= convert_youtube_link($show["youtube_link"]) ?>' + "?autoplay=1";
        var iframe = document.createElement("iframe");
        iframe.src = videoSrc;
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.style.width = "100%";
        iframe.style.height = "100%";

        var closeButton = document.createElement("button");
        closeButton.innerHTML = "Close";
        closeButton.style.position = "absolute";
        closeButton.style.top = "20px";
        closeButton.style.right = "20px";
        closeButton.style.zIndex = "1001";
        closeButton.style.backgroundColor = "#ff0071";
        closeButton.style.color = "white";
        closeButton.style.border = "none";
        closeButton.style.padding = "10px 20px";
        closeButton.style.borderRadius = "4px";
        closeButton.style.cursor = "pointer";
        closeButton.onclick = function() {
            fullscreenDiv.remove();
        };

        var fullscreenDiv = document.createElement("div");
        fullscreenDiv.style.position = "fixed";
        fullscreenDiv.style.top = "0";
        fullscreenDiv.style.left = "0";
        fullscreenDiv.style.width = "100%";
        fullscreenDiv.style.height = "100%";
        fullscreenDiv.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
        fullscreenDiv.style.zIndex = "1000";
        fullscreenDiv.style.display = "flex";
        fullscreenDiv.style.justifyContent = "center";
        fullscreenDiv.style.alignItems = "center";
        fullscreenDiv.appendChild(iframe);
        fullscreenDiv.appendChild(closeButton);

        document.body.appendChild(fullscreenDiv);
    }
});

document.getElementById("likeButton").addEventListener("click", function() {
    var userRole = '<?= $_SESSION['user_role'] ?>';
    var likeButton = document.getElementById("likeButton");

    if (userRole === 'registered') {
        showUpgradeAlert();
    } else {
        var showId = <?= $show['id'] ?>;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "like_show.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (likeButton.classList.contains("liked")) {
                    likeButton.classList.remove("liked");
                } else {
                    likeButton.classList.add("liked");
                }
            }
        };
        xhr.send("show_id=" + showId);
    }
});
</script>
</main><!-- End #main -->
<?php include('includes/footer.html'); ?>