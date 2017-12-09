<?php session_start();
	
	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter start and end time");

	if (isset($_POST['start'], $_POST['end'])){
		$start = $_POST['start'];
		$end = $_POST['end'];

		if ($contentModel->isSelectedDatesValid($start, $end) === false){
			$results = array("done" => "TRUE","msg" => "Invalid Time selected");
		}else{
			$results = array("done" => "TRUE","msg" => "");
		}
	}

	echo json_encode($results);
	exit();
?>