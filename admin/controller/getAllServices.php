<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$services = array();

	if ($contentModel->isAdminLoggedIn()){
		if (isset($_POST['serviceID'])){
			$services = $contentModel->getServiceByID($_POST['serviceID']);
		}else{
			$services = $contentModel->getAllServices();
		}
	}

	echo json_encode($services);
	exit();
?>