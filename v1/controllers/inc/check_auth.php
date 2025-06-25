<?php 
	#   Date created: 09/04/2025
	#   Date modified: 09/04/2025

	//App Functions
	include_once( 'models/Admin.php' );

	if ( !isset( $admin ) )
	{
		$admin = new Admin();
	}

	try
	{	
		$req_headers = getallheaders();
		$req_headers = array_change_key_case( $req_headers, CASE_UPPER );

		if ( isset( $req_headers[ 'AUTHORIZATION' ] ) ) 
		{
			$auth_header = $req_headers[ 'AUTHORIZATION' ];

			// Split the header to get the bearer token
			if ( preg_match( '/bearer\s(\S+)/i', $auth_header, $matches ) ) 
			{
				//check if $bearer_token has expired
				$bearer_token = $matches[ 1 ];
				
				//to do: select all by admin token
				if ( !$bearer_token ) 
				{
					throw new Exception( 'Access Token Expired/Invalid!' );
				}
			} 
			else 
			{
				throw new Exception( 'Authorization header does not contain a Bearer token.' );
			}
		} 
		else 
		{
			throw new Exception( 'Authorization header is missing.' );
		}
	}
	catch ( Exception $e ) 
	{
      http_response_code( 401 );
      die( 
         json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
      );
   }
?>