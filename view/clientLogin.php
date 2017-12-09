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

					<form class="clientLoginForm" method="post">
						<div class="loginForm">
							<div class="formHeader">
								CLIENT LOG IN
							</div>
							<div class="formBody">
								<div class="form-group">
	  								<input type="text" class="form-control clientEmail" id="usr" placeholder="Email address">
								</div>
								<div class="form-group">
								  	<input type="password" class="form-control clientPassword" id="pwd" placeholder="Password">
								</div>
							</div>
							<div class="formFooter">
								<input type="submit" class="btn btn-warning btnClientLogin" value="Login"><br/>
								<a href="forgotPassword.php">Forgot password?</a>
								<p class="loginMsg"></p>
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript" src="../assets/js/clientLogin.js"></script>
<?php require_once("footer.php"); ?>