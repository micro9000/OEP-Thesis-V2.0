<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$motifs = array();

	if (isset($_POST['materialID'])){
		$motifs = $contentModel->getThemesByMaterialID($_POST['materialID']);
	}

	echo json_encode($motifs);
	exit();
?>