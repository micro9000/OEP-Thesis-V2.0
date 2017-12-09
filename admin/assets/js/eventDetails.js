var noOfGuests = 0;

function getClientInfo(clientID){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "clientInfo",
			"clientID" : clientID
		},
		function(data){
			displayClientInfo(data);
		}
	);
}

function displayClientInfo(data){
	var dataObj = JSON.parse(data);

	$("#client_fullname").html(dataObj[0].fullName);
	$("#client_email").html(dataObj[0].email);
	$("#client_contactNo").html(dataObj[0].contactNo);
	$("#client_dateReg").html(dataObj[0].dateReg);

}

var eventStatus = ["", "New Event", "Approved", "On-going preparation", "Event On-going", "DONE"];

function displayEvents(data, isOne){
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
		events += "</tr>";

		getClientInfo(dataObj[i].clientInfoID);

		noOfGuests = parseFloat(dataObj[i].noOfGuests);
	}

	if (isOne === true){
		
		$.post(
			"controller/getTimeDiff.php",
			{
				"start" : dataObj[0].eventStartTime,
				"end" : dataObj[0].eventEndTime
			},
			function(data){
				
				var dateCount = parseInt(data);
				var dateDiff = 0;

				if (dateCount > 3){
					dateDiff = dateCount - 3;
				}

				var dateDiffTotalFee = 0;
				for(var i=0; i<parseInt(dateDiff); i++){
					dateDiffTotalFee = parseFloat(dateDiffTotalFee) + 500;
				}

				$("#additionalHrFee").html(dateDiffTotalFee);
			}
		);

	}

	$(".newEventsList").html(events);
}

function getEventByID(eventID){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "byID",
			"eventID" : eventID
		},
		function(data){
			displayEvents(data, true);
		}
	);
}


function getEventMaterialsImgs(eventID){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "eventMaterialsImgs",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			displayMaterials(data);
		}
	);
}

function displayMaterials(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var imgs = "";
	var total = 0;

	for(var i=0; i<dataLen; i++){
		imgs += "<div class='col-lg-2 col-md-3 col-sm-4 col-xs-6'>";
		imgs += "<a href='#' class='d-block mb-4 h-100'>";
		imgs += "<img style='max-width: 150px; max-height: 150px; width: 150px; height: 150px;' class='img-fluid img-thumbnail' src='../uploads/Materials/"+ dataObj[i].serverName +"' alt=''>";
		imgs += "<div class='caption'>";
		imgs += "Reference # : " + dataObj[i].referenceNo + "<br/>";
		imgs += "Price: " + dataObj[i].price + "<br/>";
		imgs += "Motif : " + dataObj[i].theme + "<br/>";
		imgs += "Material: " + dataObj[i].material + "<br/>";
		imgs += "</div>";
		imgs += "</a>";
		imgs += "</div>";

		total += parseFloat(dataObj[i].price);
	}

	$("#materialsTotal").html(total);
	$(".eventMaterialList").html(imgs);
}

function getEventFoodsNEntertainmentImgs(eventID){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "eventFoodsEntertainmentImgs",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			displayFoodsEntertainment(data);
		}
	);
}


function displayFoodsEntertainment(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var imgs = "";
	var total = 0;

	for(var i=0; i<dataLen; i++){
		imgs += "<div class='col-lg-2 col-md-3 col-sm-4 col-xs-6'>";
		imgs += "<a href='#' class='d-block mb-4 h-100'>";
		imgs += "<img style='max-width: 150px; max-height: 150px; width: 150px; height: 150px;' class='img-fluid img-thumbnail' src='../uploads/PartnersMotif/"+ dataObj[i].serverName +"' alt=''>";
		imgs += "<div class='caption'>";
		imgs += "Reference # : " + dataObj[i].imageRefNo + "<br/>";
		imgs += "Price: " + dataObj[i].price + "<br/>";
		imgs += "Motif : " + dataObj[i].theme + "<br/>";
		imgs += "Product Category: " + dataObj[i].prodCat + "<br/>";
		imgs += "</div>";
		imgs += "</a>";
		imgs += "</div>";

		total += parseFloat(dataObj[i].price);
	}

	$("#foodsEnterTotal").html(total);

	$(".eventFoodsEnterList").html(imgs);
}

function getEventSelectedMenu(eventID){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "eventSelectedMenu",
			"eventID" : eventID
		},
		function(data){
			displayEventMenu(data);
		}
	);
}

function displayEventMenu(data){
	var dataObj = JSON.parse(data);

	$("#menu_setTitle").html(dataObj[0].setTitle +"@"+ dataObj[0].setPrice);
	$("#menu_Soup").html(dataObj[0].soup);
	$("#menu_Chicken").html(dataObj[0].chicken);
	$("#menu_Seafoods").html(dataObj[0].seafoods);
	$("#menu_PorkBeef").html(dataObj[0].porkBeef);
	$("#menu_Vegetable").html(dataObj[0].vegetable);
	$("#menu_Rice").html(dataObj[0].rice);
	$("#menu_Salad").html(dataObj[0].salad);
	$("#menu_Dessert").html(dataObj[0].dessert);
	$("#menu_Drinks").html(dataObj[0].drinks);

}

