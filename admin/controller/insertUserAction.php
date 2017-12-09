<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['action'])){
			$row = $contentObj->insertUserAction($_POST['action']);

			if ($row > 0){
				echo "TRUE";
				exit();
			}
		}
		
	}

	echo "FALSE";
	exit();
?>