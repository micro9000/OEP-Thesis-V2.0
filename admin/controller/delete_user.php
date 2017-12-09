<?php session_start();

	require_once("../model/Admin_Model.php");

	$adminObj = new Admin_Model();

	if ($adminObj->isAdminLoggedIn()){
		if (isset($_POST['uTag'])){
			$uTag = $_POST['uTag'];

			$rowsAffected = $adminObj->DeleteUser($uTag);

			if ($rowsAffected > 0){
				echo "TRUE";
				exit();
			}
		}
	}

	echo "FALSE";
	exit();
?>