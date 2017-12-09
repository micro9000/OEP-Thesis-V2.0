<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.venuePage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Venue</h4>
		</div>
		<div class="inputFlds_body">
			<table class="venueInputTb">
				<tr>
					<td class="inputFldTitle">New Venue</td>
					<td><input type="text" class="inputFld newVenue"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">Notes</td>
					<td>
						<textarea class="inputFld notes"></textarea>
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Outside venue</td>
					<td style="padding-left: 10px;">
						<label>
							<input type="checkbox" class="outsideVenue">
							YES
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
						<input type="submit" class="btn btnAddNewVenue" value="Add">
						<br/>
						<p class="venueMsg"></p>
					</td>
				</tr>
			</table>
		</div>
			
	</div>

	<div class="inputFlds">
		<table class="venueListTb">
			<thead>
				<tr>
					<th>Venue</th>
					<th>Notes</th>
					<th>Outside</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody class="venueList"></tbody>
		</table>
	</div>

<script type="text/javascript" src="assets/js/venues.js"></script>
<?php require_once("footer.php"); ?>