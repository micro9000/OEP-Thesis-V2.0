
function getAllServicesNavbarBtns(){
	$.post(
		"../controller/getAllServices.php",
		function(data){
			displayServices_navbarbuttons(data);
		}
	);
}

function displayServices_navbarbuttons(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var services = "<a href='#' class='btn btn-warning btnServiceTab' id='0'>ALL</a>";

	for(var i=0; i<dataLen; i++){
		services += "<a href='#' class='btn btn-warning btnServiceTab' id='"+ dataObj[i].id +"'>"+ dataObj[i].service +"</a>";
	}

	$(".eventNavButton").html(services);
}


$(document).ready(function(){

	if (typeof eventID != "undefined" && eventID > 0 && eventID != 0){
		getEventImages(eventID);
	}else{
		getNRecentEvents();
		getAllServicesNavbarBtns();
	}
});

function getNRecentEvents(){
	$.post(
		"../controller/getLastNRecentEvents.php",
		{},
		function(data){
			displayRecentEvents(data);
		}
	);
}

function getAllRecentEvents(){
	$.post(
		"../controller/getLastNRecentEvents.php",
		{
			"isLimited" : 0 // means false
		},
		function(data){
			displayRecentEvents(data);
		}
	);
}

function displayRecentEvents(data){
	var dataObj = JSON.parse(data);
	// console.log(dataObj);
	var dataLen = dataObj.length;

	var portfolio = "";

	for(var i=0; i < dataLen; i++){

		var eventID = dataObj[i]['eventID'];
		var eventDate = dataObj[i]['eventDate'];
		var service = dataObj[i]['service'];
		var imageData = dataObj[i]['imageData'];

		portfolio += "<div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>";
			portfolio += "<div class='thumbnail'>";
				portfolio += "<a href='recent_event_info.php?eventID="+ eventID +"' class='d-block mb-4 h-100'>";
					portfolio += "<img class='img-fluid img-thumbnail' src='../uploads/Events/"+ imageData.serverName +"' alt='No Image'>"
					portfolio += "<div class='caption'>";
						portfolio += "<p>"+ service +" | "+ eventDate +"</p>";
					portfolio += "</div>";
				portfolio += "</a>";
			portfolio += "</div>";
		portfolio += "</div>";
	}

	$(".eventImages").html(portfolio);
}

function getEventImages(eventID){
	$.post(
		"../controller/getEventInfoNImages.php",
		{
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			displayEventImages(data);
		}
	);
}

function displayEventImages(data){
	var dataObj = JSON.parse(data);

	var imagesObj = dataObj['images'];
	var imgLen = imagesObj.length;

	if (imgLen > 0){
		var images = "";

		for(var i=0; i < imgLen; i++){
			images += "<img class='mySlides' src='../uploads/Events/"+ imagesObj[i].serverName +"' style='width:100%'>";
		}
		$(".eventImages_info").html(images);

		$("#eventName").html(dataObj['info'][0].eventName);
		$("#address").html(dataObj['info'][0].address);
		$("#eventDate").html(dataObj['info'][0].eventDate);
		$("#service").html(dataObj['info'][0].service);
		$("#description").html(dataObj['info'][0].description);
		$("#clientComments").html(dataObj['info'][0].comments);

	}
			
}


$(document).on("click", ".btnServiceTab", function(){

	var serviceID = $(this).attr('id');

	if (serviceID > 0){
		getEventByService(serviceID);
	}else{
		getAllRecentEvents();
	}
	
});

function getEventByService(serviceID){
	$.post(
		"../controller/getRecentEventByService.php",
		{
			"serviceID" : serviceID
		},
		function(data){
			//console.log(data);
			displayRecentEvents(data);
		}
	);
}
