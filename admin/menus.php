<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.menusPage{
		border-bottom: 2px solid white;
	}
</style>
<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<?php if(isset($_GET['menuID'])): ?>
			<a href="menus.php"><< Back</a>
		<?php endif; ?>

		<div class="inputFlds_header">
			<h4>Menus</h4>
		</div>
		<div class="inputFlds_body">
			<table class="menusInputFlds">
				<thead>
					<tr>
						<th>Items</th>
						<th>Enter Menus</th>
						<th>Changable</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="inputFldTitle">Set Title</td>
						<td><input type="text" class="inputFld setTitle"></td>
						<td></td>
					</tr>

					<tr>
						<td class="inputFldTitle">Set Price</td>
						<td><input type="text" class="inputFld setPrice"></td>
						<td></td>
					</tr>

					<tr>
						<td class="inputFldTitle">SOUP</td>
						<td><input type="text" class="inputFld soup"></td>
						<td class="menuCheckbox"><input type="checkbox" class="soup_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">CHICKEN</td>
						<td><input type="text" class="inputFld chicken"></td>
						<td class="menuCheckbox"><input type="checkbox" class="chicken_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">SEAFOODS</td>
						<td><input type="text" class="inputFld seafoods"></td>
						<td class="menuCheckbox"><input type="checkbox" class="seafoods_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">PORK/BEEF</td>
						<td><input type="text" class="inputFld pork_beef"></td>
						<td class="menuCheckbox"><input type="checkbox" class="pork_beef_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">VEGETABLE</td>
						<td><input type="text" class="inputFld vegetable"></td>
						<td class="menuCheckbox"><input type="checkbox" class="vegetable_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">RICE</td>
						<td><input type="text" class="inputFld rice"></td>
						<td class="menuCheckbox"><input type="checkbox" class="rice_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">SALAD</td>
						<td><input type="text" class="inputFld salad"></td>
						<td class="menuCheckbox"><input type="checkbox" class="salad_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">DESSERT</td>
						<td><input type="text" class="inputFld dessert"></td>
						<td class="menuCheckbox"><input type="checkbox" class="dessert_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td class="inputFldTitle">DRINKS</td>
						<td><input type="text" class="inputFld drinks"></td>
						<td class="menuCheckbox"><input type="checkbox" class="drinks_changable" value="YES">YES</td>
					</tr>

					<tr>
						<td colspan="3" style="text-align: center;">
							<?php if(isset($_GET['menuID'])): ?>
								<input type="submit" class="btn btnUpdateMenu" value="UPDATE"> 
								<input type="submit" class="btn btnDeleteMenu" value="DELETE"> 
							<?php else: ?>
								<input type="submit" class="btn btnInsertMenu" value="ADD"> 
							<?php endif; ?>
							<br/>
							<p class="menusInputMsg"></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
	</div>

	<div class="inputFlds">
		<table class="menusListTb">
			<thead>
				<tr>
					<th>Title</th>
					<th>Price</th>
					<th>Soup</th>
					<th>Chicken</th>
					<th>Seafoods</th>
					<th>Pork/Beef</th>
					<th>Vegetable</th>
					<th>Rice</th>
					<th>Salad</th>
					<th>Dessert</th>
					<th>Drink</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody class="menusLst"></tbody>
		</table>
	</div>

<script type="text/javascript">
	
	var menuID = <?php echo isset($_GET['menuID']) ? $_GET['menuID'] : 0; ?>;

</script>
<script type="text/javascript" src="assets/js/menus.js"></script>
<?php require_once("footer.php"); ?>