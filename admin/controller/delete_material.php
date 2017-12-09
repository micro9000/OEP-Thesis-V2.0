<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['materialID'])){
			$materialID = $_POST['materialID'];

			$affectedRow = $contentModel->deleteMaterial($materialID);
			if ($affectedRow > 0 && $affectedRow != 0){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>