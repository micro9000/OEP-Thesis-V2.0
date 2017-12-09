<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$payments = array();

	if (isset($_POST['eventID'])){
		$payments = $contentModel->getAllPayments($_POST['eventID']);
	}

	if (sizeof($payments) > 0){
		echo json_encode($payments);
	}else{
		echo "0";
	}
	
	exit();
?>