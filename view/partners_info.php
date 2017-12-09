<?php session_start(); ?>
<?php require_once("header.php"); ?>

<?php require_once("navbar.php"); ?>

<?php if (isset($_GET['partnerID'])): ?>

	<div class="partners_info">
		
		<div class="container">
			<div class="row partnersInfos">

			</div>
		</div>

	</div>
	
<?php else: ?>
	
	
	<div class="partners_info">
		<h2>Not found</h3>
	</div>
	
<?php endif; ?>

<script type="text/javascript" src="../assets/js/partners.js"></script>
<?php require_once("footer.php"); ?>