<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Foods/Entertainment is already added");

	if (isset($_POST['eventID']) && 
		isset($_POST['prodCatID']) && 
		isset($_POST['imgID']) ){

		$eventID = $_POST['eventID'];
		$prodCatID = $_POST['prodCatID'];
		$imgID = $_POST['imgID'];

		$isExisting = $contentModel->isFoodsEntertainmentExisting($eventID, $prodCatID, $imgID);

		if ($isExisting == false){
			$inserteID = $contentModel->insertClientEventPlanFoodsEntertainment($eventID, $prodCatID, $imgID);

			if ($inserteID > 0){
				$results = array("done" => "TRUE", "msg" => "New Foods/Entertainment added");
			}
		}			
	}

	echo json_encode($results);
	exit();
?>