$(document).ready(function(){
	if(eventID != 0 && eventID > 0){
		getEventByID(eventID);
		getEventMaterialsImgs(eventID);
		getEventFoodsNEntertainmentImgs(eventID);
		getEventSelectedMenu(eventID);

		setTimeout(function(){
			var menuSetTitle = $("#menu_setTitle").html();
			var menuSetTitleTemp = menuSetTitle.split("@");
			var setPrice = parseFloat(menuSetTitleTemp[1]);
			var totalMenu = parseFloat(setPrice * noOfGuests);

			$("#menuFeeTotal").html(totalMenu);

		}, 1000);

		setTimeout(function(){
			var reservationFee = $("#reservationFee").html();
			var additionalHrFee = $("#additionalHrFee").html();
			var materialsTotal = $("#materialsTotal").html();
			var foodsEnterTotal = $("#foodsEnterTotal").html();
			var menuFeeTotal = $("#menuFeeTotal").html();


			var totalEventExpenses = parseFloat(reservationFee) + parseFloat(materialsTotal) + parseFloat(foodsEnterTotal) + parseFloat(menuFeeTotal);
			
			if (additionalHrFee !== "" && parseFloat(additionalHrFee) > 0){
				totalEventExpenses = parseFloat(totalEventExpenses) + parseFloat(additionalHrFee);
			}

			$("#totalComputation").html(totalEventExpenses);


			getPaymentLog(eventID, totalEventExpenses);

		}, 3000);
	}
});

function getPaymentLog(eventID, totalEventExpenses){
	$.post(
		"controller/getEvents_handler.php",
		{
			"task" : "paymentLogs",
			"eventID" : eventID
		},
		function(data){

			var dataObj = JSON.parse(data);
			var dataLen = dataObj.length;

			var logs = "";
			var total = 0;

			for(var i=0; i<dataLen; i++){
				logs += "<tr>";
				logs += "<td>"+ dataObj[i].amount +"</td>";
				logs += "<td>"+ dataObj[i].entryDate +"</td>";
				logs += "</tr>";

				total += parseFloat(dataObj[i].amount);
			}

			var balance = 0;

			$("#downpaymentOrPaymentTotal").html(total);
			$(".paymentLogs").html(logs);

			if (parseFloat(totalEventExpenses) === parseFloat(total)){
				$(".downpaymentInputFlds").html("<h3 style='text-align:center'>Paid</h3>");
			}else{
				if (totalEventExpenses > total){
					balance = totalEventExpenses - total;
				}
			}

			if (total > 0){
				$("#balance").html(balance);
			}

			
		}
	);
}

function insertPayment(amount, eventID, method){
	$.post(
		"controller/insertPaymentAndMethod.php",
		{
			"amount" : amount,
			"eventID" : eventID,
			"method" : method	
		},
		function(data){
			if (data === "TRUE"){
				alert("Done!");
				window.location = "eventDetails.php?eventID=" + eventID;
			}
		}
	);
}

setTimeout(function(){
	$(".btnEnterDownpayment").on("click", function(){

		var totalEventExpenses = $("#totalComputation").html();
		var balance = $("#balance").html();
		var amount = $(".downpayment").val();

		if (isNaN(amount)){
			alert("Invalid Amount");
			return;
		}

		if (parseFloat(amount) > parseFloat(totalEventExpenses)){
			alert("The amount is greater than the total expenses");
			return;
		}

		if (balance !== ""){

			if (parseFloat(amount) > parseFloat(balance)){
				alert("The amount is greater than the balance");
				return;
			}

		}

		if (eventID > 0 && eventID !== 0){

			insertUserAction("Enter client payment (Client: "+ $("#client_fullname").html() +", amount: "+ amount +")");

			insertPayment(amount, eventID, 1);
		}
	})
}, 1000);
	


$(".btnChangeEventStatus").on("click", function(){
	
	$("#apprErrMsg").html("Please wait...");
	
	var status = $(this).attr("id");
	var action = $(this).val();

	if (eventID != 0 && eventID > 0){
		$.post(
			"controller/update_event_status.php",
			{
				"eventID" : eventID,
				"status" : status
			},
			function(data){
				
				console.log(data);
				var dataObj = JSON.parse(data);
				
				if(dataObj.done === "TRUE"){
					insertUserAction("Change the status of event to ("+ action +") - Event owner: " + $("#client_fullname").html());

					setTimeout(function(){
						window.location.reload();
					}, 500);
				}else{
					alert(dataObj.msg);
				}
				
				$("#apprErrMsg").html("");
			}
		)
	}
})

$(".btnCancelEvent").on("click", function(){

	var r = confirm("Are you sure?");

	if (r === true){
		if (eventID != 0 && eventID > 0){
			$.post(
				"controller/cancel_client_event.php",
				{
					"eventID" : eventID
				},
				function(data){
					if (data === "TRUE"){
						window.location = "main.php";
					}
				}
			);
		}
	}	
})

$(document).on("click", ".btnChangeToPaid", function(){
	var billID = $(this).attr("id");

	if (billID > 0){
		var r = confirm("Continue?");

		if (r === true){

			$.post(
				"controller/updateEventBillPaymentStatus.php",
				{
					"paymentMethod" : 1,
					"isPaid" : 1,
					"billID" : billID
				},
				function(data){
					if (data === "TRUE"){
						window.location.reload();
					}
				}
			);
		}
	}

})
