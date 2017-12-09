<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$menu = array();

	if(isset($_POST['menuID'])){
		$menu = $contentModel->getMenuByID($_POST['menuID']);
	}

	echo json_encode($menu);
	exit();
?>