<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['venue'], $_POST['notes'], $_POST['isOutsideVenue'])) {
			
			$affectedRows = $contentObj->insertNewVenue($_POST['venue'], $_POST['notes'], $_POST['isOutsideVenue']);

			if ($affectedRows > 0){
				echo "TRUE";
				exit();
			}
		
		}
	}

	echo "FALSE";
	exit();
?>