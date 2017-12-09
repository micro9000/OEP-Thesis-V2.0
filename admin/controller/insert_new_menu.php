<?php session_start();
	
	// print_r($_POST);

	require_once("../model/Content_Model.php");

	$contentObj = new Content_Model();

	if ($contentObj->isAdminLoggedIn()){

		if (isset($_POST['setTitle']) && 
			isset($_POST['setPrice']) && 
			isset($_POST['soup']) && 
			isset($_POST['chicken']) && 
			isset($_POST['seafoods']) && 
			isset($_POST['pork_beef']) && 
			isset($_POST['vegetable']) && 
			isset($_POST['rice']) && 
			isset($_POST['salad']) && 
			isset($_POST['dessert']) && 
			isset($_POST['drinks'])
		){

			if (! is_numeric($_POST['setPrice'])){
				$_SESSION['inserting_new_menu'] = "Invalid Price";
				exit(header("Location: ../main.php?page=menus"));
			}

			$data = array(
				"setTitle" => $_POST['setTitle'],
				"setPrice" => $_POST['setPrice'],
				"soup" => $_POST['soup'],
				"chicken" => $_POST['chicken'],
				"seafoods" => $_POST['seafoods'],
				"pork_beef" => $_POST['pork_beef'],
				"vegetable" => $_POST['vegetable'],
				"rice" => $_POST['rice'],
				"salad" => $_POST['salad'],
				"dessert" => $_POST['dessert'],
				"drinks" => $_POST['drinks'],
				"soup_changable" => (isset($_POST['soup_changable']) && !empty($_POST['soup_changable'])) ? 1 : 0,
				"chicken_changable" => (isset($_POST['chicken_changable']) && !empty($_POST['chicken_changable'])) ? 1 : 0,
				"seafoods_changable" => (isset($_POST['seafoods_changable']) && !empty($_POST['seafoods_changable'])) ? 1 : 0,
				"pork_beef_changable" => (isset($_POST['pork_beef_changable']) && !empty($_POST['pork_beef_changable'])) ? 1: 0,
				"vegetable_changable" => (isset($_POST['vegetable_changable']) && !empty($_POST['vegetable_changable'])) ? 1 : 0,
				"rice_changable" => (isset($_POST['rice_changable']) && !empty($_POST['rice_changable'])) ? 1 : 0,
				"salad_changable" => (isset($_POST['salad_changable']) && !empty($_POST['salad_changable'])) ? 1 : 0,
				"dessert_changable" => (isset($_POST['dessert_changable']) && !empty($_POST['dessert_changable'])) ? 1 : 0,
				"drinks_changable" => (isset($_POST['drinks_changable']) && !empty($_POST['drinks_changable'])) ? 1 : 0,
			);		


			if ($contentObj->insertMenu($data)){
				echo "TRUE";
				exit();
			}

		}
	}

	echo "FALSE";
	exit();
?>