<?php session_start();
	require_once("header.php");
?>
<?php

	$uniqueTag = "";
	if (isset($_GET['regTag'])) {

		$uniqueTag = $_GET['regTag'];

		if (strlen($uniqueTag) != 128){
			header("Location: home.php");
		}

		require_once("../model/Content_Model.php");
		$contentModel = new Content_Model();

		if ($contentModel->isUniqueTagIsRegistered($uniqueTag) === false){
			header("Location: clientLogin.php");
		}

	}else{
		header("Location: home.php");
	}
?>

<?php require_once("navbar.php"); ?>

	<div class="main">
		<div class="client-registration-form">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="registration-form">
							<div class="regFormHeader">
								<h3>Client Information</h3>
							</div>
							<div class="regFormBody">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="clientEmail">Your email address</label>
		  								<input type="email" class="form-control clientEmail" disabled="disabled">
									</div>

									<div class="form-group">
										<label for="clientFullName">Full name (required)</label>
		  								<input type="text" class="form-control clientFullName">
									</div>

									<div class="form-group">
										<label for="clientContactNo">Contact No (required)</label>
		  								<input type="text" class="form-control clientContactNo" placeholder="+63 or 0 + xxxxxxxxxx">
									</div>

									<div class="form-group">
										<label for="clientPassword">Password (required)</label>
		  								<input type="password" class="form-control clientPassword">
									</div>

									<div class="form-group">
										<label for="clientConfirmPassword">Confirm Password</label>
		  								<input type="password" class="form-control clientConfirmPassword">
									</div>

									<div class="form-group">
										<button type="button" class="btn btnInsertClientInfo">SUBMIT</button>
										<br/>
										<p class="registerMsg"></p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					</div>
				</div>
			</div>
		</div>
	</div>


<script type="text/javascript">
	var uniqueTag = "<?php echo isset($_GET['regTag']) ? $_GET['regTag'] : "-"; ?>";
</script>

<script type="text/javascript" src="../assets/js/registration_phaseone.js"></script>
<?php require_once("footer.php"); ?>
