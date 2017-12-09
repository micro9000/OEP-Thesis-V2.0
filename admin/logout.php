<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$adminCon = new Admin_Connection();
	$adminCon->logoutUser();

	header("Location: index.php");
?>