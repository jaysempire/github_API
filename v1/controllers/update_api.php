<?php
    include_once( 'models/Player.php' );
	include_once( 'inc/check_auth.php' );
	
	//Creating instances
	$player = new Player();

    try {
        $id = $_GET['id'] ?? '';

        if (!is_numeric($id) || $id < 1) {
            throw new Exception('Invalid Player ID!');
        }

        $player_arr = $player->getById([$id]);

        if (!$player_arr) {
            throw new Exception('Player doesn\'t exist!');
        }

        $fullname        = $json_data->fullname        ?? $player_arr['fullname'] ?? '';
        $player_dob      = $json_data->dob             ?? $player_arr['dob'] ?? '';
        $email           = $json_data->email           ?? $player_arr['email'] ?? '';
        $player_position = $json_data->position        ?? $player_arr['position'] ?? '';
        $player_jersey   = $json_data->j_num           ?? $player_arr['j_num'] ?? '';
        $height          = $json_data->height          ?? $player_arr['height'] ?? '';
        $weight          = $json_data->weight          ?? $player_arr['weight'] ?? '';
        $player_state    = $json_data->state           ?? $player_arr['state'] ?? '';
        $player_stats    = $json_data->player_stats    ?? $player_arr['player_stats'] ?? '';
        $status          = isset($json_data->status)
                            ? intval($json_data->status)
                            : (isset($player_arr['status']) ? intval($player_arr['status']) : 0);

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