<?php
	include_once( 'inc/check_auth.php' );
    include_once( 'models/Player.php' );

    $player = new Player();


    try {
        $search = $json_data->searched ?? '';
        $player_arr = [];

        if (!$search) {
            throw new Exception('Please enter a search term!');
        }

        $player_arr = $player->getSearched([$search]);
 
        if (empty($player_arr)) {
            throw new Exception('No matching players found!');
        }

        http_response_code( 200 );
		die(
			json_encode( [ 'rsp' => 'OK', 'data' => $player_arr ] )
		);
    } 
    catch (Exception $e) {
        http_response_code( 400 );
        die( 
            json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
        );
    }