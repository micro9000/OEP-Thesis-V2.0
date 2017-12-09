<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.servicesPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Services</h4>
		</div>
		<div class="inputFlds_body">
			<table class="servicesInputFldsTb">
				<thead>
					<tr>
						<th colspan="2">Enter Services</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="inputFldTitle">Service</td>
						<td>
							<input type="text" class="inputFld serviceTitle">
							<input type="submit" class="btn btnAddService" value="Add">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center">
							<p class="serviceInputMsg"></p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="servicesListTb">
				<thead>
					<tr>
						<th>Service</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody class="servicesList"></tbody>
			</table>
		</div>
	</div>


	<div class="inputFlds">
		<table class="serviceMotifFldsTb">
			<thead>
				<tr>
					<th colspan="2" style="text-align:center;">Enter Service Motif</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="inputFldTitle">Service</td>
					<td>
						<select class="inputFld serviceSelect"></select>
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Motif</td>
					<td>
						<input type="text" class="inputFld serviceMotif">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
						<input type="submit" class="btn btnAddServiceMotif" value="Add">
					</td>
				</tr>
			</tbody>
		</table>

		<br/>
		<p>
			Filter
			<select class="filterServiceMotif"></select>
		</p>

		<table class="serviceMotifListTb">
			<thead>
				<tr>
					<th>Service</th>
					<th>Motif</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody class="motifs"></tbody>
		</table>
	</div>
<script type="text/javascript" src="assets/js/services.js"></script>
<?php require_once("footer.php"); ?>