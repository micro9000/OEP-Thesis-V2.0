<?php session_start();

	require_once("model/Content_Model.php");

	$contentModel = new Content_Model();

	$recentEvents = array();
	$eventsImages = array();

	if (! isset($_GET['eventID'])){
		header("Location: ../main.php?page=recent-event");
	}

	$eventID = $_GET['eventID'];

	if ($contentModel->isAdminLoggedIn()){
		$recentEvents = $contentModel->getThisEventInfo($eventID);
		$eventsImages = $contentModel->getEventImages($eventID);
	}

?>