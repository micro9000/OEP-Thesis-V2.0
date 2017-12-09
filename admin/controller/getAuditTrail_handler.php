<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array();

	if ($contentModel->isAdminLoggedIn()){

		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				
				$results = $contentModel->getLast100AuditTrails();

				break;

			case 'dateRange':
				
				$start = $_POST['startDate'];
				$end = $_POST['endDate'];

				$results = $contentModel->getAuditTrailByDate($start, $end);

				break;
				
			default:
				# code...
				break;
		}
	}

	echo json_encode($results);
	exit();

?>