<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if(isset($_POST['price'], $_POST['imageID'])){
			$price = $_POST['price'];
			$imageID = $_POST['imageID'];

			$affectRows = $contentModel->updateMaterialPrice($imageID, $price);

			if ($affectRows > 0){
				echo "TRUE";
				exit();
			}

		}
	}

	echo "FALSE";
	exit();
?>