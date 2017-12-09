<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (! isset($_GET['eventID'])){
		header("Location: ../main.php?page=recent-event");
	}

	$eventID = $_GET['eventID'];

	if ($contentModel->isAdminLoggedIn()){
		$affectedRow = $contentModel->deleteEvent($eventID);
		if ($affectedRow > 0 && $affectedRow != 0){
			echo "<script>Alert('Deleted');</script>";
			header("Location: ../main.php?page=recent-event");
		}
	}

?>