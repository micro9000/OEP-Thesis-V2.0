<?php session_start();
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form");

	if (isset($_POST['emailAdd']) && isset($_POST['password'])){

		$emailAdd = $_POST['emailAdd'];
		$password = $_POST['password'];

		if ($contentModel->client_login($emailAdd, $password)){
			$results = array("done" => "TRUE", "msg" => "Logged-In");
		}else{
			$results = array("done" => "FALSE", "msg" => "Login failed.");
		}	
	}

	echo json_encode($results);
	exit();
?>