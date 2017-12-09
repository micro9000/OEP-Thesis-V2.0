<?php session_start();

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if (isset($_POST['eventCategory']) && !empty($_POST['eventCategory']) &&
		isset($_POST['eventName']) &&  !empty($_POST['eventName']) &&
		isset($_POST['eventAddress']) && !empty($_POST['eventAddress']) &&
		isset($_POST['eventDate']) && !empty($_POST['eventDate']) &&
		isset($_POST['eventDescription']) && !empty($_POST['eventDescription']) ){


		if(! isset($_FILES) && sizeof($_FILES) == 0){
			$results = array("done" => "FALSE", "msg" => "No image selected");

		}else{
			$eventID = $contentObj->insertNewRecentEvent($_POST);

			if ($eventID > 0){

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

					$upload_error_msg = "";

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
								$results = array("done" => "FALSE", "msg" => "Error uploading ". $fileName ." -> ". $file['error']);
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

					// for($i=0; $i<sizeof($images['eventImages']); $i++){

					// 	$file = $images['eventImages'][$i];

					// }

					$results = array("done" => "TRUE", "msg" => "Inserted (". $upload_error_msg .")");
				}else{
					$results = array("done" => "FALSE", "msg" => "No image selected");
				} // if there is file 			
	        } // eventID
		}

	}// isset

	echo json_encode($results);
	exit();
?>