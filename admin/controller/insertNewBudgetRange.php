<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){
		
		if (isset($_POST['budgetRange'])) {
			$affectedRows = $contentObj->insertNewBudgetRange($_POST['budgetRange']);

			if ($affectedRows > 0){
				echo "TRUE";
				exit();
			}
		
		}
	}

	echo "FALSE";
	exit();
?>