<?php session_start();
	require_once("header.php"); 
?>

<?php
	if ($contentModel->isClientLoggedIn()){
		header("Location: clientDashboard.php");
	}
?>

<?php require_once("navbar.php"); ?>
<div class="main">

	<div class="client-login-form">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				</div>

				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

					<form class="recoverMyPassForm" method="post">
						<div class="loginForm">
							<div class="formHeader">
								ENTER YOUR NEW PASSWORD
							</div>
							<div class="formBody">
								<div class="form-group">
	  								<input type="password" class="form-control newPass" id="usr" placeholder="new password">
								</div>
							</div>
							<div class="formBody">
								<div class="form-group">
	  								<input type="password" class="form-control confirmPass" id="usr" placeholder="confirm password">
								</div>
							</div>
							<div class="formFooter">
								<input type="submit" class="btn btn-warning btnChangeMyPassword" value="Submit">
								<br/>
								<p class="recMsg"></p>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	var tag = '<?php echo (isset($_GET['tag'])) ? $_GET['tag'] : '-'; ?>';
	var email = '<?php echo (isset($_GET['email'])) ? $_GET['email'] : '-'; ?>';
</script>

<script type="text/javascript" src="../assets/js/forgotPass.js"></script>
<?php require_once("footer.php"); ?>