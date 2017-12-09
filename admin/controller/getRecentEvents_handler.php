<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){
		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				
				$results = $contentModel->getAllEvents();

				break;
			case 'filter':

				$serviceID = isset($_POST['search_by_category']) ? $_POST['search_by_category'] : 0;
				$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : "";
				$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : "";

				$results = $contentModel->searchEvent($serviceID, $startDate, $endDate);

				break;

			case 'byID':
				
				$eventID = isset($_POST['eventID']) ? $_POST['eventID'] : 0;

				$results = $contentModel->getThisEventInfo($eventID);

				break;

			case 'images':
					
				$eventID = isset($_POST['eventID']) ? $_POST['eventID'] : 0;

				$results = $contentModel->getEventImages($eventID);

				break;

			case 'imageByID':
				
				$eventID = isset($_POST['eventID']) ? $_POST['eventID'] : 0;
				$imageID = isset($_POST['imageID']) ? $_POST['imageID'] : 0;

				$results = $contentModel->getEventImageByID($eventID, $imageID);

				break;
			default:
				# code...
				break;
		}

	}
		
	echo json_encode($results);
	exit();
?>