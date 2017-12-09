<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_POST['eventID'])){
		$method = $contentModel->getPaymentMethod($_POST['eventID']);
		echo $method;
		exit();
	}

	echo 0;
	exit();
?>