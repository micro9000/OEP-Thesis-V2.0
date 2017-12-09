<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['amount'], $_POST['eventID'], $_POST['method'])) {

			$methodAffecRow = $contentObj->insertPaymentMethod($_POST['method'], $_POST['eventID']);

			if ($methodAffecRow > 0){

				$payementAffectRow = $contentObj->insertPayment($_POST['amount'], $_POST['eventID']);

				if ($payementAffectRow > 0){
					echo "TRUE";
					exit();
				}
			}
		
		}
	}

	echo "FALSE";
	exit();
?>