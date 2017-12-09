<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$eventsImage = array();

	if (isset($_POST['eventID']) && $_POST['imageID']){
		$eventID = $_POST['eventID'];
		$imageID = $_POST['imageID'];

		if ($contentModel->isAdminLoggedIn()){
			$eventsImage = $contentModel->getEventImageByID($eventID, $imageID);
		}
	}

	echo json_encode($eventsImage);
	exit();
?>