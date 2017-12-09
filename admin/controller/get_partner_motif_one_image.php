<?php session_start();

	require_once("model/Content_Model.php");

	$contentModel = new Content_Model();

	$motifImage = array();

	if (! isset($_GET['motifID']) && !isset($_GET['partnerID']) && !isset($_GET['imageID'])){
		header("Location: ../main.php?page=partners-panel");
	}

	$imageID = $_GET['imageID'];

	if ($contentModel->isAdminLoggedIn()){
		$motifImage = $contentModel->getPartnerMotifsOneImage($imageID);
	}

?>