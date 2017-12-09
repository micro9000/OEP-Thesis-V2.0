<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$eventData = array();

	if (isset($_POST['eventID'])) {
		$images = $contentModel->getEventImagesByID($_POST['eventID']);
		$info = $contentModel->getEventInfoByID($_POST['eventID']);

		$eventData = array(
			"images" => $images,
			"info" => $info
		);

	}

	echo json_encode($eventData);
	exit();

?>