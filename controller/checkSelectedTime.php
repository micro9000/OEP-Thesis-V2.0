<?php session_start();

	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter start and end time");

	if (isset($_POST['start'], $_POST['end'], $_POST['eventDate'])){
		$start = $_POST['start'];
		$end = $_POST['end'];
		$eventDate = $_POST['eventDate'];

		if ($contentModel->isSelectedDatesValid($start, $end) === false){
			$results = array("done" => "TRUE","msg" => "Invalid Time selected");
		}else{

			$count = $contentModel->checkIfEventSchedIsApplicable($start, $end, $eventDate);

			if ($count >= 1){
				$results = array("done" => "FALSE","msg" => "The selected time range is not available");
			}else{
				$results = array("done" => "TRUE","msg" => "");
			}

		}
	}

	echo json_encode($results);
	exit();
?>
