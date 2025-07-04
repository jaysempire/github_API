<?php
	#   Author of the script
	#   Name: Ezra Adamu
	#   Email: ezra00100@gmail.com
	#   Date created: 08/02/2024
   #   Date modified: 28/08/2024

	trait File
	{
		function folderExist( $dir )
		{
			if ( is_dir( $dir ) ) {
				return true;
			}
		}
		
		function fileExtension( $fname, $type = '' )
		{
		  	$file_ext = pathinfo( $fname, PATHINFO_EXTENSION );
			$file_ext = strtolower( $file_ext );

			//Checking Extension
			return $this->extensionExist( $file_ext, $type );
		}

		function extensionExist( $fext, $type = '' )
		{
			$file_ext = [];

			if ( $type == 'image' ) 
			{
				//for images
				$file_ext = [ 'png', 'jpg', 'jpeg' ];
			}
			else if ( $type == 'audio' ) 
			{
				$file_ext = [ 'mp3' ];
			}
			else if ( $type == 'excel' ) 
			{
				$file_ext = [ 'csv', 'xls', 'xlsx' ];
			}
			
			if ( in_array( $fext, $file_ext ) || $type == 'all' )
			{
				return $fext;
			}
		}

		function fileSizeX( $file_size, $max_size )
		{
		 	//if file is in range
			if ( $file_size <= $max_size )
			{
				return true;
			}
		}

		function uploadFile( $tmpFile, $fileName )
		{
			if ( move_uploaded_file( $tmpFile, $fileName ) )
			{
				return $fileName;
			}
		}

		function emptyFolder( $dir, $file_name = '' )
		{
			//empty uploads folder
         $uploaded_files_arr = glob( $dir . '/*' );

         if ( !empty( $uploaded_files_arr ) )
         {
            foreach ( $uploaded_files_arr as $up_file_arr )
            {
					if ( $file_name )
					{
						$fname = basename( $up_file_arr );

						if ( str_contains( $fname, $file_name ) )
						{
							@unlink( $up_file_arr );
							break;
						}

						continue;
					}
					
               @unlink( $up_file_arr );
            }
         }
		}
		
		function createNewFolder( $dir )
		{
			if ( !$this->folderExist( $dir ) ) 
			{
				//create folder
				mkdir( "$dir/", 0755 );
			}
		}

		function fileUpload( $dir, $file, $file_name_x = '' )
		{
			//Validating inputs
			$res = [];
			$file_name = $file['name'];
			$file_tmp = $file['tmp_name'];
			$file_size = $file['size'];

			$this->createNewFolder( $dir );
			$file_ext = $this->fileExtension( $file_name, 'image' );

			if ( $file_ext )
			{
				//1024KB = 1024000B 
				$size_check = $this->fileSizeX( $file_size, $max_size = 1024000 );
           		$file_up = '';

				if ( $size_check )
				{
					$file_name = $file_name_x ? $file_name_x : date( 'ymdhmsi' ); 
		
					$file_name .= ".$file_ext";
					$file_x = "$dir/$file_name";
					$file_up = $this->uploadFile( $file_tmp, $file_x );
				}
				else
				{
					$res = [ 'status' => false, 'msg' => 'Sorry, File Size is Too Large ( It should not be more than 1 MB )'  ];
				}

				if ( $file_up ) 
				{
					$res = [ 'status' => true, 'file_name' => $file_name ];
				}
			}
			else
			{
				$res = [ 'status' => false, 'msg' => 'Sorry, Failed to upload File.' ];
			}
        	
			return $res;
		}

		function getFolderFiles( $folder, $file_name = '' )
		{
			$data = [];

			if ( $file_name )
			{
				$files_arr = glob( $folder . "/$file_name.*" );
				$data = $files_arr;
			}
			else
			{
				$files_arr = glob( $folder . '/*' );
				sort( $files_arr );
				$data[ 'files_arr' ] = $files_arr;
				$data[ 'files_count' ] = count( $files_arr ) ?? 0;
			}

			return $data;
		}

		function csvUpload( $dir, $file )
		{
			//Validating inputs
			$file_name = $file['name'];
			$file_tmp = $file['tmp_name'];

			if ( !$this->folderExist( $dir ) )
        	{
				return [ 'status' => false, 'msg' => 'Sorry, Invalid Folder!' ];
        	}

			$this->emptyFolder( $dir );

			$file_ext = $this->fileExtension( $file_name, 'excel' );
			$file_name = date( 'ymdhmsi' );
        	$file_name .=  '_csv_upload.' . $file_ext;
			$file_x =  "$dir/$file_name";
			$file_up =  $this->uploadFile( $file_tmp, $file_x );

			if ( $file_up ) 
			{
				$res = [ 'status' => true, 'file_name' => $file_name ];
			}
			else
			{
				$res = [ 'status' => false, 'msg' => 'Sorry, Failed to upload File' ];
			}
        	
			return $res;
		}

	}
?>