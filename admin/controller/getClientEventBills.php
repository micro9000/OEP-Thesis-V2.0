<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$bills = array();

	$eventID = $_POST['eventID'];

	if ($contentModel->isAdminLoggedIn()){
		$bills = $contentModel->getClientBills($eventID);
	}

	echo json_encode($bills);
	exit();
?>