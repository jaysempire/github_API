<?php
    include_once( 'models/Player.php' );
	include_once( 'inc/check_auth.php' );
	
	//Creating instances
	$player = new Player();

    try {
        $id = $json_data->id ?? '';
        
        if(!$player->getById([$id])){
            throw new Exception( 'Player doesn\'t Exist!' );
        }
        
        if (!is_numeric($id) || $id < 1) {
            throw new Exception('Invalid ID!');
        }

        if ($player->deleteById([$id])) {
            http_response_code( 200 );
         die(
            json_encode( [ 'rsp' => 'OK', 'msg' => 'Player Successfully deleted!' ] )
         );
        } else {
            throw new Exception('Failed to delete player. Please try again.');
        }

    } catch (Exception $e) {
        http_response_code( 400 );
        die( 
            json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
        );
    }