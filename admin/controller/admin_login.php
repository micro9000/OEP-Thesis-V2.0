<?php session_start();
	
	require_once("../model/Admin_Model.php");

	$adminObj = new Admin_Model();

	$loginMsg = array("done" => "FALSE", "msg" => "Login failed...");

	if (isset($_POST['username']) && isset($_POST['password'])){

		$username = $_POST['username'];
		$password = $_POST['password'];

		$userData = $adminObj->login($username, $password);

		if (sizeof($userData) > 0){

			$_SESSION['admin_userID'] = $userData['id'];
			$_SESSION['admin_email_address'] = $userData['email_address'];
			$_SESSION['admin_username'] = $username;
			$_SESSION['user_type'] = $userData['user_type'];
			$_SESSION['admin_loggedIn'] = true;

			$loginMsg = array("done" => "TRUE", "msg" => "Logged in");
		}else{
			$loginMsg = array("done" => "FALSE", "msg" => "Invalid username or password");
			
		}
	}

	echo json_encode($loginMsg);
	exit();
?>