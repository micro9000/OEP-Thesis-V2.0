<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.budgetRangesPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Budget Ranges</h4>
		</div>
		<div class="inputFlds_body">
			<table class="budgetInputTb">
				<tr>
					<td class="inputFldTitle">Budget Range</td>
					<td>
						<input type="text" class="inputFld budgetRange">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;">
						<input type="submit" class="btn btnAddNewBudgetRange" value="Add">
						<br/>
						<p class="budgetRangeMsg"></p>
					</td>
				</tr>
			</table>
		</div>
			
	</div>

	<div class="inputFlds">
		<table class="budgetListTb">
			<thead>
				<tr>
					<th>Budget Range</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody class="budgetList"></tbody>
		</table>
	</div>

<script type="text/javascript" src="assets/js/budgetRanges.js"></script>
<?php require_once("footer.php"); ?>