
var eventStatus = ["", "New Event", "Approved", "On-going preparation", "Event On-going", "DONE"];

function getAllNewEvents(){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "byStatus",
			"status" : "1"
		},
		function(data){
			console.log(data);
			displayEvents(data);
		}
	);
}

$(".filterEventSelect").on("change", function(){
	var status = $(this).val();

	if (parseInt(status) < 6){

		$.post(
			"controller/getEvents_handler.php",
			{
				"task" : "byStatus",
				"status" : status
			},
			function(data){
				displayEvents(data);
			}
		);

	}else if (parseInt(status) === 6){
		$.post(
			"controller/getEvents_handler.php",
			{
				"task" : "deletedEvents"
			},
			function(data){
				displayEvents(data);
			}
		);
	}
		
});

function displayEvents(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var events = "";

	for(var i=0; i<dataLen; i++){
		events += "<tr>";
		events += "<td>"+ dataObj[i].service +"</td>";
		events += "<td>"+ dataObj[i].motif +"</td>";
		events += "<td>"+ dataObj[i].venue +"</td>";
		events += "<td>"+ dataObj[i].venueAddress +"</td>";
		events += "<td>"+ dataObj[i].eventDate +"</td>";
		events += "<td>"+ dataObj[i].eventStartTime +"</td>";
		events += "<td>"+ dataObj[i].eventEndTime +"</td>";
		events += "<td>"+ dataObj[i].noOfGuests +"</td>";
		events += "<td>"+ dataObj[i].entryDate +"</td>";
		events += "<td>"+ eventStatus[dataObj[i].eventStatus] +"</td>";
		events += "<td><a href='eventDetails.php?eventID="+ dataObj[i].id +"' target='_blank'>select</a></td>";
		events += "</tr>";
	}

	$(".newEventsList").html(events);
}

$(document).ready(function(){
	getAllNewEvents();
});