<?php
	include_once( 'inc/check_auth.php' );
	include_once( 'models/Player.php' );

    $player = new Player();


    try {
        $id = $json_data->id ?? '';

        $player_upd = $player->getById([$id]);

        if(!$player_upd){
            throw new Exception( 'Player doesn\'t Exist!' );
        }
        
        if (!is_numeric($id) || $id < 1) {
            throw new Exception('Invalid ID!');
        }

        $status = $player_upd['status'] ?? null;

        if ($status == 0) {
            $status_new = 1;
            $msg = 'Activated';

        }elseif ($status == 1) {
            $status_new = 0;
            $msg = 'Deactivated';
        }

        if ($player->updateById([$status_new, $id])) {
            http_response_code( 200 );
         die(
            json_encode( [ 'rsp' => 'OK', 'msg' => "Player Successfully $msg!" ] )
         );
        } else {
            throw new Exception("Failed to $msg Player. Please try again.");
        }

    } 
    catch (Exception $e) {
        http_response_code( 400 );
        die( 
            json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
        );
    }