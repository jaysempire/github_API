<?php
	#   Date created: 09/04/2025
	#   Date modified: 15/04/2025

	const ENVIRONMENT = 'Test';//Test Live

	//DB Config
	const HOST = 'localhost';
	const USER = 'root';
	const PWORD = '';
	const DB = 'duza_db';

	const DB_TABLE_ADMIN = 'admins';
   	const DB_TABLE_PLAYER = 'players';
   	const DB_TABLE_PRODUCT = 'products';

	const WEBSITE_TITLE = '';
	const APP_SESS_TIME = 30000;

	$req_method = $_SERVER['REQUEST_METHOD'];


	//url
   $server_name = ENVIRONMENT == 'Test' ? 'http://' : 'https://';
   $server_name .= $_SERVER['SERVER_NAME'];
   $uri = $_SERVER['REQUEST_URI'];
   $app_url = ( strlen( $uri ) > 1 ) ? "$server_name$uri" : "$server_name";
   
   //directory
   $root_dir = dirname( __DIR__ );
   $cur_dir = dirname( __FILE__ );


   $website_url = 'http://localhost:8080';

   $upload_dir = "$cur_dir/uploads";
   //$admin_email = 'test@mail.com';
?>