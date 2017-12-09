<?php session_start();

	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	$email = "";

	if (isset($_POST['uniqueTag'])){

		$uniqueTag = $_POST['uniqueTag'];

		if ($contentModel->isUniqueTagIsRegistered($uniqueTag) === true){
			$email = $contentModel->getClientEmail($uniqueTag);
		}
	}

	echo $email;
	exit();
?>