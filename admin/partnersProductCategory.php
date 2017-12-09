<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.partnersProdCatPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Product Category</h4>
		</div>
		<div class="inputFlds_body">
			<table class="prodCat_inputTb">
				<tr>
					<td class="inputFldTitle">Category</td>
					<td>
						<input type="text" class="inputFld category">
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<input type="submit" class="btn btnAddProductCat" value="Submit" /> <br/>
						<p class="categoryMsg"></p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="inputFlds">
		<table class="prodCat_inputTb">
			<thead>
				<tr>
					<th>Category</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody class="categories"></tbody>
		</table>
	</div>

<script type="text/javascript" src="assets/js/productCategory.js"></script>
<?php require_once("footer.php"); ?>