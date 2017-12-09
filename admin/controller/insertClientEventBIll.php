<?php session_start();
	// print_r($_POST);
	// print_r($_FILES);

	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter all required fields");

	if ($contentObj->isAdminLoggedIn()){
		
		

		if (isset($_POST['paymentAmount'], $_POST['eventID'])) {

			$eventID = $_POST['eventID'];
			$amount = $_POST['paymentAmount'];

			if (is_numeric($amount) == false){

				$results = array("done" => "FALSE", "msg" => "Invalid Amount");

			}else if(is_numeric($eventID) == false){

				$results = array("done" => "FALSE", "msg" => "Invalid event ID");

			}else{

				$targetFolder = "../../uploads/Bills/";

				$validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
										"pspimage", "tga", "thm", "tif", "tiff",
										"yuv", "jif", "jfif", "jp2", "jpx", "j2k", 
										"j2c", "fpx", "pcd", 
										"xls", "xlt", "xlm", "xlsx", "xlsm", "xltx",
	                                    "xltm", "xlsb", "xla", "xlam", "xll", "xlw",
	                                    "ppt", "pot", "pps", "pptx", "pptm", "potx",
	                                    "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm",
	                                    "doc", "docm", "docx", "dot", "dotm", "dotx");

				$fileName = $_FILES['billsAttachment']['name'];
				$fileTmpName = $_FILES['billsAttachment']['tmp_name'];
				$ext = explode(".", basename($fileName));
				$fileExtension = end($ext);
				$fileSize = $_FILES['billsAttachment']['size'];

				$newFileName = strtoupper(md5(uniqid())) . "." . $ext[count($ext) - 1];
				$target_path = $targetFolder . $newFileName;


				if ($fileSize <= 10000000 && in_array(strtolower($fileExtension) ."", $validExtensions)){

					if (!empty($_FILES['billsAttachment']['error'])){
						$results = array("done" => "FALSE",
										"msg" => "Error uploading ". $fileName ." -> ". $_FILES['billsAttachment']['error']);
					}else{
						
						if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){

							$id = $contentObj->insertClientEventBill($newFileName, $fileName, $amount, $eventID);

							if ($id > 0){
								move_uploaded_file($fileTmpName, $target_path);

								$results = array("done" => "FALSE", "msg" => "Done");
							}
						}
					}

				}

			}

		}
	}

	echo json_encode($results);
	exit();
?>