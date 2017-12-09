<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$categories = array();

	if ($contentModel->isAdminLoggedIn()){
		$categories = $contentModel->getAllProductCategory();
	}

	echo json_encode($categories);
	exit();
?>