<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['serviceID'])){
			$serviceID = $_POST['serviceID'];

			$affectedRow = $contentModel->deleteService($serviceID);

			if ($affectedRow > 0 && $affectedRow != 0){
				echo "TRUE";
				exit();
			}
		}	
	}

	echo "FALSE";
	exit();

?>