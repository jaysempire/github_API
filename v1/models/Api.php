<?php
   #   Date created: 09/04/2025
	#   Date modified: 15/04/2025

	include_once( 'Db.php' );

	class Api
	{
		//using Namespaces
		use Db {
      	Db::__construct as private __appConst;
    	}

		function __construct()
	 	{
	 		$this->__appConst();
	 	}

		function fixUrl( $page ) 
		{
			$page = strtolower( $page );
			return str_replace( '-', '_', $page );
		}
		
      function setHeaders( $headers_x )
		{
			/* if ( $headers_x )
			{
            $headers_x[] = '';
			} */

			$headers_x[] = 'accept: application/json';

			return $headers_x;
		}
    
		function generateRefNo( $code = 'SH-', $count = 1 )
		{
			$count += 1;
			$length = max(4, strlen((string)$count));
			$padded_count = str_pad($count, $length, '0', STR_PAD_LEFT);
			return $code . $padded_count;
		}

	}
?>