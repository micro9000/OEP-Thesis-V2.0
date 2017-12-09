<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){
		$task = $_POST['task'];

		switch ($task) {
			case 'all':

				$results = $contentModel->getAllPartners();
				break;

			case 'byID':

				$partnerID = $_POST['partnerID'];
				$results = $contentModel->getPartnerInfo($partnerID);
				
				break;
			case 'motifs':

				$partnerID = $_POST['partnerID'];

				$results = $contentModel->getPartnerMotifs($_POST['partnerID']);

				break;

			case 'motifID':
				
				$motifID = $_POST['motifID'];
				$partnerID = $_POST['partnerID'];

				$results = $contentModel->getPartnerMotifByID($partnerID, $motifID);

				break;

			case 'motifImages':
				
				$motifID = $_POST['motifID'];
				$results = $contentModel->getPartnerMotifsImages($motifID);

				break;

			case 'imageByID':
				
				$imageID = $_POST['imageID'];
				$results = $contentModel->getPartnerMotifsOneImage($imageID);

				break;
			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();
?>