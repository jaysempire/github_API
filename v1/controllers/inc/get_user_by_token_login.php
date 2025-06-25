<?php 

	#   Date created: 12/o4/2025
	#   Date modified: 15/04/2025

   //App Functions
   include_once( 'check_auth.php' );
	
	if ( $req_method == 'POST' )
   {
      $access_token = $json_data->access_token ?? '';
      $user_arr = $user->getByTokenLogin( [ $access_token ] );

      if ( $user_arr )
      {
         $user_arr_new[ 'id' ] = $user_arr[ 'id' ];
         $user_arr_new[ 'full_name' ] = $user_arr[ 'full_name' ];
         $user_arr_new[ 'role_id' ] = $user_arr[ 'role_id' ];
         $user_arr_new[ 'access_token' ] = $user_arr[ 'token_login' ]; 
         $user_arr_new[ 'status' ] = $user_arr[ 'status' ]; 

         http_response_code( 200 );
         die(
            json_encode( [ 'rsp' => 'OK', 'data' => $user_arr_new ] ) 
         );
      }
      
      throw new Exception( 'Sorry, no user found!' );
   }
?>