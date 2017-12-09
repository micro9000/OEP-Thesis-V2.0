<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['serviceID']) && isset($_POST['serviceMotif'])) {

			$affectedRows = $contentObj->insertNewServiceMotif($_POST['serviceID'],$_POST['serviceMotif']);

			if ($affectedRows > 0){
				echo "TRUE";
				exit();
			}
		
		}
	}
	
	echo "FALSE";
	exit();
?>