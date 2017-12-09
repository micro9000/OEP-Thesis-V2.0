<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$limit = 8;

	$events = array();

	if (isset($_POST['isLimited']) && $_POST['isLimited'] == 0){
		$events = $contentModel->getEventsByFlag(true, 0);
	}else{
		$events = $contentModel->getEventsByFlag(false, $limit);
	}

	$imageData = array();
	$eventImages = array();

	$eventsLen = sizeof($events);

	for($i=0; $i<$eventsLen; $i++){

		$eventID = $events[$i]['id'];
		$images = $contentModel->getEventOneImageByID($eventID);

		$service = $contentModel->getEventService($events[$i]['serviceID']);

		$imageData = array(
					"eventID" => $eventID,
					"imageData" => $images,
					"service" => $service,
					"eventDate" => $events[$i]['eventDate']
				);

		array_push($eventImages, $imageData);
	}

	echo json_encode($eventImages);
	exit();
?>