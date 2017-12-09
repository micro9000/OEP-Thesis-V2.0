<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){
		if (isset($_POST['imageID'])){

			$imageID = $_POST['imageID'];
			$affectedRow = $contentModel->DeleteRecentEvent_Image($imageID);

			if ($affectedRow > 0){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>