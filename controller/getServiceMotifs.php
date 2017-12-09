<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$motifs = array();

	if (isset($_POST['serviceID'])){
		$serviceID = $_POST['serviceID'];
		$motifs = $contentModel->getServiceMotifsByserviceID($serviceID);
	}

	echo json_encode($motifs);
	exit();
?>