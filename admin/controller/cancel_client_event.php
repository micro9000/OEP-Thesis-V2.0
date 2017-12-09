<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['eventID'])){

			$eventID = $_POST['eventID'];

			$isDeleted = $contentModel->deleteClientEvent($eventID);

			if ($isDeleted == true){
				$contentModel->changeEventStatus(6, $eventID);
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>