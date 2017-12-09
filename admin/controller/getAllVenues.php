<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$venues = array();

	if ($contentModel->isAdminLoggedIn()){
		$venues = $contentModel->getAllVenues();
	}

	echo json_encode($venues);
	exit();
?>