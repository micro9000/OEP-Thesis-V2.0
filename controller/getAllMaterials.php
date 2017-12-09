<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$materials = $contentModel->getAllMaterials();
	
	echo json_encode($materials);
	exit();
?>