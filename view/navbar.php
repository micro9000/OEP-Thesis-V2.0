
	<header>
		<div class="navigation">
			<div class="container">
				<div class="row">
					<?php if (! $contentModel->isClientLoggedIn()): ?>

						<div class="col-lg-5 col-md-12 col-sm-12">
							<div class="branding">
								<a href="home.php">
									<p>ONE BUFFET Restaurant <br/> & Catering Services</p>
								</a>
							</div>
						</div>

						<div class="col-lg-7 col-md-12 col-sm-12">
							<nav>
								<ul class="navbar">
									<li><a href="about_us.php">ABOUT US</a></li>
									<li><a href="portfolio.php">PORTFOLIO</a></li>
									<li><a href="services.php">SERVICES</a></li>
									<li><a href="clientRegistration.php">REGISTER</a></li>
									<li><a href="contact.php">INQUIRY</a></li>
									<li><a href="clientLogin.php">LOGIN</a></li>
								</ul>
							</nav>
						</div>

					<?php else: ?>

						<div class="col-lg-5 col-md-12 col-sm-12">
							<div class="branding">
								<a href="home.php">
									<p>ONE BUFFET Restaurant <br/> & Catering Services</p>
								</a>
							</div>
						</div>

						<div class="col-lg-7 col-md-12 col-sm-12">
							<nav>
								<ul class="navbar">
									<li><a href="clientDashboard.php">HOME</a></li>
									<li><a href="clientEventStatus.php">EVENT STATUS</a></li>
									<li><a href="clientRecentEvents.php">RECENT EVENTS</a></li>
									<li><a href="clientSettings.php">SETTINGS</a></li>
									<li><a href="clientLogout.php">LOGOUT</a></li>
								</ul>
							</nav>
						</div>

					<?php endif; ?>

					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="handle">
							MENU
							<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<script type="text/javascript">
		$(".handle").on("click", function(){
			$(".navbar").toggleClass("showing");
		})
	</script>
<!-- 	<nav>
		<ul class="topnav">
			<li><a href="#" class="compName">COMPANY NAME</a></li>
			<li><a href="#">ABOUT US</a></li>
			<li><a href="#">SERVICES</a></li>
			<li><a href="#">REGISTER</a></li>
			<li><a href="#">LOGIN</a></li>
			<li><a href="javascript:void(0);" style="font-size:20px;" class="icon" onclick="myFunction()">&#9776;</a></li>
		</ul>
	</nav>
 -->
<!-- <script type="text/javascript">
	// function myFunction() {
	//     var x = document.getElementById("myTopnav");
	//     if (x.className === "topnav") {
	//         x.className += " responsive";
	//     } else {
	//         x.className = "topnav";
	//     }
	// }
</script> -->
