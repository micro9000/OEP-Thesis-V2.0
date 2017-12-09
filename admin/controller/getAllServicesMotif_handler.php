<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){

		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				$results = $contentModel->getAllServiceMotifs();
				break;
			
			case "motifID":
				$motifID = $_POST['motifID'];
				$results = $contentModel->getServiceMotifsBymotifID($motifID);
				break;

			case 'serviceID':
				$serviceID = $_POST['serviceID'];
				$results = $contentModel->getServiceMotifsByserviceID($serviceID);
				break;

			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();

?>