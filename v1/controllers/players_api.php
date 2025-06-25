<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025
	
	//App Functions
	include_once( 'models/Player.php' );
	include_once( 'inc/check_auth.php' );
	
	//Creating instances
	$player = new Player();
	
	try
	{
		$id = $json_data->id ?? '';
		$limit = $json_data->limit ?? 1000;
		$player_arr = [];

		// Validate inputs
		if ( $id ) 
		{
			$player_arr = $player->getById( [$id] );
			/* $admin_arr_new[ 'id' ] = $admin_id;
				$admin_arr_new[ 'user_name' ] = $admin_arr[ 'user_name' ];
				$admin_arr_new[ 'access_token' ] = $bearer_token; 
				$admin_arr_new[ 'status' ] = $admin_arr[ 'status' ]; */
		}
		elseif ($limit && !$id) {
			# code...
			$player_arr = $player->getAllWithLimit($limit);
		}
		else {
			throw new Exception( 'Please, Enter Required Field.' );
		}

		if (!$player_arr) {
	
			throw new Exception( 'No Records Found!' );
		}


		http_response_code( 200 );
		die(
			json_encode( [ 'rsp' => 'OK', 'data' => $player_arr ] )
		);
	}
	catch ( Exception $e ) 
	{
      http_response_code( 400 );
      die( 
         json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
      );
   }
?>