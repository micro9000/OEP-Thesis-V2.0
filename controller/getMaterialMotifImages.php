<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$images = array();

	if (isset($_POST['motifID'])){
		$images = $contentModel->getAllThemes_Images($_POST['motifID']);
	}

	echo json_encode($images);
	exit();
?>