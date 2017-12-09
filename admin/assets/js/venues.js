
$(".btnAddNewVenue").on("click", function(){
	var venue = $(".newVenue").val();
	var notes = $(".notes").val();

	var isOutsideVenue = 0;

	if ($(".outsideVenue").prop("checked") === true){
		isOutsideVenue = 1;
	}

	if(venue !== "" && notes !== ""){
		$.post(
			"controller/insertNewVenue.php",
			{
				"venue" : venue,
				"notes" : notes,
				"isOutsideVenue" : isOutsideVenue
			},
			function(data){
				// console.log(data);
				if (data == "TRUE"){

					insertUserAction("Add new venue ("+ venue +")");

					$(".venueMsg").html("Inserted");
					$(".newVenue").val("");
					$(".notes").val("");
					$(".outsideVenue").prop("checked", false);
					
					getAllVenues();
				}
			}
		);
	}

});

$(document).ready(function(){
	getAllVenues();
});

function getAllVenues(){
	$.post(
		"controller/getAllVenues.php",
		function(data){
			// console.log(data);
			displayVenues(data);
		}
	);
}

function displayVenues(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var venues = "";

	for(var i=0; i < dataLen; i++){
		venues += "<tr>";
		venues += "<td>"+ dataObj[i].venue +"</td>";
		venues += "<td>"+ dataObj[i].notes +"</td>";

		if (dataObj[i].isOutside === "1"){
			venues += "<td>YES</td>";
		}else{
			venues += "<td>NO</td>";
		}

		venues += "<td><input type='submit' value='Delete' class='btnDeleteVenue' id='"+ dataObj[i].id +"'></td>";
		venues += "</tr>";
	}

	$(".venueList").html(venues);
}

$(document).on("click", ".btnDeleteVenue", function(){
	var venueID = $(this).attr("id");

	var r = confirm("Are you sure you want to delete this venue?");

	if (r == true){
		$.post(
			"controller/deleteVenue.php",
			{
				"venueID" : venueID
			},
			function(data){
				if (data == "TRUE"){

					insertUserAction("Delete venue");

					alert("Deleted");
					getAllVenues();
				}
			}
		)
	}

	
});