<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please enter partner name and info");

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['partnerName']) && isset($_POST['partnerInfo'])) {

			$data = array(
				"partnerName" => $_POST['partnerName'],
				"partnerInfo" => $_POST['partnerInfo'],
				"contactSmart" => isset($_POST['contactSmart']) ? $_POST['contactSmart'] : "",
				"contactGlobe" => isset($_POST['contactGlobe']) ? $_POST['contactGlobe'] : "",
				"contactEmail" => isset($_POST['contactEmail']) ? $_POST['contactEmail'] : ""
			);

			$affectedRow = $contentObj->insertNewPartner($data);

			if ($affectedRow > 0 && $affectedRow == 1){

				$results = array("done" => "TRUE", "msg" => "Inserted");

			}else{

				$results = array("done" => "FALSE", "msg" => "Error inserting...Please try again");

			}
		}
	}

	echo json_encode($results);
	exit();
?>