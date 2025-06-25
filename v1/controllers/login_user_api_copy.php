<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025
	
	//App Functions
	include_once( 'models/User.php' );
	
	//Creating instances
	$user = new User();
	
	try
	{
		$uname = $json_data->uname ?? '';
		$pword = $json_data->pword ?? '';

		// Validate inputs
		if ( !$uname && !$pword ) 
		{
			throw new Exception( 'Please, enter username and password.' );
		}
		
		$user_arr = $user->login( [ $uname, $uname ] );
		$user_id = $user_arr[ 'id' ] ?? '';
		$pword_h = $user_arr[ 'pword' ] ?? '';
		
		if ( $user->decPword( $pword, $pword_h ) )
		{
         $bearer_token = $jwt_token = $user_arr[ 'token_login' ];

         include_once( 'libs/php-jwt/JwtClass.php' );

         $jwt = new JwtClass();

         $user_arr_1 = $user->getByTokenLogin( [ $bearer_token ] );
         $jwt_res = null;
         
         if ( $user_arr_1 )
         {
            $jwt_res = $jwt->validateJwt( $server_name, $bearer_token, $user_id );
         }

         if ( empty( $jwt_res ) ) 
         {            
            $jwt_arr = $jwt->generateJwt( $server_name, $user_id );
            $jwt_token = $jwt_arr[ 'token' ] ?? '';
            
            $jwt_token ? $user->updateTokenLoginById( [ $jwt_token, $user_id ] ) : '';
         }

			$user_arr_new[ 'id' ] = $user_id;
			$user_arr_new[ 'full_name' ] = $user_arr_1[ 'full_name' ];
			$user_arr_new[ 'first_name' ] = $user_arr[ 'first_name' ];
         $user_arr_new[ 'middle_name' ] = $user_arr[ 'middle_name' ];
         $user_arr_new[ 'last_name' ] = $user_arr[ 'last_name' ];
         $user_arr_new[ 'access_token' ] = $jwt_token; 
         $user_arr_new[ 'status' ] = $user_arr[ 'status' ]; 
			$user_arr_new[ 'user_role' ] = $user_arr[ 'user_role' ];

			http_response_code( 200 );
			die(
				json_encode( [ 'rsp' => 'OK', 'data' => $user_arr_new ] )
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