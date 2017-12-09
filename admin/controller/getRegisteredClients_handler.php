<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){
		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				
				$results = $contentModel->getAllRegisteredClients();

				break;
			
			case 'search':
				
				$searchStr = $_POST['searchStr'];

				$results = $contentModel->searchRegisteredClients($searchStr);

				break;
			case 'dateReg':
				
				$startDate = $_POST['startDate'];
				$endDate = $_POST['endDate'];

				$results = $contentModel->searchRegisteredClientsByDateReg($startDate, $endDate);

				break;
			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();
?>