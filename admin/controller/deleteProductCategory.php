<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['prodCatID'])) {
			$affectRows = $contentObj->deleteProductCategory($_POST['prodCatID']);

			if ($affectRows > 0){
				echo "TRUE";
				exit();
			}
		
		}
	}

	echo "FALSE";
	exit();
?>