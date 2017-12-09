<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){

		if(isset($_POST['itemPrice'], $_POST['imageID'])){
			$price = $_POST['itemPrice'];
			$imageID = $_POST['imageID'];

			$affectRows = $contentModel->updatePartnersMotifItemPrice($imageID, $price);

			if ($affectRows > 0){
				echo "TRUE";
				exit();
			}

		}
	}

	echo "FALSE";
	exit();
?>