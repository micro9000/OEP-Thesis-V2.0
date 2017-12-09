<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.materialsPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Materials</h4>
		</div>
		<div class="inputFlds_body">
			<table class="inputMaterialsTb">
				<tr>
					<td class="inputFldTitle">Material</td>
					<td>
						<input type="text" class="inputFld material">
						<input type="submit" class="btn btnAddMaterial" value="Add">
					</td>
				</tr>
			</table>

			<p class="materialInputMsg"></p>

			<table class="materialListTb">
				<thead>
					<tr>
						<th>Materials</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody class="materialsList">
				</tbody>
			</table>
		</div>
		
	</div>

	<div class="inputFlds">
		<?php if(isset($_GET['themeID'])): ?>
			<a href="materials.php"><< Back</a>
		<?php endif; ?>

		<table class="materialMotif">
			<tr>
				<td class="inputFldTitle">Select Material</td>
				<td>
					<select class="inputFld materialsSelect">
					</select>
				</td>
			</tr>
			<tr>
				<td class="inputFldTitle">Theme</td>
				<td>
					<input type="text" class="inputFld materialTheme">
				</td>
			</tr>
			<tr>
				<td class="inputFldTitle">Images</td>
				<td>
					<input type="file" class="inputFld materialImgs" multiple="multiple">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" class="btn btnAddMaterialTheme" value="Add"><br/>
					<p class="materialThemeMsg"></p>
				</td>
			</tr>
		</table>

	</div>

	<div class="inputFlds">

		<p>Filter 
			<select class="filterMaterialThemeList">
			</select>
		</p>

		<table class="materialThemeListTb">
			<thead>
				<tr>
					<th>Material</th>
					<th>Theme</th>
					<th>Images</th>
				</tr>
			</thead>
			<tbody class="materialThemes">
			</tbody>
		</table>

		<?php if(isset($_GET['themeID'])): ?>

			<table class="materialThemeListTb">
				<tr>
					<td style="text-align:center;">
						<input type="submit" class="btn btnDeleteTheme" value="Delete">
						<br/>
					</td>
				</tr>
			</table>

			<div class="container">
				<div class="row text-center text-lg-left materialsImages">
				</div>
			</div>
		<?php endif; ?>
	</div>

<script type="text/javascript">
	
	var themeID = <?php echo isset($_GET['themeID']) ? $_GET['themeID'] : 0; ?>;

</script>
<script type="text/javascript" src="assets/js/materials.js"></script>
<?php require_once("footer.php"); ?>