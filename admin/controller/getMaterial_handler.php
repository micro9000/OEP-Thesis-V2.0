<?php session_start();

	require_once("../model/Content_Model.php");
	$contentModel = new Content_Model();

	$task = $_POST['task'];

	$results = array();

	switch ($task) {
		case 'all':
			$results = $contentModel->getAllMaterials();
			break;
			
		case 'byID':
			$materialID = $_POST['materialID'];
			$results =  $contentModel->getMaterialByID($materialID);
			break;

		case 'allThemes':
			$results =  $contentModel->getAllThemesPerMaterial();
			break;

		case 'themeID':
			$themeID = $_POST['themeID'];
			$results =  $contentModel->getThemesPerMaterialByThemeID($themeID);
			break;

		case 'themesByMaterialID':
			$materialID = $_POST['materialID'];
			$results =  $contentModel->getThemesByMaterialID($materialID);
			break;

		case 'themesImagesByThemeID':
			$themeID = $_POST['themeID'];
			$results =  $contentModel->getAllThemes_Images($themeID);
			break;

		case 'imageID':
			$imageID = $_POST['imageID'];
			$results = $contentModel->getThemes_ImagesByID($imageID);
			break;
			
		default:
			# code...
			break;
	}

	echo json_encode($results);
	exit();
?>