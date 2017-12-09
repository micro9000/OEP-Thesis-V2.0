var noOfGuests = 0;
var eventID_global = 0;
var eventStatus = ["", "New Event", "Approved", "On-going preparation", "Event On-going", "DONE", "CANCELLED"];

function getClientCurrentEvent(){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "currentEvent"
		},
		function(data){
			 // console.log(data);
			displayCurrentEvent(data);
		}
	);
}

function displayCurrentEvent(data){
	
	console.log(data);

	if (data === "[]"){
		
	}else{

		var dataObj = JSON.parse(data);

		$("#eventStatus__").html(eventStatus[dataObj[0].eventStatus]);

		// Global Event ID
		eventID_global = dataObj[0].id;

		$("#typeOfEvent").html(dataObj[0].service);
		$("#eventMotif").html(dataObj[0].motif);
		$("#typeOfVenue").html(dataObj[0].venue);
		$("#venueAddress").html(dataObj[0].venueAddress);
		$("#budgetRange").html(dataObj[0].budgetRange);
		$("#eventDate").html(dataObj[0].eventDate);
		$("#startTime").html(dataObj[0].eventStartTime);
		$("#endTime").html(dataObj[0].eventEndTime);
		$("#noOfGuests").html(dataObj[0].noOfGuests);

		noOfGuests = parseInt(dataObj[0].noOfGuests);

		getEventMaterialsImgs(dataObj[0].id);
		getEventFoodsNEntertainmentImgs(dataObj[0].id);
		getEventSelectedMenu(dataObj[0].id);

		setTimeout(function(){
			
			var menuSetTitle = $("#setTitle").html();

			if (noOfGuests !== "" && ! isNaN(noOfGuests) &&
				menuSetTitle !== ""){

				var setTitle = menuSetTitle.split("@");
				var setPrice = setTitle[1];

				var totalMenu = noOfGuests * setPrice;

				var totalMenuTemp = (totalMenu > 0) ? totalMenu : 0;
				$("#menuFeeTotal").html(totalMenu);

			}

		}, 1000);

		
		setTimeout(function(){

			// Additional fee
			$.post(
				"../controller/getTimeDiff.php",
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

					$("#addionalHrFee").html(dateDiffTotalFee);
				}
			);


			setTimeout(function(){
				var dateDiffTotalFee = $("#addionalHrFee").html();
				var reservationFee = $("#reservationFee").html();
				var materialsTotal = $("#materialsTotal").html();
				var foodsEnterTotal = $("#foodsEnterTotal").html();
				var menuFeeTotal = $("#menuFeeTotal").html();

				var totalEventExpenses = parseFloat(reservationFee) + parseFloat(materialsTotal) + parseFloat(foodsEnterTotal) + parseFloat(menuFeeTotal);

				if (dateDiffTotalFee != "" || parseFloat(dateDiffTotalFee) > 0){
					totalEventExpenses = parseFloat(totalEventExpenses) + parseFloat(dateDiffTotalFee);
				}
	
				$("#totalComputation").html(totalEventExpenses);

				getPaymentMethod(totalEventExpenses, dataObj[0].id);
			}, 100);

				

		}, 3000);
	}
}

function cancelEventBtn(eventID){
	$(".cancelEvent").html("<input type='submit' id='"+ eventID +"' class='btn btn-warning btnCancelEvent' value='CANCEL THE EVENT'>");
}

$(document).on("click", ".btnCancelEvent", function(){
	var eventIDTemp = $(this).attr("id");
	
	var r = confirm("Are you sure?");

	if (r === true){
		$.post(
			"../controller/cancelEvent.php",
			{
				"eventID" : eventIDTemp
			},
			function(data){
				if (data === "TRUE"){
					window.location = "clientDashboard.php";
				}
			}
		);
	}
		

});

