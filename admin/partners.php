<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.partnersPage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">

		<?php if(isset($_GET['partnerID'])): ?>
			<a href="partners.php"><< Back</a>
		<?php endif; ?>

		<div class="inputFlds_header">
			<h4>Partners</h4>
		</div><div class="inputFlds_body">
		
			<table class="partners_inputTb">
				<tr>
					<td class="inputFldTitle">Partner's Name</td>
					<td>
						<input type="text" class="inputFld partnersName">
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Partner's INFO</td>
					<td>
						<textarea class="inputFld partnersInfo partnersInfo"></textarea>
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Partner's contact Smart</td>
					<td>
						<input type="text" class="inputFld partnersSmart">
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Partner's contact GLOBE</td>
					<td>
						<input type="text" class="inputFld partnersGlobe">
					</td>
				</tr>
				<tr>
					<td class="inputFldTitle">Partner's contact Email</td>
					<td>
						<input type="text" class="inputFld partnersEmail">
					</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align: center;">

						<?php if(isset($_GET['partnerID'])): ?>
							<input type="submit" class="btn btnUpdatePartner" value="Update" />
							<input type="submit" class="btn btnDeletePartner" value="Delete" /> <br/>
						<?php else: ?>
							<input type="submit" class="btn btnAddNewPartner" value="Submit" /> <br/>

						<?php endif; ?>
						<p class="partnerInputMsg"></p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="inputFlds">
		<table class="partnersListTb">
			<thead>
				<tr>
					<th>Name</th>
					<th>Info</th>
					<th>Smart</th>
					<th>GLOBE</th>
					<th>Email</th>
					<th>View</th>
				</tr>
			</thead>
			<tbody class="partnersList">
			</tbody>
		</table>
	</div>

	|<?php if(isset($_GET['partnerID'])): ?>

		<div class="inputFlds">
			<?php 
				if(isset($_GET['motifID'])){
					echo "<a href='partners.php?partnerID=". $_GET['partnerID'] ."'><< Back </a>";
				}
			?>

			<table class="motifInputFlds">
				<thead>
					<tr>
						<th colspan="2" style="text-align: center;">Enter Motif</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="inputFldTitle">Motif</td>
						<td><input type="text" class="inputFld motif"></td>
					</tr>
					<tr>
						<td class="inputFldTitle">Product Category</td>
						<td>
							<select class="inputFld prodCategory"></select>
						</td>
					</tr>
					<tr>
						<td class="inputFldTitle">Images</td>
						<td><input type="file" class="inputFld motifImages" multiple="multiple"></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="submit" class="btn btnInsertPartnerMotif" value="Submit">

							<br/>
							<p class="motifError"></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="inputFlds">
			<table class="motifListTb">
				<thead>
					<tr>
						<th>Theme</th>
						<th>Product category</th>
						<th>Images</th>
					</tr>
				</thead>
				<tbody class="motifs">
				</tbody>
			</table>
			
			<?php if(isset($_GET['partnerID']) && isset($_GET['motifID'])): ?>
				<table class="motifListTb">
					<tr>
						<td style="text-align:center;">
							
								<input type="submit" class="btn btnDeleteMotif" value="Delete">
							
						</td>
					</tr>
				</table>
			<?php endif; ?>

			<br/>
			<div class="container">
				<div class="row text-center text-lg-left partnerMotifsImages">
				</div>
			</div>
		</div>

	<?php endif; ?>

<script type="text/javascript">
		
	var partnerID = <?php echo isset($_GET['partnerID']) ? $_GET['partnerID'] : 0; ?>;
	var motifID = <?php echo isset($_GET['motifID']) ? $_GET['motifID'] : 0; ?>;

</script>

<script type="text/javascript" src="assets/js/partners.js"></script>
<?php require_once("footer.php"); ?>