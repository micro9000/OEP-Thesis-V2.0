<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();
	
	$result = array("done" => "FALSE" , "msg" => "Please complete the form");
	
	if (isset($_POST['emailAdd']) && !empty($_POST['emailAdd']) &&
		isset($_POST['inqName']) && !empty($_POST['inqName']) &&
		isset($_POST['contactNo']) && !empty($_POST['contactNo']) &&
		isset($_POST['typeOfEvent']) && !empty($_POST['typeOfEvent']) &&
		isset($_POST['typeOfVenue']) && !empty($_POST['typeOfVenue']) &&
		isset($_POST['venueID']) && !empty($_POST['venueID']) &&
		isset($_POST['venueAddress']) && !empty($_POST['venueAddress']) &&
		isset($_POST['noOfGuest']) && !empty($_POST['noOfGuest']) &&
		isset($_POST['inquiry']) && !empty($_POST['inquiry']) ){

		$msg = "<h3>New Inquiry - ". $_POST['inqName'] ."</h3>";
		$msg .= "<p>Date: ". date("l jS \of F Y h:i:s A") ."</p>";
		$msg .= "<p>Name: ". $_POST['inqName'] ."</p>";
		$msg .= "<p>Email: ". $_POST['emailAdd'] ."</p>";
		$msg .= "<p>Contact No: ". $_POST['contactNo'] ."</p>";
		$msg .= "<p>Type of Event: ". $_POST['typeOfEvent'] ."</p>";
		$msg .= "<p>Type of Venue: ". $_POST['typeOfVenue'] ."</p>";
		$msg .= "<p>Venue Address: ". $_POST['venueAddress'] ."</p>";
		$msg .= "<p>No of Guests: ". $_POST['noOfGuest'] ."</p>";
		$msg .= "<p>Inquiry: ". $_POST['inquiry'] ."</p>";
		
		$venueID = $_POST['venueID'];
		$enterNoGuest = is_numeric($_POST['noOfGuest']) ? (int)$_POST['noOfGuest'] : 0;
		
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
			$result = array("done" => "FALSE" , "msg" => $venueMaxMsg);

		}else if ($enterNoGuest < $venueMinGuest){
			$result = array("done" => "FALSE" , "msg" => $venueMinMsg);

		}else if($enterNoGuest <= $venueMaxGuest && $enterNoGuest >= $venueMinGuest){
			
			$sender = $_POST['emailAdd'];

			if ($contentModel->sendInquiry($sender, $msg) === true || $contentModel->sendInquiry($sender, $msg) == 1){

				$affectRows = $contentModel->insertNewInquiry($_POST);

				if ($affectRows > 0 && $affectRows == 1){
					$result = array("done" => "TRUE" , "msg" => "Successfully sent");
				}
			}

			
		}else{
			$result = array("done" => "FALSE" , "msg" => "Please check your number of guest input");
		}
		
	}

	echo json_encode($result);
	exit();

?>