<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_POST['themeID'])){

		if ($contentModel->isAdminLoggedIn()){
			$themeID = $_POST['themeID'];
			
			$affectedRow = $contentModel->deleteMaterialTheme($themeID);
			if ($affectedRow > 0 && $affectedRow != 0){
				echo "TRUE";
				exit();
			}
		}
	}
	
	echo "FALSE";
	exit();
?>