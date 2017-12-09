<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.recentEventPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>

	<div class="inputFlds">
		<?php if (isset($_GET['eventID'])): ?>
			<a href="recent_events.php"><< Back</a>
		<?php endif; ?>

		<div class="inputFlds_header">
			<h4>Recent events</h4>
		</div>
		<div class="inputFlds_body">
			<table class="recentEvent_inputTb">
				<tr>
					<td class="inputFldTitle">Event Category</td>
					<td>
						<select class="services inputFld"></select>
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Event Title</td>
					<td>
						<input type="text" class="eventTitle inputFld">
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Address</td>
					<td>
						<input type="text" class="address inputFld">
					</td>
				</tr>

				<tr>
					<td class="inputFldTitle">Date</td>
					<td>
						<input type="text" class="eventDate inputFld">
					</td>
				</tr>

				<tr>
					<td class="inputFldTitle">Description</td>
					<td>
						<textarea class="recentEventDescription inputFld"></textarea>
					</td>
				</tr>

				<tr>
					<td class="inputFldTitle">Client Comments</td>
					<td>
						<textarea class="recentEventClientComments inputFld"></textarea>
					</td>
				</tr>

				<tr>
					<td class="inputFldTitle">Images</td>
					<td>
						<input type="file" class="uploadCheckList inputFld" multiple>
					</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align: center;">
						<?php if (isset($_GET['eventID'])): ?>
							<input type="submit" class="btn btnUpdateEvent" value="Update" />
							<input type="submit" class="btn btnDeleteEvent" value="Delete" /> <br/>
						<?php else: ?>
							<input type="submit" class="btn btnAddNewEvent" value="Submit" /> <br/>
						<?php endif ?>
						<p class="eventsMsg"></p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="inputFlds">
		<table class="recentEventsListTb">
			<thead>
				<tr>
					<th>Category</th>
					<th>Event Name</th>
					<th>Address</th>
					<th>Date</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody class="eventList">
			</tbody>
		</table>

		<?php if (isset($_GET['eventID'])): ?>
			<br/>
			<br/>
			<div class="container">
				<div class="row text-center text-lg-left eventImages">
				</div>
			</div>
		<?php endif; ?>
	</div>

<script type="text/javascript">
	$(".eventDate").datepicker();

	var eventID = <?php echo isset($_GET['eventID']) ? $_GET['eventID'] : 0; ?>;
	
</script>
<script type="text/javascript" src="assets/js/recent_events.js"></script>
<?php require_once("footer.php"); ?>