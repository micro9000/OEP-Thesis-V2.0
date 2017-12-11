<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

    $results = array("done" => "FALSE", "msg" => "Please complete the form");

    $task = (isset($_POST['task'])) ? $_POST['task'] : "";

    switch ($task) {
        case 'updateFullname':

            $fullName = (isset($_POST['newFullName'])) ? $_POST['newFullName'] : "";
			$curPass = (isset($_POST['curPass'])) ? $_POST['curPass'] : "";

			if ($fullName != "" && $curPass != ""){

                $rowsAffect = $contentModel->updateUserFullName($fullName, $curPass);

				if ($rowsAffect > 0){
					$results = array("done" => "TRUE", "msg" => "Your fullname is successfully updated");
				}else{
					$results = array("done" => "FALSE", "msg" => "Error updating your fullname");
				}

			}

            break;

		case 'updateContactNo':

			$contactNo = (isset($_POST['newContactNo'])) ? $_POST['newContactNo'] : "";
			$curPass = (isset($_POST['curPass'])) ? $_POST['curPass'] : "";

			if ($contactNo != "" && $curPass != ""){

                $rowsAffect = $contentModel->updateUserContactNo($contactNo, $curPass);

				if ($rowsAffect > 0){
					$results = array("done" => "TRUE", "msg" => "Your contact no is successfully updated");
				}else{
					$results = array("done" => "FALSE", "msg" => "Error updating your contact no");
				}

			}

			break;

		case 'updateClientPassword':

			$newPass = (isset($_POST['newPass'])) ? $_POST['newPass'] : "";
			$confirmNewPass = (isset($_POST['conNewPass'])) ? $_POST['conNewPass'] : "";
			$curPass = (isset($_POST['curPass'])) ? $_POST['curPass'] : "";

			if ($newPass != "" && $confirmNewPass != "" && $curPass != ""){

				if ($newPass != $confirmNewPass){
					$results = array("done" => "FALSE", "msg" => "Please confirm your password");
				}else{

					$rowsAffect = $contentModel->updateClientPasswordV2($newPass, $curPass);

					if ($rowsAffect > 0){
						$results = array("done" => "TRUE", "msg" => "Your password is successfully updated");
					}else{
						$results = array("done" => "FALSE", "msg" => "Error updating your password");
					}

				}

			}

			break;

		case 'updateClientEmailAddress':

			$newEmail = (isset($_POST['newEmail'])) ? $_POST['newEmail'] : "";
			$curPass = (isset($_POST['curPass'])) ? $_POST['curPass'] : "";

			if ($newEmail != "" && $curPass != ""){

                $rowsAffect = $contentModel->updateClientEmailAddress($newEmail, $curPass);

				if ($rowsAffect > 0){
					$results = array("done" => "TRUE", "msg" => "Your email address is successfully updated");
				}else{
					$results = array("done" => "FALSE", "msg" => "Error updating your email address");
				}

			}

			break;
        default:
            # code...
            break;
    }

	echo json_encode($results);
	exit();
?>
