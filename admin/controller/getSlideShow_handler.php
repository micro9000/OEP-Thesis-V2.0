<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$slideshows = array();


	if ($contentModel->isAdminLoggedIn()){

		$task = isset($_POST['task']) ? $_POST['task'] : "all";

		switch ($task) {
			case 'all':
				
				$slideshows = $contentModel->getAllSlideshow();
				
				break;
			case 'byID':
				
				$id = isset($_POST['slideID']) ? $_POST['slideID'] : 0;

				if ($id != 0 && $id > 0){
					$slideshows = $contentModel->getSlideshowByID($id);
				}

				break;

			case 'slideImage':
				
				

				break;
			default:
				# code...
				break;
		}

	}

	echo json_encode($slideshows);
	exit();

?>