<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if ($admin_con->isAdminLoggedIn()){
		header("Location: main.php");
	}
?>


<?php require_once("header.php"); ?>

	<div class="login">
		<form class="loginForm" method="post">
			<div class="login_header">
			<h3>ADMIN PANEL LOGIN</h3>
			</div>
			<div class="login_body">
				<input type="text" class="inputFld userName" placeholder="Username"> <br/>
				<input type="password" class="inputFld password" placeholder="Password"> <br/>
			</div>
			<div class="login_footer">
				<input type="submit" class="btn btnLogin" value="Login"> <br/>
				<p class="loginMsg"></p>
			</div>
		</form>
	</div>

<script type="text/javascript" src="assets/js/login.js"></script>
<?php require_once("footer.php"); ?>