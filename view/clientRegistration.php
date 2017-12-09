<?php session_start(); ?>

<?php require_once("header.php"); ?>

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
							<h3>Registration</h3>
						</div>
						<div class="regFormBody">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="clientEmail">Please enter your email address</label>
	  								<input type="email" class="form-control clientEmail" placeholder="email address">
								</div>
								<div class="form-group">
									<button type="button" class="btn btnEmailRegister">SUBMIT</button>
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

<script type="text/javascript" src="../assets/js/registration.js"></script>
<script type="text/javascript" src="../assets/jquery-timepicker/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/jquery-timepicker/jquery.timepicker.css">
<!-- <script type="text/javascript">
	$(".startTime").timepicker();
</script> -->
<?php require_once("footer.php"); ?>