<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();
	
	$partnersInfo = array();
	
	if (isset($_POST['partnerID'])){
		$partnersInfo = $contentModel->getPartnerInfo($_POST['partnerID']);
	}
	
	echo json_encode($partnersInfo);
	exit();
?>