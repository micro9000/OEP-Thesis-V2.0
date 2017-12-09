<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$motifs = array();

	if (isset($_POST['prodCatID'])){
		$motifs = $contentModel->getPartnersMotifsByProdCat($_POST['prodCatID']);
	}

	echo json_encode($motifs);
	exit();
?>