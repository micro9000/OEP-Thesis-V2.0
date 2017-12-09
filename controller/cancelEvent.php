<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isClientLoggedIn()){

		if (isset($_POST['eventID'])){

			$eventID = $_POST['eventID'];

			$isDeleted = $contentModel->deleteEvent($eventID);

			if ($isDeleted == true){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>