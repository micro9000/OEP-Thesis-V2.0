<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please login...");

	if ($contentModel->isAdminLoggedIn()){

		if (isset($_POST['slideId'])){
			$slideId = $_POST['slideId'];

			if (is_numeric($slideId)){
				if ($contentModel->DeleteThisSlideshow($slideId) > 0){
					$results = array("done" => "TRUE", "msg" => "Deleted");
				}
			}
		}
	}

	echo json_encode($results);
	exit();
?>