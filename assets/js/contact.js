
function getAllServices(){
	$.post(
		"../controller/getAllServices.php",
		function(data){
			displayServices_options(data);
		}
	);
}

function displayServices_options(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var services = "<option></option>";

	for(var i=0; i<dataLen; i++){
		services += "<option value='"+ dataObj[i].service +"'>"+ dataObj[i].service +"</option>";
	}

	$(".inqEvent").html(services);
}

function getAllVenues(){
	$.post(
		"../controller/getAllVenues.php",
		function(data){
			displayVenues(data);
		}
	);
}

function displayVenues(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var venues = "<option></option>";

	for(var i=0; i<dataLen; i++){
		venues += "<option value='"+ dataObj[i].venue +"' id="+ dataObj[i].id +">"+ dataObj[i].venue +"</option>";
	}

	$(".inqVenue").html(venues);
}


$(document).ready(function(){
	getAllServices();
	getAllVenues();

	$(".loader").css("display","none");
    $(".loader").fadeOut("slow");
});

function getFormData(){

	var inqEmail = $(".inqEmail").val();
	if (inqEmail == ""){
		alert("Email is required");
		return false;
	}else{
		if (validateEmail(inqEmail) == false){
			alert("Invalid Email");
			return false;
		}
	}

	var inqName = $(".inqName").val()
	if (inqName == ""){
		alert("Fullname is required");
		return false;
	}else{
		
		if (allLetter(inqName) === false){
			alert("Invalid fullname");
			return false;
		}
		
		var nameLen = inqName.length;
		
		if (nameLen < 4){
			alert("Invalid fullname");
			return false;
		}
		
	}

	var inqContactNum = $(".inqContactNum").val()
	if (inqContactNum == ""){
		alert("Contact Number is required");
		return false;
	}else{
		if (mobileNum(inqContactNum) === false){
			alert("Invalid Contact No");
			return false;
		}
	}

	var inqEvent = $(".inqEvent").val()
	if (inqEvent == ""){
		alert("Type of Event is required");
		return false;
	}

	var inqVenue = $(".inqVenue").val()
	if (inqVenue == ""){
		alert("Type of Venue is required");
		return false;
	}
	
	var venueID = $(".inqVenue").children(":selected").attr("id");
	
	var outsideVenueAddress = $(".outsideVenueAddress").val();
	if (outsideVenueAddress == ""){
		outsideVenueAddress = "none";
	}
	
	var noOfGuest = $(".inqnoOfGuest").val();
	if (noOfGuest == ""){
		alert("No of guests is required");
		return false;
	}else{
		if (allNumeric(noOfGuest) === false){
			alert("invalid no of guests");
			return false;
		}
	}

	var inqInquiry = $(".inqInquiry").val()
	if (inqInquiry == ""){
		alert("Inquiry is required");
		return false;
	}

	var data = {
		"emailAdd" : inqEmail,
		"inqName" : inqName,
		"contactNo" : inqContactNum,
		"typeOfEvent" : inqEvent,
		"typeOfVenue" : inqVenue,
		"venueID" : venueID,
		"venueAddress" : outsideVenueAddress,
		"noOfGuest" : noOfGuest,
		"inquiry" : inqInquiry
	};

	return data;
}

$(".typeOfVenue").on("change", function(){
	var venueID = $(this).children(":selected").attr("id");
	
	$.post(
		"../controller/getVenueNotes.php",
		{
			"venueID" : venueID
		},
		function(data){
			console.log(data);
			var dataObj = JSON.parse(data);

			$(".venueNotes").html(dataObj.notes);

			if (dataObj.isOutside === "1"){
				$(".noOfGuestsNotes").html("Number of Guests (outside venue Minimum: 100 and Maximum: 600)");

				$(".venueAddress").css("display", "block");

			}else{
				$(".noOfGuestsNotes").html("Number of Guests (branch venue Minimum: 40 and Maximum: 180)");

				$(".venueAddress").css("display", "none");
			}


		}
	);
});

function clearInquiryInputs(){
	$(".inqEmail").val("");
	$(".inqName").val("");
	$(".inqContactNum").val("");
	$(".inqEvent").val("");
	$(".inqVenue").val("");
	$(".outsideVenueAddress").val("");
	$(".inqnoOfGuest").val("");
	$(".inqInquiry").val("");
}

$(".btnSendInquiry").on("click", function(){
	var data  = getFormData();

	if (data !== false){
		$(".loader").css("display","block");
    	$(".loader").fadeIn("slow");
		$.post(
			"../controller/sendInquiry.php",
			data,
			function(data){
				console.log(data);
				var dataObj = JSON.parse(data);
				
				if (dataObj.done === "TRUE"){
					clearInquiryInputs();
				}
				
				alert(dataObj.msg);
				
				$(".loader").css("display","none");
				$(".loader").fadeOut("slow");
			}
		);
	}
	
});