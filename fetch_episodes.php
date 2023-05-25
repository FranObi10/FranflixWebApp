<?php
require('functionality/connect_db.php');

function fetch_episodes($tv_show_id, $season, $episode) {
    $api_key = 'AIzaSyCTYHaMMJLIC_GAZzL0akn6X8T3fHkAMYs';

    function search_youtube($query, $api_key) {
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=1&q=" . $query . "&key=" . $api_key;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response_json = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        
        curl_close($ch);
        
        $response = json_decode($response_json, true);
    
        if (!isset($response['items'])) {
            echo "Error: items not found in response. Response: ";
            print_r($response);
            return [];
        }
    
        $video_ids = [];
        foreach ($response['items'] as $item) {
            $video_ids[] = $item['id']['videoId'];
        }
    
        return $video_ids;
    }
    

    function get_tv_show_title_by_id($id) {
        // Replace this with your own database connection code
        require('functionality/connect_db.php');

        $id = mysqli_real_escape_string($connection, $id);
        $q = "SELECT title FROM tv_shows WHERE id=$id";
        $r = mysqli_query($connection, $q);

        if ($r) {
            if (mysqli_num_rows($r) == 1) {
                $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
                return $row['title'];
            }
        }

        return null;
    }

    function search_episodes($tv_show_id, $season, $episode, $api_key) {
        $tv_show_title = get_tv_show_title_by_id($tv_show_id); // You need to implement this function
        $query = urlencode($tv_show_title . ' season ' . $season . ' episode ' . $episode);
        $video_ids = search_youtube($query, $api_key);

        if (!empty($video_ids)) {
            return array(
                'season_number' => $season,
                'episode_number' => $episode,
                'video_id' => $video_ids[0]
            );
        }

        return null;
    }

    // Fetch the season and episode numbers from the GET parameters
    $season = $_GET['season'] ?? null;
    $episode = $_GET['episode'] ?? null;
    $tv_show_id = $_GET['tv_show_id'] ?? null; // Add this line

    if ($tv_show_id === null || $season === null || $episode === null) {
        echo "TV Show ID, season, or episode number not provided";
        exit();
    }

    $search_result = search_episodes($tv_show_id, $season, $episode, $api_key);

    if ($search_result !== null) {
        echo "Season {$search_result['season_number']}, Episode {$search_result['episode_number']}: ";
        echo "<iframe src='https://www.youtube.com/embed/{$search_result['video_id']}'></iframe>";
    } else {
        echo "Episode not found";
    }
}
?>