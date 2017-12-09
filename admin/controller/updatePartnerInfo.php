<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter partner name and info");

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['partnerName']) && isset($_POST['partnerInfo']) && isset($_POST['partnerID'])) {

			$data = array(
				"partnerName" => $_POST['partnerName'],
				"partnerInfo" => $_POST['partnerInfo'],
				"contactSmart" => isset($_POST['contactSmart']) ? $_POST['contactSmart'] : "",
				"contactGlobe" => isset($_POST['contactGlobe']) ? $_POST['contactGlobe'] : "",
				"contactEmail" => isset($_POST['contactEmail']) ? $_POST['contactEmail'] : "",
				"partnerID" => $_POST['partnerID']
			);

			$affectedRow = $contentObj->updatePartner($data);

			if ($affectedRow > 0 && $affectedRow == 1){

				$results = array("done" => "TRUE", "msg" => "Updated");

			}else{

				$results = array("done" => "FALSE", "msg" => "Error inserting...Please try again");

			}
		}
	}

	echo json_encode($results);
	exit();
?>