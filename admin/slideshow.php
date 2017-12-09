<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.slideshowPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>

	<div class="inputFlds">
		<?php if (isset($_GET['slideID'])): ?>
			<a href="slideshow.php"><< Back</a>
		<?php endif; ?>

		<div class="inputFlds_header">
			<h4>Upload Slideshow</h4>
		</div>
		<div class="inputFlds_body">
			<table class="slideshow_inputTb">
				<tr>
					<td class="inputFldTitle">Image</td>
					<td><input type="file" class="slideshowImage inputFld"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">First Title</td>
					<td><input type="text" class="firstTitle inputFld"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">Second Title</td>
					<td><input type="text" class="secondTitle inputFld"></td>
				</tr>
				<tr>
					<td class="inputFldTitle">Content</td>
					<td>
						<textarea class="slideShowContent inputFld"></textarea>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;" colspan="2">
						<?php if (isset($_GET['slideID'])): ?>
							<input type="submit" class="btn btnUpdateSlideshow" value="Update" />
							<input type="submit" class="btn btnDeleteSlideshow" value="Delete" /> <br/>
						<?php else: ?>
							<input type="submit" class="btn btnUploadSlideshow" value="Upload" /> <br/>
						<?php endif; ?>
						<p class="inputMsg"></p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="inputFlds">
		<table class="slideshowListTb">
			<thead>
				<tr>
					<th>First Title</th>
					<th>Second Title</th>
					<th>Content</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody class="slidehoswList">
				
			</tbody>
		</table>

		<?php if (isset($_GET['slideID'])): ?>
			<div class="slideImage">
			</div>
		<?php endif; ?>
	</div>

<script type="text/javascript">
		
	var slideID = <?php echo isset($_GET['slideID']) ? $_GET['slideID'] : 0; ?>;

</script>

<script type="text/javascript" src="assets/js/insert_slideshow.js"></script>
<?php require_once("footer.php"); ?>