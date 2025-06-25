<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025
	
	//App Functions
	include_once( 'models/Admin.php' );
	
	//Creating instances
	$admin = new Admin();
	
	try
	{
		$uname = $json_data->uname ?? '';
		$pword = $json_data->pword ?? '';

		// Validate inputs
		if ( !$uname && !$pword ) 
		{
			throw new Exception( 'Please, enter username and password.' );
		}
		
		$admin_arr = $admin->login( [ $uname, $uname ] );
		$admin_id = $admin_arr[ 'id' ] ?? '';
		$pword_h = $admin_arr[ 'pword' ] ?? '';
		
		if ( $admin->decPword( $pword, $pword_h ) )
		{
         	$bearer_token = $admin->encPword($admin_id);

			if ( $bearer_token ) 
			{    
				// to do:  create a column - bearer token      
				$admin->updateTokenLoginById( [ $bearer_token, $admin_id ] );
			}

			$admin_arr_new[ 'id' ] = $admin_id;
			$admin_arr_new[ 'user_name' ] = $admin_arr[ 'user_name' ];
			$admin_arr_new[ 'access_token' ] = $bearer_token; 
			$admin_arr_new[ 'status' ] = $admin_arr[ 'status' ];

			http_response_code( 200 );
			die(
				json_encode( [ 'rsp' => 'OK', 'data' => $admin_arr_new ] )
			);
		}
		else
		{
			throw new Exception( 'Login Failed!' );
		}
	}
	catch ( Exception $e ) 
	{
      http_response_code( 400 );
      die( 
         json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
      );
   }
?>