function loadPayPalPayment(amount, eventID){
	paypal.Button.render({

        env: 'sandbox', // Or '' 'production'

        client: {
            sandbox:    'AeLirqNhoOutqWrxEwvKNVzQAqm4fT1dhUXJNW_mUq1hOepp1vUcZMBY_iz1pqlO-8UDIpv-tiBIbTT-',
            production: 'AedEbhm1xtBeyK0Fb8GcFgRKi2lcKMZK2SQkpBTNt33DuhKGnitp8wi3ZlF3XFLqm-JTaprY4ViHnggZ'
        },

        commit: true, // Show a 'Pay Now' button

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: amount, currency: 'USD' }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {

                if (payment.state === "approved"){
                	insertPaymentMethod(eventID, 2);
                	insertPayment(eventID, amount);
                }
                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        }

    }, '#paypal-button');
}

$(document).on("click", ".btnCashOnPersonalMeeting", function(){

	var eventID = $(this).attr("id");

	if (eventID > 0 && typeof eventID !== "undefined") {

		var r = confirm("Continue?");

		if (r === true){
			insertPaymentMethod(eventID, 1);
		}
		
	}
})

function insertPaymentMethod(eventID, method){
	$.post(
		"../controller/insertPaymentMethod.php",
		{
			"eventID" : eventID,
			"method" : method
		},
		function(data){
			if (data === "TRUE"){
				window.location = "clientEventStatus.php";
			}
		}
	);
}

function insertPayment(eventID, amount){
	$.post(
		"../controller/insertPayment.php",
		{
			"eventID" : eventID,
			"amount" : amount
		},
		function(data){
			if (data === "TRUE"){
				alert("Paid");
				window.location = "clientEventStatus.php";
			}
		}
	);
}

function getPaymentMethod(total, eventID){
	
	$.post(
		"../controller/getPaymentMethod.php",
		{
			"eventID" : eventID
		},
		function(data){

			var paymentMethod = data;

			$.post(
				"../controller/getPaymentLogs.php",
				{
					"eventID" : eventID
				},
				function(data2){

					var paymentLogs = data2;
					var totalDownOrPayment = 0;

					if (paymentLogs !== "0"){
						var paymentObj = JSON.parse(paymentLogs);

						var paymentLen = paymentObj.length;

						if (typeof paymentObj === "object"){
							for(var i=0; i<paymentLen; i++){
								totalDownOrPayment += parseFloat(paymentObj[i].amount);
							}
						}
					}

					var getBalance = 0;
					$("#downOrFullPaymentTotal").html(totalDownOrPayment);

					var totalEventExpenses = parseFloat($("#totalComputation").html());

					if (paymentMethod === "1"){
						if (paymentLogs === "0"){
							loadPayPalPayment(total, eventID);
							cancelEventBtn(eventID);
						}else{

							if (totalDownOrPayment > 0){
								if (parseFloat(totalDownOrPayment) === parseFloat(totalEventExpenses)){
									$("#ifPaid").html("<h3>Paid</h3>");
								}else{
									if (totalDownOrPayment < totalEventExpenses){
										getBalance = totalEventExpenses - totalDownOrPayment;
									}
								}
							}
						}
					}else if (paymentMethod === "2"){

						$(".paymentBtns").html("<h3>Paid</h3>");

					}else{

						loadPayPalPayment(total, eventID);
						cancelEventBtn(eventID);
						$("#cashOnPersonalMeeting").html("<input type='submit' id='"+ eventID +"' value='Cash on a personal meeting' class='btn btn-warning btnCashOnPersonalMeeting'>");
					
					}

					$("#totalBalance").html(getBalance);
				}

			);

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
		imgs += "<img style='max-width: 150px; max-height: 150px; width: 150px; height: 150px;' class='img-fluid img-thumbnail' src='../uploads/Materials/"+ dataObj[i].serverName +"' alt=''>";
		imgs += "<div class='captionV2'>";
		imgs += "Reference # : " + dataObj[i].referenceNo + "<br/>";
		imgs += "Motif : " + dataObj[i].theme + "<br/>";
		imgs += "Material: " + dataObj[i].material + "<br/>";
		imgs += "Price: &#8369;" + dataObj[i].price + "<br/>";
		imgs += "<input type='submit' id='"+ dataObj[i].id +"' class='btnRemoveMaterial' value='Remove'/><br/>";
		imgs += "</div>";
		imgs += "</div>";

		total += parseFloat(dataObj[i].price);
	}

	$(".totalMaterials").html("Materials Total: &#8369;"+ total +"");
	$("#materialsTotal").html(total);
	$(".eventMaterialList").html(imgs);
}

$(document).on("click", ".btnRemoveMaterial", function(){
	var materialIDTemp = $(this).attr("id");

	var r = confirm("Continue?");

	if (r == true){
		$.post(
			"../controller/deleteEventMaterial.php",
			{
				"materialID" : materialIDTemp
			},
			function(data){
				getClientCurrentEvent();
				// if (data == "TRUE"){
				// 	alert("Deleted");
				// }
			}
		);
	}
})

function getEventMaterialsImgs(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "eventMaterialsImgs",
			"eventID" : eventID
		},
		function(data){
			displayMaterials(data);
		}
	);
}

