<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){

		$task = $_POST['task'];

		switch ($task) {

			case 'byStatus':

				$status = $_POST['status'];
				$results = $contentModel->getAllEventsByStatus($status);
				break;

			case 'byID':

				$id = $_POST['eventID'];
				$results = $contentModel->getEventByID($id);

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

			case 'clientInfo':

				$clientID = $_POST['clientID'];
				$results = $contentModel->getClientInfo($clientID);
				
				break;

			case 'paymentLogs':
				
				$eventID = $_POST['eventID'];
				$results = $contentModel->getAllPayments($eventID);

				break;

			case 'paymentMethod':
				
				$eventID = $_POST['eventID'];
				$results = $contentModel->getPaymentMethod($eventID);
				$results = array("method" => $results);

				break;

			case 'deletedEvents': // or cancel events

				$results = $contentModel->getAllCancelEvents();

				break;
				
			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();
?>