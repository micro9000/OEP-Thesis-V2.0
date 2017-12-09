<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_GET['serverName'], $_GET['origFileName'])){
		$fileName = $_GET['serverName'];
		$origFileName = $_GET['origFileName'];

		$path = "../uploads/Bills/" . $fileName;

		// echo $path;

		$contentModel->send_download($path, $origFileName);
	}else{
		echo "Invalid Arguments";
	}
?>