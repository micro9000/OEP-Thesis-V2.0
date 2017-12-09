<?php session_start();

	require_once("model/Content_Model.php");

	$contentModel = new Content_Model();

	$partnersMotifs = array();

	$motifImages = array();

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_GET['partnerID']) && !isset($_GET['motifID'])){
			
			$partnersMotifs = $contentModel->getPartnerMotifs($_GET['partnerID']);
			
		}else if(isset($_GET['partnerID']) && isset($_GET['motifID'])){

			$partnersMotifs = $contentModel->getPartnerMotifByID($_GET['partnerID'], $_GET['motifID']);
			$motifImages = $contentModel->getPartnerMotifsImages($_GET['motifID']);

		}
	}
?>