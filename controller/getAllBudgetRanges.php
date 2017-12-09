<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$budgets = $contentModel->getAllBudgetRanges();
	
	echo json_encode($budgets);
	exit();
?>