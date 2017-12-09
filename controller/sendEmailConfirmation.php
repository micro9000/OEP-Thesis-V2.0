<?php
		
	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter valid email");

	if (isset($_POST['emailAdd']) && !empty($_POST['emailAdd'])){

		$isRegistered = $contentModel->isEmailIsRegistered($_POST['emailAdd']);

		if ($isRegistered == false){

			$results = array("done" => "TRUE", "msg" => "Please confirm your registration through your email");
			$affectedRows = $contentModel->insertNewRegisteringEmail($_POST['emailAdd']);

			if ($affectedRows > 0 && $affectedRows == 1){
				$results = array("done" => "TRUE", "msg" => "Please confirm your registration through your email");
			}
		}else{
			$results = array("done" => "TRUE", "msg" => "THE EMAIL ADDRESS YOU HAVE ENTERED IS ALREADY REGISTERED");
		}

		// $affectedRows = $contentModel->insertNewRegisteringEmail($_POST['emailAdd']);

		// if ($affectedRows > 0 && $affectedRows == 1){
		// 	$results = array("done" => "TRUE", "msg" => "The confirmation email is successfully sent, Please confirm your registration.");
		// }
	}

	// echo "HIRE";

	echo json_encode($results);
	exit();
?>