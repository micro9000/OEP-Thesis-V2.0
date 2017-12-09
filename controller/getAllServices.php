<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$services = $contentModel->getAllServices();
	
	echo json_encode($services);
	exit();
?>