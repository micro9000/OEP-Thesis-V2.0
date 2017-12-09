<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if (isset($_POST['selectedSoup']) && 
		isset($_POST['selectedChicken']) && 
		isset($_POST['selectedSeafoods']) && 
		isset($_POST['selectedPorkBeef']) && 
		isset($_POST['selectedVegetable']) && 
		isset($_POST['selectedRice']) && 
		isset($_POST['selectedSalad']) && 
		isset($_POST['selectedDessert']) && 
		isset($_POST['selectedDrinks']) && 
		isset($_POST['menuID']) ){

		$inserteID = $contentModel->insertClientEventPlanSelectedMenu($_POST);

		if ($inserteID > 0){
			echo "TRUE";
			exit();
		}
	}

	echo "FALSE";
	exit();
?>