<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Error");
	
	if ($contentModel->isAdminLoggedIn()){
		
		//mail_utf8('onebuffetrncs2017@gmail.com', $subject, $msg);
		
		if (isset($_POST['eventID']) && isset($_POST['status'])){
			$eventID = $_POST['eventID'];
			$status = $_POST['status'];
			
			if ($status == 2){
				$data = $contentModel->getEventDetails($eventID);
			
				$count = $contentModel->checkIfEventSchedIsApplicable($data['start'], $data['end'], $data['date']);
				
				if ($count >= 1){
					
					$results = array("done" => "FALSE", "msg" => "Date/Time is not available");
					
					$clientEmail = $contentModel->getClientEmailAdd($data['clientID']);
						
					$msg = "Reservation Date has already been taken. Please Choose Other Date or Time. <br> <br> Thank You for Your Consideration Ma'am/Sir.";
						
					$contentModel->mail_utf8($clientEmail, "Reservation unsuccessful", $msg);
					
				}else{
					$affectRow = $contentModel->changeEventStatus($status, $eventID);

					if ($affectRow > 0){
						$results = array("done" => "TRUE", "msg" => "DONE");
					}
				}
			}else{
				$affectRow = $contentModel->changeEventStatus($status, $eventID);

				if ($affectRow > 0){
					$results = array("done" => "TRUE", "msg" => "DONE");
				}
			}
			
			
		}
	}

	echo json_encode($results);
	exit();
?>