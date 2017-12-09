<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$menus = $contentModel->getAllMenus();
	
	echo json_encode($menus);
	exit();
?>