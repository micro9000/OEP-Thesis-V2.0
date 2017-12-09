<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$inquiries = array();

	if ($contentModel->isAdminLoggedIn()){

		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				$inquiries = $contentModel->getAllInquiries();
				break;
			case 'byID':
				$inqID = $_POST['inqID'];
				$inquiries = $contentModel->getInquiryBYID($inqID);
				break;
			default:
				# code...
				break;
		}

		
	}

	echo json_encode($inquiries);
	exit();
?>