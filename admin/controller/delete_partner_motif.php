<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();


	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['motifID'])){
			$motifID = $_POST['motifID'];

			$affectedRow = $contentModel->DeletePartnerMotif($motifID);

			if ($affectedRow > 0 && $affectedRow != 0){
				echo "TRUE";
				exit();
			}

		}
	}

	echo "TRUE";
	exit();
?>