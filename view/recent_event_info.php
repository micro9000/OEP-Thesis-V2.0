<?php session_start(); ?>
<?php require_once("header.php"); ?>

<?php require_once("navbar.php"); ?>

<div class="eventInfo">

	<div class="container">
		<div class="row">
			
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="w3-content w3-section eventImages_info" style="max-width:500px">
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 eventDetailInfo">
				<h3 id="eventName"></h3>
				<div id="address"></div>
				<div id="eventDate"></div>
				<div id="service"></div>
				<div id="description"></div>

				<div class="commentSection">
					<h6>Client Comments:</h6>
					<p id="clientComments"></p>
				</div>
			</div>

		</div>
	</div>

</div>

<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    // var x = document.getElementsByClassName("mySlides");

    var x = $(".mySlides");

    for (i = 0; i < x.length; i++) {
       // x[i].style.display = "none";  
       $(".mySlides:eq("+ parseInt(i) +")").css("display", "none");
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    // x[myIndex-1].style.display = "block";  
	$(".mySlides:eq("+ parseInt(myIndex-1) +")").css("display", "block");

    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script>

<script type="text/javascript">
	var eventID = <?php echo isset($_GET['eventID']) ? $_GET['eventID'] : 0; ?>;
</script>


<?php require_once("footer.php"); ?>