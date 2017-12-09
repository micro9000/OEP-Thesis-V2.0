<?php session_start();
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if (isset($_POST['emailAdd']) &&
		isset($_POST['fullName']) &&
		isset($_POST['contactNo']) &&
		isset($_POST['password']) &&
		isset($_POST['confirmPass']) &&
		isset($_POST['regTag']) ){

		$emailAdd = $_POST['emailAdd'];
		$fullName = $_POST['fullName'];
		$contactNo = $_POST['contactNo'];
		$password = $_POST['password'];
		$confirmPass = $_POST['confirmPass'];
		$regTag = $_POST['regTag'];

		if ($password != $confirmPass){
			$results = array("done" => "FALSE", "msg" => "Password confirmation doesn't match Password");
		}else{

			if (strlen($regTag) != 128){
				$results = array("done" => "FALSE", "msg" => "Invalid RegTag");
			}else{
				// Insert client info
				$affectedRows = $contentModel->insertNewRegisteringClient($emailAdd, $regTag, $fullName, $contactNo, $password);

				if ($affectedRows > 0 && $affectedRows == 1){

					// Confirm the Registration
					$confirmAffectedRows = $contentModel->confirmNewRegisteringEmail($regTag);

					if ($confirmAffectedRows > 0 && $confirmAffectedRows == 1){
						// Login automatically
						if ($contentModel->client_login($emailAdd, $password)){
							$results = array("done" => "TRUE", "msg" => "Successfully added and logged in");
						}else{
							$results = array("done" => "FALSE", "msg" => "Can't login automatically, please go to Login page to login. Thank you");
						}	
					}else{
						$results = array("done" => "FALSE", "msg" => "Invalid RegTag");
					}

				}else{
					$results = array("done" => "FALSE", "msg" => "Error inserting client info, please try again");
				}
			}
		}
	}

	echo json_encode($results);
	exit();
?>