function getEventFoodsNEntertainmentImgs(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "eventFoodsEntertainmentImgs",
			"eventID" : eventID
		},
		function(data){
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
		imgs += "<img style='max-width: 150px; max-height: 150px; width: 150px; height: 150px;' class='img-fluid img-thumbnail' src='../uploads/PartnersMotif/"+ dataObj[i].serverName +"' alt=''>";
		imgs += "<div class='captionV2'>";
		imgs += "Reference # : " + dataObj[i].imageRefNo + "<br/>";
		imgs += "Motif : " + dataObj[i].theme + "<br/>";
		imgs += "Product Category: " + dataObj[i].prodCat + "<br/>";
		imgs += "Price &#8369;" + dataObj[i].price + "<br/>";
		imgs += "<input type='submit' id='"+ dataObj[i].id +"' class='btnRemoveFoodsOrEntertainment' value='Remove'/><br/>";
		imgs += "</div>";
		imgs += "</div>";

		total += parseFloat(dataObj[i].price);
	}

	$(".totalFoodsEnter").html("Foods & Entertainments Total:  &#8369;" + total);
	$("#foodsEnterTotal").html(total);
	$(".eventFoodsEnterList").html(imgs);
}

$(document).on("click", ".btnRemoveFoodsOrEntertainment", function(){
	var foodsEntertainment = $(this).attr("id");

	var r = confirm("Continue?");

	if (r == true){
		$.post(
			"../controller/deleteEventFoodsEntertainment.php",
			{
				"foodsEnterID" : foodsEntertainment
			},
			function(data){
				// console.log(data);
				getClientCurrentEvent();
				// if (data == "TRUE"){
				// 	alert("Deleted");
				// }
			}
		);
	}
})

function getEventSelectedMenu(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "eventSelectedMenu",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			displayEventMenu(data);
		}
	);
}



function displayEventMenu(data){
	var dataObj = JSON.parse(data);

	$("#setTitle").html(dataObj[0].setTitle +"@"+ dataObj[0].setPrice);
	$("#menu_soup").html(dataObj[0].soup);
	$("#menu_chicken").html(dataObj[0].chicken);
	$("#menu_seafoods").html(dataObj[0].seafoods);
	$("#menu_porkBeef").html(dataObj[0].porkBeef);
	$("#menu_vegetable").html(dataObj[0].vegetable);
	$("#menu_rice").html(dataObj[0].rice);
	$("#menu_salad").html(dataObj[0].salad);
	$("#menu_dessert").html(dataObj[0].dessert);
	$("#menu_drinks").html(dataObj[0].drinks);

}

$(document).ready(function(){
	getClientCurrentEvent();
})

$(".btnUpdateEventDetails").on("click", function(){
	if (eventID_global > 0 && eventID_global != 0){
		window.location = "clientDashboard.php?eventID="+ eventID_global +"&task=update-event-details";
	}
})

$(".btnUpdateEventMaterials").on("click", function(){
	if (eventID_global > 0 && eventID_global != 0){
		window.location = "clientDashboard.php?eventID="+ eventID_global +"&task=update-event-material";
	}
})

$(".btnUpdateEventFoodsEntertainment").on("click", function(){
	if (eventID_global > 0 && eventID_global != 0){
		window.location = "clientDashboard.php?eventID="+ eventID_global +"&task=update-event-foods-entertainment";
	}
})

$(".btnUpdateEventMenu").on("click", function(){
	if (eventID_global > 0 && eventID_global != 0){
		window.location = "clientDashboard.php?eventID="+ eventID_global +"&task=update-event-menu";
	}
})