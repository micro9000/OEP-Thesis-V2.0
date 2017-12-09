<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.inquiriesPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	<div class="inputFlds">
		<?php if(isset($_GET['inqID'])): ?>
			<a href="inquiries.php"><< Back</a>
		<?php endif; ?>

		<table class="inquiriesTb">
			<thead>
				<tr>
					<th>Email</th>
					<th>Name</th>
					<th>Contact No</th>
					<th>Event</th>
					<th>Venue</th>
					<th>Venue Address</th>
					<th>No of Guests</th>
					<th>Date</th>
					<th>Inquiries</th>
				</tr>
			</thead>
			<tbody class="inquiriesList"></tbody>
		</table>

		<?php if(isset($_GET['inqID'])): ?>
			<br/>
			<h4>Inquiry:</h4>
			<p class="inquiry"></p>
			
			<input type="submit" class="btn btnDeleteInquiry" id="<?php echo $_GET['inqID']; ?>" value="Delete	" />
		<?php endif; ?>
	</div>

<script type="text/javascript">

	var inqID = <?php echo isset($_GET['inqID']) ? $_GET['inqID'] : 0; ?>;

</script>
<script type="text/javascript" src="assets/js/inquiries.js"></script>
<?php require_once("footer.php"); ?>