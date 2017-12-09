<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$partners = $contentModel->getAllPartners();
	
	echo json_encode($partners);
	exit();
?>