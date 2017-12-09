<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.clientListPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">

		<table class="searchClientTb">
			<tr>
				<td>
					Registration Date
				</td>
			</tr>
			<tr>
				<td>
					Start Date
				</td>
				<td>
					<input type="text" class="startDate">
				</td>
			</tr>
			<tr>
				<td>
					End Date
				</td>
				<td>
					<input type="text" class="endDate">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btnSearchClientByDaten " value="Search">
				</td>
			</tr>
			<tr>
				<td>Search</td>
				<td>
					<input type="text" class='searchClientTxt'>
				</td>
			</tr>
		</table>

		<table class="clientListTb">
			<thead>
				<tr>
					<th>Email</th>
					<th>Fullname</th>
					<th>Contact No</th>
					<th>Date Registration</th>
				</tr>
			</thead>
			<tbody class="clientList"></tbody>
		</table>
	</div>

<script type="text/javascript">
	$(".startDate").datepicker();
	$(".endDate").datepicker();
</script>

<script type="text/javascript" src="assets/js/client_list.js"></script>
<?php require_once("footer.php"); ?>