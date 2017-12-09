<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$items = array();
	$task = $_POST['task'];

	switch ($task) {

		case 'bySoup':
			$items = $contentModel->getMenuItem('soup');
			break;

		case 'byChicken':
			$items = $contentModel->getMenuItem('chicken');
			break;

		case 'bySeafoods':
			$items = $contentModel->getMenuItem('seafoods');
			break;

		case 'byPorkBeef':
			$items = $contentModel->getMenuItem('porkBeef');
			break;

		case 'byVegetable':
			$items = $contentModel->getMenuItem('vegetable');
			break;

		case 'byRice':
			$items = $contentModel->getMenuItem('rice');
			break;

		case 'bySalad':
			$items = $contentModel->getMenuItem('salad');
			break;

		case 'byDessert':
			$items = $contentModel->getMenuItem('dessert');
			break;

		case 'byDrinks':
			$items = $contentModel->getMenuItem('drinks');
			break;
		
		default:
			# code...
			break;
	}

	
	
	echo json_encode($items);
	exit();

?>