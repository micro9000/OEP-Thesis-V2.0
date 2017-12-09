<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please login...");

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['material'])){

			$id = $contentObj->insertNewMaterial($_POST['material']);

			if ($id > 0 && $id != 0){
				$results = array("done" => "TRUE", "msg" => "Inserted");
			}else{
				$results = array("done" => "FALSE", "msg" => "Insert failed");
			}
		}
	}

	echo json_encode($results);
	exit();
?>