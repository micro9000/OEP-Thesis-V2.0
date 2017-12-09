<?php session_start();

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	// print_r($_POST);
	// exit();

	if (isset($_POST['eventCategory']) && isset($_POST['eventName']) &&  
		isset($_POST['eventAddress']) && isset($_POST['eventDate']) &&
		isset($_POST['eventDescription']) && isset($_POST['eventID'])){


		if(! isset($_FILES) && sizeof($_FILES) == 0){
			$results = array("done" => "FALSE", "msg" => "No image selected");

		}else{

			$affectedRow = $contentObj->updateRecentEvent($_POST);

			$eventID = $_POST['eventID'];

			$upload_error_msg = "";

			if ($affectedRow > 0){

	            if(isset($_FILES) && sizeof($_FILES) > 0){

					$targetFolder = "../../uploads/Events/";

					$validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
											"pspimage", "tga", "thm", "tif", "tiff",
											"yuv", "jif", "jfif", "jp2", "jpx", "j2k", 
											"j2c", "fpx", "pcd");

					//$images = $contentObj->reArrayFilesMultiple($_FILES);

					// echo "<pre>";
					// 	print_r($images);
					// 	echo "</pre>";

					foreach($_FILES as $index => $file){

						$fileName = $file['name'];
	                    $fileTmpName = $file['tmp_name'];
	                    $ext = explode('.', basename($file['name']));
	                    $fileExtension = end($ext);
	                    $fileSize = $file['size'];

	                    $newFileName = strtoupper(md5(uniqid())) . "." . $ext[count($ext) - 1];
	                    $target_path = $targetFolder . $newFileName;

	                    if ($fileSize <= 20000000 && in_array(strtolower($fileExtension) ."", $validExtensions)){

	                    	if (!empty($file['error'][$index])){

	                    		$upload_error_msg .= "<br/>Error uploading ". $fileName ." -> ". $file['error'];

	                    	}else{
	                    		if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){

		                    		if ($contentObj->insertNewRecentEvent_Image($eventID, $newFileName, $fileName)){
		                    			if (move_uploaded_file($fileTmpName, $target_path) === false){
		                    				$upload_error_msg .= "<br/>Erorr uploading -> " . $fileName;
		                    			}
		                    		}
		                    	}
	                    	}
	                    }
					}
				}

				$results = array("done" => "TRUE", "msg" => "Updated (". $upload_error_msg .")");
	        } // eventID

	        
		}

	}// isset

	echo json_encode($results);
	exit();
?>