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
	.partner_motifImage, .updatePrice{
		text-align: center;
		padding: 20px;
	}
	.partner_motifImage img{
		max-width: 300px;
		max-height: 400px;
	}
</style>


<?php require_once("navbar.php"); ?>

<?php if (isset($_GET['imageID']) && isset($_GET['motifID'])): ?>

	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 partner_motifImage"></div>
			<div class="col-lg-12 col-md-12 updatePrice">
				Update Price
				<input type="text" class="itemPrice"><br/>
				<p class="priceMsg"></p>
			</div>
			<div class="col-lg-12 col-md-12">
				<div style="text-align: center;">
					<input type="submit" class="btn btnUpdatePrice" value="Update Price">
					<input type="submit" class="btn btnDeleteImage" value="Delete">
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		var imageID = <?php echo isset($_GET['imageID']) ? $_GET['imageID'] : 0; ?>;
		var motifID = <?php echo isset($_GET['motifID']) ? $_GET['motifID'] : 0; ?>;
		var partnerID = <?php echo isset($_GET['partnerID']) ? $_GET['partnerID'] : 0; ?>;

		$(document).ready(function(){

			if (imageID != 0 && imageID > 0 &&
				 motifID != 0 && motifID > 0){

				$.post(
					"controller/getPartners_handler.php",
					{
						"task" : "imageByID",
						"imageID" : imageID
					},
					function(data){
						// console.log(data);
						var dataObj = JSON.parse(data);
						
						if (dataObj.length > 0){
							$(".partner_motifImage").html("<img class='img-fluid img-thumbnail' src='../uploads/PartnersMotif/"+ dataObj[0].serverName +"' alt=''>");	
						}
					}
				);
			}
		});

		$(".btnDeleteImage").on("click", function(){

			if (imageID != 0 && imageID > 0 && partnerID != 0 && partnerID > 0){
				var r = confirm("Are you sure you want to delete this image?");

				if (r == true){
					$.post(
						"controller/delete_partner_motif_image.php",
						{
							"imageID" : imageID
						},
						function(data){
							// console.log(data);
							if (data == "TRUE"){
								alert("Deleted");
								window.location = "partners.php?partnerID="+ partnerID +"&motifID=" + motifID;
							}
						}
					)
				}
			}
				
		});

		$(".btnUpdatePrice").on("click", function(){
			var itemPrice = $(".itemPrice").val();

			if (isNaN(itemPrice)){
				alert("Invalid Price");
				return;
			}

			if (imageID != 0 && imageID > 0){
				$.post(
					"controller/updatePartnersMotifItemPrice.php",
					{
						"itemPrice" : itemPrice,
						"imageID" : imageID
					},
					function(data){
						if (data === "TRUE"){
							$(".priceMsg").html("Updated");
							$(".itemPrice").val("");
						}
					}
				);
			}
		});
	</script>

<?php endif; ?>
<?php require_once("footer.php"); ?>