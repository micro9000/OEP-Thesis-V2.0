<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['motifID'])){
			$motifID = $_POST['motifID'];

			$affectedRow = $contentModel->deleteServiceMotif($motifID);

			if ($affectedRow > 0 && $affectedRow != 0){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();

?>