<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("notes" => "", "isOutside" => "");

	if (isset($_POST['venueID'])){
		$results = $contentModel->getVenueNotes_isOutside($_POST['venueID']);
	}
	
	echo json_encode($results);
	exit();
?>