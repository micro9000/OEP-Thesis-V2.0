<?php
	
	require_once("database/Admin_Connection.php");

	class Admin_Model extends Admin_Connection{

		public function __construct(){
			parent::__construct();
		}

		public function login($username, $password){

			if (! $this->conn->connect_error){
				$username = $this->sanitizeInput($username);
				$password = $this->sanitizeInput($password);

				$hashPass = hash('sha512', $password);

				$query = "SELECT id, email_address, user_type FROM AdminUsers 
							WHERE isDeleted=0 AND username='".$username."' AND password='".$hashPass."' ";

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {
						$userData = array("id" => $row['id'], 
										"email_address" => $row['email_address'],
										"user_type" => $row['user_type']);

						return $userData;
					}

					$result->free();
				}
			}
			
			return array();
		}

		public function changeAdminUsername($newUsername, $password){

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection

				$newUsername = $this->sanitizeInput($newUsername);
				$password = $this->sanitizeInput($password);

				$hashPass = hash('sha512', $password);

				$query = "UPDATE AdminUsers SET username='". $newUsername ."' 
							WHERE password='". $hashPass ."' AND id=" .$adminID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function changeAdminPassword($newPassword, $password){

			if (! $this->conn->connect_error){

				$adminID = $this->getAdminID(); // connection

				$newPassword = $this->sanitizeInput($newPassword);
				$newPasswordHash = hash('sha512', $newPassword);

				$password = $this->sanitizeInput($password);
				$hashPass = hash('sha512', $password);

				$query = "UPDATE AdminUsers SET password='". $newPasswordHash ."' 
							WHERE password='". $hashPass ."' AND id=" .$adminID;

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getHashTag($userName, $email_address, $password, $userType){
			$text = $userName . $email_address . $password . $userType;
			$textHash = hash('sha512', $text);
			return $textHash;
		}

		// private function getStrongPass($hashPass, $userName){
		// 	$strToHash = $getHashTag . $userName;
		// 	$strongPass = hash('sha512', $strToHash);
		// 	return $strongPass;
		// }

		public function insertNewUser($username, $email_address, $password, $userType){

			if (! $this->conn->connect_error){

				$username = $this->sanitizeInput($username);
				$email_address = $this->sanitizeInput($email_address);
				$password = $this->sanitizeInput($password);
				$userType = $this->sanitizeInput($userType);

				$hashTag = $this->getHashTag($username, $email_address, $password, $userType);

				$query = "INSERT INTO AdminUsers(username, password, email_address, user_type, tag) ";
				$query .= "VALUES('". $username ."', '". $password ."', '". $email_address ."', ". $userType .", '". $hashTag ."')";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function updateUser($username, $email_address, $password, $userType, $uTag){

			if (! $this->conn->connect_error){

				$username = $this->sanitizeInput($username);
				$email_address = $this->sanitizeInput($email_address);
				$password = $this->sanitizeInput($password);
				$userType = $this->sanitizeInput($userType);
				$uTag = $this->sanitizeInput($uTag);

				$hashTag = $this->getHashTag($username, $email_address, $password, $userType);

				$query = "UPDATE AdminUsers SET username='". $username ."', password='". $password ."', ";
				$query .= "email_address='". $email_address ."', user_type=". $userType .", tag='". $hashTag ."' WHERE tag='". $uTag ."' ";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function DeleteUser($hashTag){

			if (! $this->conn->connect_error){

				$hashTag = $this->sanitizeInput($hashTag);

				$query = "UPDATE AdminUsers SET isDeleted=1 WHERE tag='". $hashTag ."' ";

				if ($this->conn->query($query) === TRUE){
                    return $this->conn->affected_rows;
                }
                return 0;
			}
		}

		public function getUsers_Query($query){

			$users = array();
			$userData = array();

			if (! $this->conn->connect_error){

				$result = $this->conn->query($query);

				if (is_object($result) && !empty($result->num_rows)) {
					while ($row = $result->fetch_assoc()) {

						$userData = array("username" => $row['username'],
										"email_address" => $row['email_address'],
										"user_type" => $row['user_type'],
										"tag" => $row['tag']
									);

						array_push($users, $userData);
					}

					$result->free();

					return $users;
				}
			}
			
			return $users;
		}

		public function getUserByHashTag($hastTag){
			$query = "SELECT * FROM AdminUsers WHERE isDeleted=0 AND tag='". $hastTag ."'";
			// echo $query;
			$users = $this->getUsers_Query($query);
			return $users;
		}

		public function getAllUsers(){
			$query = "SELECT * FROM AdminUsers WHERE isDeleted=0 ORDER BY id DESC";
			$users = $this->getUsers_Query($query);
			return $users;
		}
	}

?>