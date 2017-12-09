<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$results = array("done" => "FALSE", "msg" => "Please complete the form / No changes made");

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

		$inserteID = $contentModel->updateClientEventPlanSelectedMenu($_POST);

		if ($inserteID > 0){
			$results = array("done" => "TRUE", "msg" => "Updated");
		}
	}

	echo json_encode($results);
	exit();
?>