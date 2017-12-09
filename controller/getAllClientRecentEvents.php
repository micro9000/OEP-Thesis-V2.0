<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$events = array();

	if ($contentModel->isClientLoggedIn()){
		$events = $contentModel->getAllClientRecentEvents();
	}

	echo json_encode($events);
	exit();
?>