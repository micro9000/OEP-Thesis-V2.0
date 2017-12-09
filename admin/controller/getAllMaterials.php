<?php session_start();

	require_once("model/Content_Model.php");
	$contentModel = new Content_Model();

	$materials = array();
	$themesPerMaterials = array();
	$themeImages = array();

	if ($contentModel->isAdminLoggedIn()){

		$materialID = isset($_GET['materialID']) ? $_GET['materialID'] : 0;

		if ($materialID != 0 && $materialID > 0){
			$materials = $contentModel->getMaterialByID($materialID);
		}else{
			$materials = $contentModel->getAllMaterials();
		}
		

		if (isset($_GET['themeID'])){

			$themeID = $_GET['themeID'];

			$themesPerMaterials = $contentModel->getThemesPerMaterialByThemeID($themeID);
			$themeImages = $contentModel->getAllThemes_Images($themeID);
		}else{

			if ($materialID != 0 && $materialID > 0){
				$themesPerMaterials = $contentModel->getThemesByMaterialID($materialID);
			}else{
				$themesPerMaterials = $contentModel->getAllThemesPerMaterial();
			}

		}
	}

?>