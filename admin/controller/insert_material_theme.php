<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if (isset($_POST['materialsSelect']) && 
		isset($_POST['materialTheme'])){

		if(! isset($_FILES) && sizeof($_FILES) == 0){
			$results = array("done" => "FALSE", "msg" => "No image selected");
		}else{

			$themeID = $contentObj->insertMaterialTheme($_POST['materialTheme'] ,$_POST['materialsSelect']);

			if ($themeID > 0){

				if (isset($_FILES) && sizeof($_FILES) > 0){
					$targetFolder = "../../uploads/Materials/";

					$validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
											"pspimage", "tga", "thm", "tif", "tiff",
											"yuv", "jif", "jfif", "jp2", "jpx", "j2k", 
											"j2c", "fpx", "pcd");

					// $images = $contentObj->reArrayFilesMultiple($_FILES);

					$upload_error_msg = "";

					$i = 1;

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

	                    	}else{
	                    		if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){
		                    		if ($contentObj->insertMaterialThemeImage($themeID, $newFileName, $fileName, $i )){
		                    			if (move_uploaded_file($fileTmpName, $target_path) === false){
		                    				$upload_error_msg .= "<br/>Erorr uploading -> " . $fileName;
		                    			}
		                    		}
		                    	}
	                    	}
	                    }

	                    $i += 1;
					}

					$results = array("done" => "TRUE", "msg" => "Inserted (". $upload_error_msg .")");
				}else{
					$results = array("done" => "FALSE", "msg" => "No image selected");
				}

			}
		}
	}

	echo json_encode($results);
	exit();
?>