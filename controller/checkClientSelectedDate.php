<?php session_start();
	
	require_once("../model/Content_Model.php");
	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter the date");


	if (isset($_POST['selectedDate'])){
		$selectedDate = $_POST['selectedDate'];

		$results = $contentModel->isSelectedDateValid($selectedDate);

		// $selectedDate = $contentModel->getProperDate($selectedDate);
		// $today = date("Y-m-d");
		// $todayPlsOneWeek = date("Y-m-d", strtotime($today . ' + 7 days'));

		// if ($selectedDate <= $todayPlsOneWeek){

		// 	$results = array("done" => "FALSE", "msg" => "Invalid Date - it must be 1 week preparation before the event");
		
		// }else{

		// 	$isAlreadyUsed = $contentModel->isSelectedDateAlreadyUsed($selectedDate);

		// 	if ($isAlreadyUsed == true){

		// 		$results = array("done" => "FALSE", "msg" => "The date is not available");

		// 	}else if($isAlreadyUsed == false){

		// 		$results = array("done" => "TRUE", "msg" => "The date is available");

		// 	}else{
		// 		$results = array("done" => "TRUE", "msg" => "Unkown error!!!!");
		// 	}
		// }
	}

	echo json_encode($results);
	exit();
?>