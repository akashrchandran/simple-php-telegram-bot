<?php
$content = file_get_contents ( 'php://input' );
$update = json_decode ( $content, true );
$chat_id = $update[ 'message' ][ 'chat' ][ 'id' ];
$message = $update[ 'message' ][ 'text' ];
$id = $update[ 'message' ][ 'from' ][ 'id' ];
$username = $update[ 'message' ][ 'from' ][ 'username' ];
$firstname = $update[ 'message' ][ 'from' ][ 'first_name' ];
$message_id = $upadte[ 'message' ][ 'message_id' ];
if ( $message == '/start' ) {
    send_message ( $chat_id, "Hey $firstname  \nsend me any query to search for the movie." );
} else {
    $req = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=6002be1894b39c1a960f336a79199d78&language=en-US&page=1&query=$message" );
    $movie = json_decode ( $req, true )[ 'results' ];
    if ($movie) {
        $movie = $movie[ 0 ];
        $title = $movie[ 'title' ];
        $overview = $movie[ 'overview' ];
        $popularity = $movie[ 'popularity' ];
        $release_date = $movie[ 'release_date' ];
        $vote_count = $movie[ 'vote_count' ];
        send_message ( $chat_id, "
    	Title: $title
		Description: $overview
		Popularity : $popularity
		Release Date : $release_date
		Votes: $vote_count" );
    } else {
        send_message ( $chat_id, "Couldn't find any movie with that name!" );
    }
}

function
send_message ( $chat_id, $message )
 {
    $apiToken = '5764369583:AAGU-LI1w5-OHs0oeSwtnbzvIbV2xGoWvMw';
    $text = urlencode ( $message );
    file_get_contents
    ( "https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&text=$text" );
}