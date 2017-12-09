<?php session_start();

	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$uplaodResults = array("done" => "FALSE", "msg" => "Please enter all required fields");

	if (isset($_POST['title_first']) && 
		isset($_POST['title_second']) && 
		isset($_POST['slideContent']) && 
		isset($_POST['slideID'])){

		if(isset($_FILES) && sizeof($_FILES) > 0){

			$targetFolder = "../../uploads/Slideshow/";

			$validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
									"pspimage", "tga", "thm", "tif", "tiff",
									"yuv", "jif", "jfif", "jp2", "jpx", "j2k", 
									"j2c", "fpx", "pcd");

			$fileName = $_FILES['slideshow_img']['name'];
			$fileTmpName = $_FILES['slideshow_img']['tmp_name'];
			$ext = explode(".", basename($fileName));
			$fileExtension = end($ext);
			$fileSize = $_FILES['slideshow_img']['size'];

			$newFileName = strtoupper(md5(uniqid())) . "." . $ext[count($ext) - 1];
			$target_path = $targetFolder . $newFileName;

			if ($fileSize <= 20000000 && in_array(strtolower($fileExtension) ."", $validExtensions)){

				if (!empty($_FILES['slideshow_img']['error'])){
					$uplaodResults = array("done" => "FALSE",
									"msg" => "Error uploading ". $fileName ." -> ". $_FILES['slideshow_img']['error']);
				}else{
					if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){

						$data = array("firstTitle" => $_POST['title_first'],
									  "secondTitle" => $_POST['title_second'],
									  "content" => $_POST['slideContent'],
									  "imgServerFilename" => $newFileName,
									  "imgOrigFilename" => $fileName, 
									  "slideID" => $_POST['slideID']);

						if ($contentObj->updateSlideshow($data)){

							move_uploaded_file($fileTmpName, $target_path);

							$uplaodResults = array("done" => "TRUE", "msg" => "Updated!");
						}
					}
				}
				
			}
		}else{
			$uplaodResults = array("done" => "FALSE", "msg" => "No image selected");
		}
	}

	echo json_encode($uplaodResults);
	exit();
?>