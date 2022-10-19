<?php
$content = file_get_contents ('php://input');
$update = json_decode ($content, true);
$chat_id = $update['message']['chat']['id'];
$message = $update['message']['text'];
$username = $update['message']['from']['username'];

if ($message == '/start') {
    send_message ($chat_id, "Hey @$username  \nsend me any query to search for the movie.");
} else {
    $req = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=6002be1894b39c1a960f336a79199d78&language=en-US&page=1&query=$message" );
    $movie = json_decode ( $req, true )['results'];
    if ($movie) {
        $movie = $movie[0];
        $title = $movie['title'];
        $overview = $movie['overview'];
        $popularity = $movie['popularity'];
        $release_date = $movie['release_date'];
        $vote_count = $movie['vote_count'];
        send_message($chat_id, "
    	Title: $title
		Description: $overview
		Popularity : $popularity
		Release Date : $release_date
		Votes: $vote_count");
    } 
    else {
        send_message($chat_id, "Couldn't find any movie with that name!");
    }
}

function send_message ($chat_id, $message) {
    $apiToken = getenv("TOKEN");
    $text = urlencode($message);
    file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=$text");
}