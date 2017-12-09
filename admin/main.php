<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.homePage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>EVENTS</h4>
		</div>
		<div class="inputFlds_body">
			<table class="filterEventTb">
				<tr>
					<td>Filter</td>
					<td>
						<select class="filterEventSelect">
							<option value="1">New</option>
							<option value="2">Approved</option>
							<option value="3">On-going preparation</option>
							<option value="4">Event on-going</option>
							<option value="5">Done</option>
							<option value="6">Cancel</option>
						</select>
					</td>
				</tr>
			</table>
			<table class="newEventsTb">
				<thead>
					<tr>
						<th>Type of Event</th>
						<th>Motif</th>
						<th>Type of Venue</th>
						<th>Address</th>
						<th>Date</th>
						<th>Start time</th>
						<th>End time</th>
						<th>No of Guests</th>
						<th>Entry Date</th>
						<th>Status</th>
						<th>View</th>
					</tr>
				</thead>
				<tbody class="newEventsList"></tbody>
			</table>

		</div>
	</div>

<script type="text/javascript" src="assets/js/main.js"></script>
<?php require_once("footer.php"); ?>