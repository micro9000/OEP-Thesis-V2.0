<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$budgets = array();

	if ($contentModel->isAdminLoggedIn()){
		$budgets = $contentModel->getAllBudgetRanges();
	}

	echo json_encode($budgets);
	exit();
?>