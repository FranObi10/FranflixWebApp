<!-- /**
* Returns a JSON-encoded array of episodes for a given TV show ID and season.
*
* @Francesca Obino
* @Franflix WebApp
*/ -->
<?php
header('Content-Type: application/json');

require('functionality/connect_db.php');

if (isset($_GET['tv_show_id']) && isset($_GET['season'])) {
    $tv_show_id = $_GET['tv_show_id'];
    $season = $_GET['season'];

    $q = "SELECT * FROM episodes WHERE tv_show_id = $tv_show_id AND season = $season";
    $r = mysqli_query($connection, $q);

    $episodes = array();
    while ($episode = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        $episodes[] = $episode;
    }

    echo json_encode($episodes);
} else {
    echo json_encode(array('error' => 'Invalid parameters'));
}
?>