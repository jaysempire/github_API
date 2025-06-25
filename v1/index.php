<?php 

	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025

   //Security headers
   header( 'Access-Control-Allow-Origin: *' ); 
   header( 'Content-Type: application/json; charset=UTF-8' );
   header( 'Access-Control-Allow-Headers: Authorization, Content-Type' ); 
   //header( 'Access-Control-Allow-Headers: *' ); 
   header( 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS' );
   header( 'Access-Control-Expose-Headers: Content-Disposition' );

  
   //App functions
   include_once( 'config.php' );
   include_once( 'models/Api.php' );

   // Handle preflight requests
   if ( $req_method == 'OPTIONS' ) 
   {
      http_response_code( 200 );
      exit();
   }

   //Creating App instances
   $api = new Api();

   //page name logic
   $uri_arr = explode( '/', $uri );
   $uri_len =  count( $uri_arr );
   $page_starts = $uri_len - 1;
   $page = $uri_arr[ $page_starts ];

   $page_arr = explode( '?', $uri_arr[ $page_starts ] );
   $page = $page_arr[0];
   $page = $api->fixUrl( $page );

   $json_data = null;

   if ( $req_method == 'POST' || $req_method == 'PUT'  ) 
   {
      //Validating
      $json_data = @file_get_contents( 'php://input' );
      $json_data = json_decode( $json_data, true );
      $json_data = ( object ) $json_data;

      if ( !isset( $json_data ) ) 
      {  
         http_response_code( 400 );
         die(
            json_encode( [ 'rsp' => 'ERROR', 'msg' => 'OOPs! Invalid Payload' ] ) 
         );
      }
   }
   else
   {
      $json_data = ( object ) $_GET;
   }
   
   $action = $json_data->action ?? '';
   $page_x = $page . '_api.php';
   $file = "$cur_dir/controllers/$page_x";

   //checking and including file
   if ( is_file( $file ) ) 
   {
      include_once( $file );
   }
   else
   {
      http_response_code( 400 );
      die(
         json_encode( [ 'rsp' => 'ERROR', 'msg' => "OOPs! Invalid Request" ] ) 
      );
   }
?>