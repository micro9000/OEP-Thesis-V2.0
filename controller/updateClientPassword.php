<?php

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if (isset($_POST['newPass'], $_POST['confirmPass'], $_POST['tag'], $_POST['email'])){

		$newPass = $_POST['newPass'];
		$confirmPass = $_POST['confirmPass'];
		$tag = $_POST['tag'];
		$email = $_POST['email'];

		$clientInfo = $contentModel->getClientInfo_frm_passRecovery($email, $tag);

		if ($newPass != $confirmPass){
			$results = array("done" => "FALSE", "msg" => "Password does not match the confirm password");
		}else{

			if (sizeof($clientInfo) > 0){
				$rowsAffect = $contentModel->updateClientPassword($newPass, $clientInfo[0]['clientID'], $clientInfo[0]['email_address']);

				if ($rowsAffect === true){

					$rowsAffect = $contentModel->updateClients_RecoveredEmail_toDone($clientInfo[0]['id'], $tag, $clientInfo[0]['clientID'], $email);

					if ($rowsAffect > 0){
						$results = array("done" => "TRUE", "msg" => "Password Changed! Please login");
					}
				}

			}else{
				$results = array("done" => "TRUE", "msg" => "Password already changed.");
			}
		}

	}

	echo json_encode($results);
	exit();
?>
