<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	$task = $_POST['task'];

	switch ($task) {

		case 'byID':

			$id = $_POST['eventID'];
			$results = $contentModel->getEventByID($id);

			break;

		case 'currentEvent':

			$results = $contentModel->getClientCurrentEvent();

			break;

		case 'eventMaterialsImgs':
			
			$eventID = $_POST['eventID'];
			$results = $contentModel->getAllEventMaterialImgs($eventID);

			break;

		case 'eventFoodsEntertainmentImgs':
			
			$eventID = $_POST['eventID'];
			$results = $contentModel->getAllEventFoodsNEntertainment($eventID);

			break;

		case 'eventSelectedMenu':
			
			$eventID = $_POST['eventID'];
			$results = $contentModel->getEventMenuSelected($eventID);

			break;

		case 'actualEventDataByID':
			
			$eventID = $_POST['eventID'];
			$results = $contentModel->getEventsDetailsActualDataByID($eventID);

			break;

		case 'actualMaterialIDs_motifsIDs':
			$eventID = $_POST['eventID'];
			$results = $contentModel->getEventsMaterialsMotifImgID_ActualDataByID($eventID);

			break;

		case 'actualFoodsEntertainmentIDs_motifsIDs':
			$eventID = $_POST['eventID'];
			$results = $contentModel->getEventsProdCatPartnersMotifImgID_ActualDataByID($eventID);
			
			break;

		case 'currentBill':
			$eventID = $_POST['eventID'];
			$results = $contentModel->getClientBills($eventID);
			
			break;

		default:
			# code...
			break;
	}

	echo json_encode($results);
	exit();
?>