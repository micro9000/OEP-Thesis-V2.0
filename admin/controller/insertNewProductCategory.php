<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['productCat'])) {
			$serviceID = $contentObj->insertNewProductCategory($_POST['productCat']);

			if ($serviceID > 0){
				echo "TRUE";
				exit();
			}
		
		}
	}

	echo "FALSE";
	exit();
?>