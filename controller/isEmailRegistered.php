<?php

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Invalid Email");

	if (isset($_POST['email'])){

		$emailAdd = $_POST['email'];

		$clientInfo = $contentModel->isClientEmailRegistered($emailAdd);

		// print_r($clientInfo);

		if (sizeof($clientInfo) > 0){
			$clientTag = $contentModel->getClientTag($emailAdd . date("l jS \of F Y h:i:s A"));
			$affectRow = $contentModel->insertClientEmailRecovered($clientInfo['email'], $clientTag, $clientInfo['id']);

			if ($affectRow > 0){

				$isSent = $contentModel->sendEmailConfirmationForPassRec($clientInfo['email'], $clientTag);
				if ($isSent === 1 || $isSent === true){
					$results = array("done" => "TRUE", "msg" => "Please check your email account to continue.");
				}
			}//
		}
	}

	echo json_encode($results);
	exit();
?>