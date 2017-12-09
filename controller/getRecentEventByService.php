<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$imageData = array();
	$eventImages = array();


	if (isset($_POST['serviceID'])){
		
		$events = $contentModel->getEventInfoByServiceID($_POST['serviceID']);
		
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
	}

	echo json_encode($eventImages);
	exit();
?>