<?php session_start();
	
	require_once("../model/Admin_Model.php");

	$adminObj = new Admin_Model();

	$results = array("done" => "FALSE", "msg" => "Please login");

	if ($adminObj->isAdminLoggedIn()){

		if (isset($_POST['newuser_username']) && 
			isset($_POST['newuser_emailadd']) && 
			isset($_POST['newuser_password']) &&
			isset($_POST['newuser_usertype'])){

			$username = $_POST['newuser_username'];
			$email = $_POST['newuser_emailadd'];
			$password = $_POST['newuser_password'];
			$type = $_POST['newuser_usertype'];

			if (! is_numeric($type)){
				$results = array("done" => "FALSE", "msg" => "Invalid User type");
			}

			$passHash = hash('sha512', $password);

			$hashTag = $adminObj->getHashTag($username, $email, $passHash, $type);

			$isExists = $adminObj->getUserByHashTag($hashTag);

			if (sizeof($isExists) > 0){
				$results = array("done" => "FALSE", "msg" => "Users already added");
			}else{
				$numRowsAffected = $adminObj->insertNewUser($username, $email, $passHash, $type);

				if ($numRowsAffected > 0 && $numRowsAffected == 1){
					$results = array("done" => "TRUE", "msg" => "Successfully Added.");
				}else{
					$results = array("done" => "FALSE", "msg" => "Failed to add new user");
				}
			}	
		}
	}

	echo json_encode($results);
	exit();
?>