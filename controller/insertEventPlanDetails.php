<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$result = array("done" => "FALSE" , "msg" => "Please complete the event details form", "id" => "0");

	if (isset($_POST['typeOfEvent']) && 
		isset($_POST['serviceMotif']) && 
		isset($_POST['typeOfVenue']) &&
		isset($_POST['eventDate']) && 
		isset($_POST['eventEstimateStartTime']) && 
		isset($_POST['eventEstimateEndTime']) && 
		isset($_POST['noOfGuests']) ){

		$eventDate = $_POST['eventDate'];
		$start = $_POST['eventEstimateStartTime'];
		$end = $_POST['eventEstimateEndTime'];

		$venueID = $_POST['typeOfVenue'];

		$enterNoGuest = is_numeric($_POST['noOfGuests']) ? (int)$_POST['noOfGuests'] : 0;

		$venueNotesIsOutsideData = $contentModel->getVenueNotes_isOutside($venueID);
		$isVenueOutside = $venueNotesIsOutsideData['isOutside'];
		$venueMinGuest = 0;
		$venueMaxGuest = 0;
		$venueMinMsg = "";
		$venueMaxMsg = "";

		if ($isVenueOutside != ""){

			if ($isVenueOutside == "1"){
				$venueMinGuest = 100;
				$venueMaxGuest = 600;
				$venueMinMsg = "Invalid number of guest (Minimum: 100)";
				$venueMaxMsg = "Invalid number of guest (Maximum: 600)";

			}else if ($isVenueOutside == "0"){
				$venueMinGuest = 40;
				$venueMaxGuest = 180;
				$venueMinMsg = "Invalid number of guest (Minimum: 40)";
				$venueMaxMsg = "Invalid number of guest (Maximum: 180)";

			}else{
				$venueMinGuest = 0;
				$venueMaxGuest = 0;
				$venueMinMsg = "Please enter number of Guest";
			}
		}

		if ($enterNoGuest > $venueMaxGuest){
			$result = array("done" => "FALSE" , "msg" => $venueMaxMsg, "id" => "0");

		}else if ($enterNoGuest < $venueMinGuest){
			$result = array("done" => "FALSE" , "msg" => $venueMinMsg, "id" => "0");

		}else if($enterNoGuest <= $venueMaxGuest && $enterNoGuest >= $venueMinGuest){

			$isDateValid = $contentModel->isSelectedDateValid($eventDate);

			if ($isDateValid['done'] == "TRUE"){

				$isTimeValid = $contentModel->isSelectedDatesValid($start, $end);

				if ($isTimeValid === true){
					$inserteID = $contentModel->insertClientEventPlanDetails($_POST);
					$result = array("done" => "TRUE" , "msg" => "DONE", "id" => $inserteID);
				}else{
					$result = array("done" => "FALSE" , "msg" => "Invalid selected time", "id" => "0");
				}

			}else{
				$result = array("done" => "FALSE" , "msg" => "The selected date is invalid", "id" => "0");
			}

		}else{
			$result = array("done" => "FALSE" , "msg" => "Please check your number of guest input", "id" => "0");
		}

	}

	echo json_encode($result);
	exit();
?>