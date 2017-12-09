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
	.theme_image, .enterPrice{
		text-align: center;
		padding: 20px;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Material Theme image</h4>
		</div>
		<div class="inputFlds_body">
			<?php if(isset($_GET['imageID']) && isset($_GET['themeID'])): ?>

				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 theme_image"></div>
						<div class="col-lg-12 col-md-12 enterPrice">
							Update Price
							<input type="text" class="materialPrice"><br/>
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
					var themeID = <?php echo isset($_GET['themeID']) ? $_GET['themeID'] : 0; ?>;

					$(document).ready(function(){
						if (imageID != 0 && imageID > 0 && themeID != 0 && themeID > 0){

							$.post(
								"controller/getMaterial_handler.php",
								{
									"task" : "imageID",
									"imageID" : imageID
								},
								function(data){
									var dataObj = JSON.parse(data);
									$(".theme_image").html("<img class='img-fluid img-thumbnail' src='../uploads/Materials/"+ dataObj[0].serverName +"' alt=''>");
									// console.log(data);
								}
							);
						}
					})

					$(".btnDeleteImage").on("click", function(){

						if (imageID != 0 && imageID > 0){
							var r = confirm("Are you sure you want to delete this image?");

							if (r == true){
								$.post(
									"controller/delete_material_theme_image.php",
									{
										"imageID" : imageID
									},
									function(data){
										if (data == "TRUE"){

											insertUserAction("Delete Material theme image");

											alert("Deleted");
											window.location = "materials.php?themeID=" + themeID;
										}
									}
								)
							}
						}
					})

					$(".btnUpdatePrice").on("click", function(){
						var price = $(".materialPrice").val();

						if (isNaN(price)){
							alert("Invalid Price");
							return;
						}

						if (imageID != 0 && imageID > 0){
							$.post(
								"controller/updateMaterialPrice.php",
								{
									"price" : price,
									"imageID" : imageID
								},
								function(data){
									console.log(data);
									if (data === "TRUE"){

										insertUserAction("Update Material theme image price to ("+ price +")");

										$(".priceMsg").html("Updated");
										$(".materialPrice").val("");
									}
								}
							);
						}
							
					});
				</script>
			<?php endif; ?>
		</div>
	</div>
<?php require_once("footer.php"); ?>