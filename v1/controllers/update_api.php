<?php
    include_once( 'models/Player.php' );
	include_once( 'inc/check_auth.php' );
	
	//Creating instances
	$player = new Player();

    try {
        $id = $_GET['id'] ?? '';

        if(!$player->getById([$id])){
            throw new Exception( 'Player doesn\'t Exist!' );
        }

        if (!is_numeric($id) || $id < 1) {
            throw new Exception('Invalid Player ID!');
        }

        $fullname        = $json_data->fullname        ?? '';
        $player_dob      = $json_data->dob             ?? '';
        $email           = $json_data->email           ?? '';
        $player_position = $json_data->position        ?? '';
        $player_jersey   = $json_data->j_num           ?? '';
        $height          = $json_data->height          ?? '';
        $weight          = $json_data->weight          ?? '';
        $player_state    = $json_data->state           ?? '';
        $player_stats    = $json_data->player_stats    ?? '';
        $status          = isset($json_data->status) ? intval($json_data->status) : 0;

        if ( !$fullname && !$player_dob && !$email && !$player_position && !$player_jersey && !$height && !$weight && !$player_state && !$player_stats ) 
		{
			throw new Exception( 'Please, Enter Required Fields.' );
		}

        $dt_01 = [ $fullname, $email, $player_dob, $height, $weight, $player_position, $player_jersey, $player_state, $player_stats, $status, $id ];

        if ($player->updatePlayer($dt_01)) {
            http_response_code( 200 );
         die(
            json_encode( [ 'rsp' => 'OK', 'msg' => 'Player Successfully Updated!' ] )
         );
        }else {
            throw new Exception('Failed To Update Player. Please Try Again.');
        }
    } catch (Exception $e) {
        http_response_code( 400 );
        die( 
            json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
        );
    }