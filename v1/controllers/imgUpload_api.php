<?php

    include_once( 'inc/check_auth.php' );
    include_once( 'models/Player.php' );
	
	//Creating instances
	$player = new Player();

    try {
        $id = $_GET['id'] ?? '';
		$player_arr = $player->getById([$id]);

        if (!$player_arr) {
            throw new Exception( 'Player doesn\'t Exist!' );
    	}

        $ref_no = $player_arr['player_ref_No'];
        $file_name = $player_arr['img'] ?? '';

        if (isset($_FILES['player_image']) && $_FILES['player_image']['error'] === UPLOAD_ERR_OK) {

			$file_base_name = $ref_no;

			if (!empty($file_name)) {

				$existing_img_path = "$upload_dir/photos/" . $file_name;

				if (file_exists($existing_img_path)) {
					unlink($existing_img_path);
				}
			}

			$file_upload = $player->fileUpload("$upload_dir/photos", $_FILES['player_image'], $file_base_name);

			if ($file_upload['status']) {
                
				$file_name = $file_upload['file_name'];
				$dt = [$file_name, $ref_no];
				$player->updateImg($dt);

                http_response_code( 200 );
                die(
                    json_encode( [ 'rsp' => 'OK', 'msg' => 'Image Successfully Uploded!' ] )
                );

			} else {
                throw new Exception( $file_upload['msg'] );
			}

		} else {
            throw new Exception('No image selected or upload error.');
		}
        
    } catch (Exception $e) {
         http_response_code( 400 );
        die( 
            json_encode( [ 'rsp' => 'ERROR', 'msg' => $e->getMessage() ] )
        );
    }