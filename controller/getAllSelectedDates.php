<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$dates = $contentModel->getAllSelectedDate();
	
	echo json_encode($dates);
	exit();
?>