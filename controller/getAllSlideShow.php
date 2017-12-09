<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$slideshows = $contentModel->getAllSlideshow();
	
	echo json_encode($slideshows);
	exit();
?>