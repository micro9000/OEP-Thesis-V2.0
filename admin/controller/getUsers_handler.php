<?php session_start();

	require_once("../model/Admin_Model.php");

	$adminObj = new Admin_Model();
	$users = array();
	if ($adminObj->isAdminLoggedIn()){
		$task = $_POST['task'];

		switch ($task) {
			case 'all':
				$users = $adminObj->getAllUsers();
				break;

			case 'byTag':
				$tag = $_POST['tag'];
				$users = $adminObj->getUserByHashTag($tag);
				
				break;

			default:
				# code...
				break;
		}
	}

	echo json_encode($users);
	exit();
?>