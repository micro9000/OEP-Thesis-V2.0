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
</style>


<?php require_once("navbar.php"); ?>

<?php if (isset($_GET['imageID']) && isset($_GET['eventID'])): ?>

	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 recent_events_info">
			</div>
			<div class="col-lg-12 col-md-12">
				<div style="text-align: center;">
					<input type="submit" class="btn btnDeleteImage" value="Delete">
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		var imageID = <?php echo isset($_GET['imageID']) ? $_GET['imageID'] : 0; ?>;
		var eventID = <?php echo isset($_GET['eventID']) ? $_GET['eventID'] : 0; ?>;

		$(document).ready(function(){

			if (imageID != 0 && imageID > 0 && eventID != 0 && eventID > 0){
				$.post(
					"controller/getRecentEventImage.php",
					{
						"eventID" : eventID,
						"imageID" : imageID
					},
					function(data){
						var dataObj = JSON.parse(data);
						// console.log(data);

						if (dataObj.length > 0){
							$(".recent_events_info").html("<img class='img-fluid img-thumbnail' src='../uploads/Events/"+ dataObj[0].serverName +"' alt=''>")	
						}
					}
				);
			}
		});

		$(".btnDeleteImage").on("click", function(){

			if (imageID != 0 && imageID > 0){
				var r = confirm("Are you sure you want to delete this image?");

				if (r == true){
					$.post(
						"controller/delete_recent_event_image.php",
						{
							"imageID" : imageID
						},
						function(data){
							if (data == "TRUE"){
								alert("Deleted");
								window.location = "recent_events.php?eventID=" + eventID;
							}
						}
					)
				}
			}
				
		})
	</script>

<?php endif; ?>
<?php require_once("footer.php"); ?>