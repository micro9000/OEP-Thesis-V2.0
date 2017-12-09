<?php
	session_start();
	require_once("../model/Content_Model.php");
	$contentModel = new Content_Model();

	$contentModel->client_logout();

	if (!$contentModel->isClientLoggedIn()){
		header("Location: clientLogin.php");
	}
?>