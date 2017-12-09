<?php session_start();
	
	require_once("../model/Admin_Model.php");

	$adminObj = new Admin_Model();

	if ($adminObj->isAdminLoggedIn()){

		$task = $_POST['task'];

		switch ($task) {
			case 'username':
				
				if (isset($_POST['new_username']) && isset($_POST['current_password'])){

					$new_username = $_POST['new_username'];
					$cur_password = $_POST['current_password'];

					$numRowsAffected = $adminObj->changeAdminUsername($new_username, $cur_password);

					if ($numRowsAffected > 0 && $numRowsAffected == 1){
						echo "TRUE";
						exit();
					}else{
						echo "FALSE";
						exit();
					}

				}

				break;
			
			case 'password':
				
				if (isset($_POST['new_password']) && isset($_POST['current_password_2'])){

					$new_password = $_POST['new_password'];
					$cur_password = $_POST['current_password_2'];

					$numRowsAffected = $adminObj->changeAdminPassword($new_password, $cur_password);

					if ($numRowsAffected > 0 && $numRowsAffected == 1){
						echo "TRUE";
						exit();
					}else{
						echo "FALSE";
						exit();
					}

				}

				break;

			default:
				# code...
				break;
		}
	}

	echo "FALSE";
	exit();

?>