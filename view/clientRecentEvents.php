<?php session_start();
	require_once("header.php"); 
?>
<?php
	
	if (! $contentModel->isClientLoggedIn()){
		header("Location: clientLogin.php");
	}

?>

<?php require_once("navbar.php"); ?>

<div class="clientDashboard">
	<div class="container-fluid">
		<div class="recentEventsList">
			<h3>Recent Events</h3>

			<table class="table table-bordered recentEventsTb">
				<thead>
					<tr>
						<th>Type of Event</th>
						<th>Motif</th>
						<th>Type of Venue</th>
						<th>Date</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>No of Guests</th>
						<th>Entry Date</th>
					</tr>
				</thead>
				<tbody class="clientRecentEventList"></tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$.post(
			"../controller/getAllClientRecentEvents.php",
			function(data){
				// console.log(data);
				var dataObj = JSON.parse(data);
				var dataLen = dataObj.length;

				var events = "";

				for(var i=0; i<dataLen; i++){
					events += "<tr>";
					events += "<td>"+ dataObj[i].service +"</td>";
					events += "<td>"+ dataObj[i].motif +"</td>";
					events += "<td>"+ dataObj[i].venue +"</td>";
					events += "<td>"+ dataObj[i].eventDate +"</td>";
					events += "<td>"+ dataObj[i].eventStartTime +"</td>";
					events += "<td>"+ dataObj[i].eventEndTime +"</td>";
					events += "<td>"+ dataObj[i].noOfGuests +"</td>";
					events += "<td>"+ dataObj[i].entryDate +"</td>";
					events += "<tr>";
				}

				$(".clientRecentEventList").html(events);
			}
		);
	});
</script>
<?php require_once("footer.php"); ?>