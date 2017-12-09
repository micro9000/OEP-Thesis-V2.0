<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isClientLoggedIn()){

		if (isset($_POST['foodsEnterID'])){

			$foodsEnterID = $_POST['foodsEnterID'];

			$isDeleted = $contentModel->deleteEventFoodsEntertainment($foodsEnterID);

			if ($isDeleted == true){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>