<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025
	
	//App Functions
	include_once( 'models/User.php' );
	
	//Creating instances
	$user = new User();

	try
	{
      $file_x = "$cur_dir/controllers/inc/$action.php";

      if ( is_file( $file_x ) ) 
      {
         include_once( $file_x );
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