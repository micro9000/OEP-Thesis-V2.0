<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_POST['eventID']) && 
		isset($_POST['materialID']) && 
		isset($_POST['imgID']) ){

		$eventID = $_POST['eventID'];
		$materialID = $_POST['materialID'];
		$imgID = $_POST['imgID'];

		$existing = $contentModel->isMaterialExisting($eventID, $materialID, $imgID);

		if ($existing === false){
			$inserteID = $contentModel->insertClientEventPlanMaterials($eventID, $materialID, $imgID);

			if ($inserteID > 0){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>