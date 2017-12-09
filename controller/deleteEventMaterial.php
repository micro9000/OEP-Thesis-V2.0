<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isClientLoggedIn()){

		if (isset($_POST['materialID'])){

			$materialID = $_POST['materialID'];

			$isDeleted = $contentModel->deleteEventMaterial($materialID);

			if ($isDeleted == true){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>