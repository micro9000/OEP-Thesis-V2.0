<?php session_start();
	
	require_once("../model/Content_Model.php");

	$contentModel = new Content_Model();

	if ($contentModel->isAdminLoggedIn()){
		if (isset($_POST['paymentMethod'], $_POST['isPaid'], $_POST['billID'])){

			$affectRows = $contentModel->updateClientBillPaymentStatus($_POST['paymentMethod'], $_POST['isPaid'], $_POST['billID']);

			if ($affectRows > 0){
				echo "TRUE";
				exit();
			}

		}
	}

	echo "FALSE";
	exit();
?>