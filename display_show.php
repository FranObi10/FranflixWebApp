<!-- display_show.php -->

<?php

session_start();

function convert_youtube_link($link) {
    $video_id = str_replace('https://www.youtube.com/watch?v=', '', $link);
    return 'https://www.youtube.com/embed/' . $video_id;
}

$page_title = 'Tv show Details';
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    require('functionality/login_tools.php');
    load();
}

require('functionality/connect_db.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    $q = "SELECT * FROM tv_shows WHERE id=$id";
    $r = mysqli_query($connection, $q);
    if ($r) {
        if (mysqli_num_rows($r) == 1) {
            $tv_show = mysqli_fetch_array($r, MYSQLI_ASSOC);

            $_GET['tv_show_id'] = $id; // Move this line here
            require('fetch_episodes.php'); // Move this line here as well

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}

?>

<main id="main">
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="video-overlay-container">
            <div class="image-wrapper">
                <img src="<?= $tv_show['image'] ?>" alt="<?= $tv_show['title'] ?>" />
            </div>
            <div class="overlay">
                <div class="movie-details">
                    <h1><?= $tv_show['title'] ?></h1>
                    <h4>(<?= $tv_show['release_year'] ?>), <?= $tv_show['category'] ?></h4>
                    <hr>
                    <h5 class="mb-4"><?= $tv_show['description'] ?></h5>
                    <h4>(<?= $tv_show['num_seasons'] ?>), <?= $tv_show['num_episodes'] ?></h4>
                    <div class="mt-5">

                        <div id="upgradeAlert" class="alert alert-warning alert-dismissible fade" role="alert"
                            style="display: none;">
                            You need to <a href="join_membership.php">upgrade your membership</a> to watch the full
                            movie.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>


                        <!-- Add season and episode selection -->
                        <div class="dropdown-container">
                            <label for="season">Season:</label>
                            <select id="season">
                                <?php for ($i = 1; $i <= $tv_show['num_seasons']; $i++): ?>
                                <option value="<?= $i ?>">Season <?= $i ?></option>
                                <?php endfor; ?>
                            </select>

                            <label for="episode">Episode:</label>
                            <select id="episode">
                                <?php for ($i = 1; $i <= $tv_show['num_episodes']; $i++): ?>
                                <option value="<?= $i ?>">Episode <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <button id="loadEpisode" class="btn-play">Load Episode</button>
                        </div>
                        <div id="episodeContainer"></div>

                        <?php if ($_SESSION['user_role'] != 'registered') : ?>
                        <button id="likeButton" class="btn-like"
                            data-tvshow-id="<?= $tv_show['id'] ?>">&#x2665;</button>
                        <?php endif; ?>
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

.dropdown-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-play {
    background-color: #f05454;
    border: none;
    color: white;
    padding: 5px 10px;
    cursor: pointer;
    font-weight: bold;
}

#episodeContainer iframe {
    width: 100%;
    height: 500px;
}
</style>

<script>
function extractVideoUrl(responseText) {
    var parser = new DOMParser();
    var htmlDoc = parser.parseFromString(responseText, "text/html");
    var iframeElement = htmlDoc.querySelector("iframe");
    return iframeElement ? iframeElement.src : null;
}



function createVideoPlayer(videoSrc, tvShowTitle) {
    if (!videoSrc) {
        console.error("Failed to extract video URL");
        return;
    }

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
        videoContainer.remove();
        textElement.remove(); // Remove the text element when the video is closed
    };

    var videoContainer = document.createElement("div");
    videoContainer.style.position = "relative";
    videoContainer.style.width = "100%";
    videoContainer.style.height = "500px";
    videoContainer.style.marginTop = "50px";
    videoContainer.appendChild(iframe);
    videoContainer.appendChild(closeButton);

    // Add the text element before the video
    var textElement = document.createElement("h2");
    textElement.innerHTML = "Enjoy this episode of " + tvShowTitle;
    textElement.style.marginTop = "50px";
    textElement.style.color = "white";

    var mainElement = document.getElementById("main");
    mainElement.parentNode.insertBefore(textElement, mainElement.nextSibling);
    mainElement.parentNode.insertBefore(videoContainer, textElement.nextSibling);
}

function showUpgradeAlert() {
    var upgradeAlert = document.getElementById("upgradeAlert");

    upgradeAlert.style.display = "block";
    upgradeAlert.classList.add("show");
}

document.getElementById("loadEpisode").addEventListener("click", function() {
    var userRole = '<?= $_SESSION['user_role'] ?>';
    if (userRole === 'registered') {
        showUpgradeAlert();
    } else {
        var season = document.getElementById("season").value;
        var episode = document.getElementById("episode").value;
        var tv_show_id = <?= $tv_show['id'] ?>;
        var tvShowTitle = '<?= addslashes($tv_show['title']) ?>';

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "load_episode.php?tv_show_id=" + tv_show_id + "&season=" + season + "&episode=" +
            episode, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var videoSrc = extractVideoUrl(xhr.responseText);
                createVideoPlayer(videoSrc, tvShowTitle);
            }
        };
        xhr.send();
    }
});

document.getElementById("likeButton").addEventListener("click", function() {
    var userRole = '<?= $_SESSION['user_role'] ?>';
    var likeButton = document.getElementById("likeButton");

    if (userRole === 'registered') {
        showUpgradeAlert();
    } else {
        var tvShowId = <?= $tv_show['id'] ?>;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functionality/like_tv_show.php", true);
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
        xhr.send("content_id=" + tvShowId);
    }
});
</script>



</main><!-- End #main -->

<?php include('includes/footer.html');
?>