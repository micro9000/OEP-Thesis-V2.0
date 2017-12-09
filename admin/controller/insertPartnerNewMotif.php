<?php session_start();
	
	// print_r($_FILES);
	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['motifTheme']) && !empty($_POST['motifTheme']) &&
			isset($_POST['prodCatID']) && !empty($_POST['prodCatID']) && 
			isset($_POST['partnerID']) && !empty($_POST['partnerID'])){

			$partnerID = $_POST['partnerID'];
			$theme = $_POST['motifTheme'];
			$prodCatID = $_POST['prodCatID'];

			if (! isset($_FILES) && sizeof($_FILES) <= 0){
				$results = array("done" => "FALSE", "msg" => "Please add image/s");

			}else{

				$motifID = $contentObj->insertPartnerNewMotif($theme, $partnerID, $prodCatID);

				if (isset($motifID) && $motifID > 0){

					if (isset($_FILES) && sizeof($_FILES) > 0){
						$targetFolder = "../../uploads/PartnersMotif/";

						$validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
											"pspimage", "tga", "thm", "tif", "tiff",
											"yuv", "jif", "jfif", "jp2", "jpx", "j2k", 
											"j2c", "fpx", "pcd");

						// $images = $contentObj->reArrayFilesMultiple($_FILES);

						$upload_error_msg = "";

						$i = 0;

						foreach($_FILES as $index => $file){

							$fileName = $file['name'];
		                    $fileTmpName = $file['tmp_name'];
		                    $ext = explode('.', basename($file['name']));
		                    $fileExtension = end($ext);
		                    $fileSize = $file['size'];

		                    $newFileName = strtoupper(md5(uniqid())) . "." . $ext[count($ext) - 1];
	                    	$target_path = $targetFolder . $newFileName;

	                    	if ($fileSize <= 20000000 && in_array(strtolower($fileExtension) ."", $validExtensions)){

	                    		if (!empty($file['error'])){
	                    			$results = array("done" => "FALSE", "msg" => "Error uploading ". $fileName ." -> ". $file['error']);
		                    	}

		                    	if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){

		                    		if ($contentObj->insertPartnerMotifImage($motifID, $newFileName, $fileName, intval($i + 1))){
		                    			if (move_uploaded_file($fileTmpName, $target_path)){
		                    				
		                    			}else{
		                    				$upload_error_msg .= "<br/>Error uploading -> " . $fileName;
		                    			}
		                    		}
		                    	}
	                    	}

	                    	$i += 1;
						}

						// for($i=0; $i<sizeof($images['motifImages']); $i++){

						// 	$file = $images['motifImages'][$i];

						// }

						$results = array("done" => "TRUE", "msg" => "Inserted (". $upload_error_msg .")");
					}
					else{
						$results = array("done" => "FALSE", "msg" => "Please add image/s");
					}
				}
			}

		}
	}

	echo json_encode($results);
	exit();
?>