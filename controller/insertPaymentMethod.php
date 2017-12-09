<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_POST['method'], $_POST['eventID'])){

		$rows = $contentModel->insertPaymentMethod($_POST['method'], $_POST['eventID']);

		if ($rows > 0){
			echo "TRUE";
			exit();
		}
	}

	echo "FALSE";
	exit();
?>