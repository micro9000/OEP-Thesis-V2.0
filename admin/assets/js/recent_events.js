function getAllServices(){
	$.post(
		"controller/getAllServices.php",
		
		function(data){
			displayServicesOptions(data);
		}
	);
}

function displayServicesOptions(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var services = "<option></option>";
	for(var i=0; i<dataLen; i++){
		services += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].service +"</option>";
	}

	$(".services").html(services);
}

$(document).ready(function(){
	getAllServices();
});


function getFormData(){
	var services = $(".services").val();
	var eventTitle = $(".eventTitle").val();
	var address = $(".address").val();
	var eventDate = $(".eventDate").val();
	var recentEventDescription = $(".recentEventDescription").val();
	var comments = $(".recentEventClientComments").val();

	var formData = new FormData();

	if (services != "" && eventTitle != "" && address != "" && eventDate != "" && recentEventDescription != ""){

		var fileLen = $(".uploadCheckList")[0].files.length;

		if (fileLen > 0){

			for(var i=0; i<fileLen; i++){
				formData.append('eventImages' + i, $(".uploadCheckList")[0].files[i]);
			}

			formData.append("eventCategory", services);
			formData.append("eventName", eventTitle);
			formData.append("eventAddress", address);
			formData.append("eventDate", eventDate);
			formData.append("eventDescription", recentEventDescription);
			formData.append("eventComments", comments);

		}else{
			alert("No image/s")
			return;
		}
	}

	return formData;
}

$(".btnAddNewEvent").on("click", function(){
	var formData = getFormData();

	var request = $.ajax({
        url: 'controller/insert_new_recent_event.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false
    });

    request.done(function(data){
    	//console.log(data);
    	var dataObj = JSON.parse(data);

    	if (dataObj['done'] == "TRUE"){

    		insertUserAction("Add new Event ( "+ $(".eventTitle").val() +" )");

    		clearInputs();
    	}
    	$(".eventsMsg").html(dataObj.msg);
    	getAllRecentEvents();
    });
});


function clearInputs(){
	$(".services").val("");
	$(".eventTitle").val("");
	$(".address").val("");
	$(".eventDate").val("");
	$(".recentEventDescription").val("");
	$(".uploadCheckList").val("");
	$(".recentEventClientComments").val("");
}

function getAllRecentEvents(){
	$.post(
		"controller/getRecentEvents_handler.php",
		{
			'task' : "all"
		},
		function(data){
			// console.log(data);
			displayRecentEvents(data);
		}
	);
}

function displayRecentEvents(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var events = "";

	for(var i=0; i<dataLen; i++){
		events += "<tr>";
		events += "<td>"+ dataObj[i].service +"</td>";
		events += "<td>"+ dataObj[i].eventName +"</td>";
		events += "<td>"+ dataObj[i].address +"</td>";
		events += "<td>"+ dataObj[i].eventDate +"</td>";
		events += "<td><a href='recent_events.php?eventID="+ dataObj[i].id +"'>select</a></td>";
		events += "</tr>";
	}

	$(".eventList").html(events);
}

function displayRecentEvents_inputs(data){
	var dataObj = JSON.parse(data);

	$(".services").val(dataObj[0].serviceID).change();
	$(".eventTitle").val(dataObj[0].eventName);
	$(".address").val(dataObj[0].address);
	$(".eventDate").val(dataObj[0].eventDate);
	$(".recentEventDescription").val(dataObj[0].description);
	$(".recentEventClientComments").val(dataObj[0].comments);
}

$(document).ready(function(){

	if (eventID != 0 && eventID > 0){
		getRecentEventsByID(eventID);
		getRecentEventsImagesByID(eventID);
	}else{
		getAllRecentEvents();
	}

})

function getRecentEventsByID(id){
	$.post(
		"controller/getRecentEvents_handler.php",
		{
			'task' : "byID",
			"eventID" : id
		},
		function(data){
			displayRecentEvents(data);
			displayRecentEvents_inputs(data);
		}
	);
}

function getRecentEventsImagesByID(id){
	$.post(
		"controller/getRecentEvents_handler.php",
		{
			'task' : "images",
			"eventID" : id
		},
		function(data){
			// console.log(data);
			displayRecentEventsImages(data, id);
		}
	);
}

function displayRecentEventsImages(data, eventID){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var images = "";

	for(var i=0; i<dataLen; i++){
		images += "<div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>";
		images += "<a href='recent_events_image.php?eventID="+ eventID +"&imageID="+ dataObj[i].id +"' target='_blank' class='d-block mb-4 h-100'>";
		images += "<img class='img-fluid img-thumbnail' src='../uploads/Events/"+ dataObj[i].serverName +"' alt=''>";
		images += "</a>";
		images += "</div>";
	}

	$(".eventImages").html(images);
}

function getFormData_update(){
	var services = $(".services").val();
	var eventTitle = $(".eventTitle").val();
	var address = $(".address").val();
	var eventDate = $(".eventDate").val();
	var recentEventDescription = $(".recentEventDescription").val();
	var comments = $(".recentEventClientComments").val();

	var formData = new FormData();

	if (services != "" && eventTitle != "" && address != "" && eventDate != "" && recentEventDescription != ""){

		var fileLen = $(".uploadCheckList")[0].files.length;

		for(var i=0; i<fileLen; i++){
			formData.append('eventImages' + i, $(".uploadCheckList")[0].files[i]);
		}

		formData.append("eventCategory", services);
		formData.append("eventName", eventTitle);
		formData.append("eventAddress", address);
		formData.append("eventDate", eventDate);
		formData.append("eventDescription", recentEventDescription);
		formData.append("eventComments", comments);
	}

	return formData;
}

$(".btnUpdateEvent").on("click", function(){

	if (eventID != 0 && eventID > 0){

		var formData = getFormData_update();

		formData.append("eventID" , eventID);

		var request = $.ajax({
	        url: 'controller/update_recent_event.php',
	        type: "POST",
	        data: formData,
	        contentType: false,
	        cache: false,
	        processData: false
	    });

	    request.done(function(data){
	    	// console.log(data);
	    	var dataObj = JSON.parse(data);

	    	if (dataObj['done'] == "TRUE"){

	    		insertUserAction("Update Event ( "+ $(".eventTitle").val() +" )");

	    		clearInputs();
	    	}
	    	$(".eventsMsg").html(dataObj.msg);
	    	getRecentEventsImagesByID(eventID);
	    });
	}

});

$(".btnDeleteEvent").on("click", function(){

	if (eventID != 0 && eventID > 0){
		var r = confirm("Are you sure you want to delete this event?");

		if(r == true){
			$.post(
				"controller/delete_recent_event.php",
				{
					"eventID" : eventID
				},
				function(data){
					// console.log(data);
					if (data == "TRUE"){

						insertUserAction("Delete Event ( "+ $(".eventTitle").val() +" )");

						alert("Deleted");
						window.location = "recent_events.php";
					}
				}
			);
		}
	}
});