<?php session_start();
	
	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	// Please complete the event details form
	$result = array("done" => "FALSE" , "msg" => "Please complete the event details form / No changes made");

	// print_r($_POST);
	if (isset($_POST['typeOfEvent']) && 
		isset($_POST['serviceMotif']) && 
		isset($_POST['typeOfVenue']) && 
		isset($_POST['eventDate']) && 
		isset($_POST['eventEstimateStartTime']) && 
		isset($_POST['eventEstimateEndTime']) && 
		isset($_POST['noOfGuests']) &&
		isset($_POST['eventID'])){

		$eventDate = $_POST['eventDate'];
		$eventID = $_POST['eventID'];

		$start = $_POST['eventEstimateStartTime'];
		$end = $_POST['eventEstimateEndTime'];

		$clientID = $_SESSION['client_ID'];

		if ($contentModel->isEventBelongsToClient($eventID, $clientID) == true){


			if ($contentModel->isNewSelectedDateIsSameAsOld($eventDate, $clientID, $eventID) === false){
				
			
				$isDateValid = $contentModel->isSelectedDateValid($eventDate);

				if ($isDateValid['done'] == "TRUE"){

					$isTimeValid = $contentModel->isSelectedDatesValid($start, $end);

					if ($isTimeValid === true){
						$affectectedRows = $contentModel->updateClientEventPlanDetails($_POST);
						if ($affectectedRows > 0){
							$result = array("done" => "TRUE" , "msg" => "UPDATED");
						}
					}else{
						$result = array("done" => "FALSE" , "msg" => "Invalid selected time");
					}

				}else{
					$result = array("done" => "FALSE" , "msg" => "The selected date is invalid");
				}
			}else{

				// print_r($_POST);

				$isTimeValid = $contentModel->isSelectedDatesValid($start, $end);

				if ($isTimeValid === true){
					$affectectedRows = $contentModel->updateClientEventPlanDetails($_POST);

					if ($affectectedRows > 0){
						$result = array("done" => "TRUE" , "msg" => "UPDATED");
					}

				}else{
					$result = array("done" => "FALSE" , "msg" => "Invalid selected time");
				}
			}

		}
	}

	echo json_encode($result);
	exit();
?>