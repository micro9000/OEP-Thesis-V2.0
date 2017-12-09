<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){
		
		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				$results = $contentModel->getAllMenus();
				break;
			
			case 'byID':
				$menuID = $_POST['menuID'];
				$results = $contentModel->getMenuByID($menuID);
				break;
				
			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();
?>