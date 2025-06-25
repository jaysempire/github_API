<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025
	
	//App Functions
   include_once( 'inc/check_auth.php' );
   include_once( 'models/Admin.php' );

   $admin = new Admin();
	
	try
	{

      if ( $admin->updateTokenLogoutById( [ null, $bearer_token ] ) )
      {

         http_response_code( 200 );
         die(
            json_encode( [ 'rsp' => 'OK', 'msg' => 'Logout Successful' ] )
         );
      }

      throw new Exception( 'Logout Failed!' );
	}
	catch ( Exception $e ) 
	{
      http_response_code( 400 );
      die( 
         json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
      );
   }
?>