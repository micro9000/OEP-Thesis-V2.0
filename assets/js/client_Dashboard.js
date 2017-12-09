var selectedMaterialsObj = {};
var selectedPartnersProd = {};
var currentMaterialID = 0;
var currentProdCatID = 0;
var menuID = 0;

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

	var services = "<option value=''></option>";

	for(var i=0; i<dataLen; i++){
		services += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].service +"</option>";
	}

	$(".typeOfEvents").html(services);
}

$(".typeOfEvents").on("change", function(){
	var serviceID = $(this).val();

	getServiceMotifs(serviceID)
})

function getServiceMotifs(serviceID){
	$.post(
		"../controller/getServiceMotifs.php",
		{
			"serviceID" : serviceID
		},
		function(data){
                        console.log(data);
			displayServiceMotifs(data);
		}
	);
}

function displayServiceMotifs(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var motifs = "<option value=''></option>";

	for(var i=0; i<dataLen; i++){
		motifs += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].motif +"</option>";
	}

	$(".serviceMotifs").html(motifs);
}

// #######################################################################################################
// #######################################################################################################
// #######################################################################################################
// #######################################################################################################


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

	var venues = "<option value=''></option>";

	for(var i=0; i<dataLen; i++){
		venues += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].venue +"</option>";
	}

	$(".typeOfVenue").html(venues);
}

$(".typeOfVenue").on("change", function(){
	var venueID = $(this).val();

	$.post(
		"../controller/getVenueNotes.php",
		{
			"venueID" : venueID
		},
		function(data){
			// console.log(data);
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
})

function getAllBudgetRanges(){
	$.post(
		"../controller/getAllBudgetRanges.php",
		function(data){
			displayBudgetRanges(data);
		}
	);
}

function displayBudgetRanges(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var budgets = "<option value=''></option>";

	for(var i=0; i<dataLen; i++){
		budgets += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].budgetRange +"</option>";
	}

	$(".budgetRange").html(budgets);
}

// #######################################################################################################
// #######################################################################################################
// #######################################################################################################
// #######################################################################################################


function getAllMaterials(){
	$.post(
		"../controller/getAllMaterials.php",
		function(data){
			displayMaterials(data);
		}
	);
}

function displayMaterials(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var materials = "";

	for(var i=0; i<dataLen; i++){
		materials += "<tr>";
		materials += "<td>"+ dataObj[i].material +"</td>";
		materials += "<td>";
			materials += "<div class='checkbox'>";
			materials += "<label><input type='checkbox' class='chkBoxMaterial' value='"+ dataObj[i].id +"'>Check</label>";
			materials += "</div>";
		materials += "</td>";
		materials += "<td><input type='submit' value='change' id='"+ dataObj[i].id +"' class='btn btnChangeMaterialSelectedImgs'></td>";
		materials += "</tr>";
	}

	$(".materialsTbList").html(materials);
}

// ################################################### Current material ID
$(document).on("click", ".chkBoxMaterial", function(){

	$(".motifImages").html("");

	currentMaterialID = $(this).val();

	if ($(this).prop('checked')){
		// var materialID = $(this).val();

		getMaterialMotifs(currentMaterialID);
	}else{
		delete selectedMaterialsObj[currentMaterialID];
		// console.log(selectedMaterialsObj[currentMaterialID]);
	}

});

function getMaterialMotifs(materialID){
	$.post(
		"../controller/getMaterialMotifs.php",
		{
			"materialID" : materialID
		},
		function(data){
			displayMaterialMotifs(data);
		}
	);
}

function displayMaterialMotifs(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var motifs = "<option></option>";

	for(var i=0; i<dataLen; i++){
		motifs += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].theme +"</option>";
	}

	$(".materialMotifs").html(motifs);
}

$(".materialMotifs").on("change", function(){
	var motifID = $(this).val();

	getMaterialMotifImages(motifID);
});

function getMaterialMotifImages(motifID){
	$.post(
		"../controller/getMaterialMotifImages.php",
		{
			"motifID" : motifID
		},
		function(data){
			displayMaterialMotifImages(data);
		}
	);
}

function displayMaterialMotifImages(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var images = "";

	for(var i=0; i<dataLen; i++){
		images += "<div class='col-md-6'>";
			images += "<label class='btn'>";
				images += "<img style='min-height: 200px; min-width: 200px; height: 200px; width: 200px;' src='../uploads/Materials/"+ dataObj[i].serverName +"' alt='...' class='img-thumbnail img-check'>";
				images += "<input type='checkbox' id='"+ dataObj[i].id +"' value='"+ dataObj[i].id +"' class='materialMotifImg' autocomplete='off'>";
				images += "<p>"+ dataObj[i].price +"</p>";
			images += "</label>";
		images += "</div>";
	}

	$(".motifImages").html(images);

	// $(".materialMotifImg").prop('checked', true);
}

$(".btnAddMaterialToList").on("click", function(){ // ################## Btn add material imags ids

	// console.log(currentMaterialID);

	var materialImgs = $(".materialMotifImg");
	var imgsLen = materialImgs.length;

	var materialMotifsImgIds = [];

	for(var i=0; i<imgsLen; i++){

		if ($(materialImgs[i]).prop('checked')){
			var id = $(materialImgs[i]).attr("id");

			materialMotifsImgIds.push(id);
		}
	}
	// ##################################################################################################################
	// ##################################################################################################################
	// ##################################################################################################################
	// ##################################################################################################################
	// ##################################################################################################################
	selectedMaterialsObj[currentMaterialID] = materialMotifsImgIds;

	// console.log(materials);
	// console.log(materialMotifsImgIds);

	$(".motifImages").html("");
});

$(document).on("click", ".btnChangeMaterialSelectedImgs", function(){
	var materialID = $(this).attr("id");

	// console.log(typeof selectedMaterialsObj[materialID]);

	if (typeof selectedMaterialsObj[materialID] == "object"){
		getMaterialMotifs(materialID);
		$(".motifImages").html("Please select motif again");
	}
});

// #######################################################################################################
// #######################################################################################################
// #######################################################################################################
// #######################################################################################################

function getAllProductCategories(){
	$.post(
		"../controller/getAllProductCategories.php",
		function(data){
			displayProductCategories(data);
		}
	);
}

function displayProductCategories(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var categories = "";

	for(var i=0; i<dataLen; i++){
		categories += "<tr>";
		categories += "<td>"+ dataObj[i].prodCat +"</td>";
		categories += "<td>";
			categories += "<div class='checkbox'>";
			categories += "<label><input type='checkbox' class='chkBoxProdCat' value='"+ dataObj[i].id +"'>Check</label>";
			categories += "</div>";
		categories += "</td>";
		categories += "<td><input type='submit' value='change' id='"+ dataObj[i].id +"' class='btn btnChangePartnersProdSelectedImgs'></td>";
		categories += "</tr>";
	}

	$(".partnersProduct").html(categories);
}


$(document).on("click", ".chkBoxProdCat", function(){

	currentProdCatID = $(this).val();

	if ($(this).prop('checked')){
		// var prodCatID = $(this).val();
		// console.log(prodCatID);
		getPartnersMotifsByProdCat(currentProdCatID);

	}else{
		delete selectedPartnersProd[currentProdCatID];
	}

	// else{
	// 	$(".partnersMotifs").html("");
	// 	$(".partnerMotifImages").html("");
	// }

});

function getPartnersMotifsByProdCat(prodCatID){
	$.post(
		"../controller/getPartnersMotifsByProdCat.php",
		{
			"prodCatID" : prodCatID
		},
		function(data){
			// console.log(data);
			displayPartnersMotifs(data);
		}
	);
}

function displayPartnersMotifs(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var motifs = "<option></option>";

	for(var i=0; i<dataLen; i++){
		motifs += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].theme +"( "+ dataObj[i].partnerName +" )</option>";
	}

	$(".partnersMotifs").html(motifs);
}

$(".partnersMotifs").on("change", function(){
	var motifID = $(this).val();

	getParnterMotifsImages(motifID);
});

function getParnterMotifsImages(motifID){
	$.post(
		"../controller/getPartnersMotifsImages.php",
		{
			"motifID" : motifID
		},
		function(data){
			displayParnterMotifsImages(data);
		}
	);
}

function displayParnterMotifsImages(data){
	// console.log(data);

	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var images = "";

	for(var i=0; i<dataLen; i++){
		images += "<div class='col-md-6'>";
			images += "<label class='btn'>";
				images += "<img style='min-height: 200px; min-width: 200px; height: 200px; width: 200px;' src='../uploads/PartnersMotif/"+ dataObj[i].serverName +"' alt='...' class='img-thumbnail img-check'>";
				images += "<input type='checkbox' id='"+ dataObj[i].id +"' value='"+ dataObj[i].id +"' class='partnerMotifImg' autocomplete='off'>";
				images += "<p>"+ dataObj[i].price +"</p>";
			images += "</label>";
		images += "</div>";
	}

	$(".partnerMotifImages").html(images);
}

$(".btnAddPartnersMotifImgs").on("click", function(){

	var partnerImgs = $(".partnerMotifImg");
	var imgsLen = partnerImgs.length;

	var partnerMotifsImgIds = [];

	for(var i=0; i<imgsLen; i++){

		if ($(partnerImgs[i]).prop('checked')){
			var id = $(partnerImgs[i]).attr("id");

			partnerMotifsImgIds.push(id);
		}
	}

	selectedPartnersProd[currentProdCatID] = partnerMotifsImgIds;

	$(".partnerMotifImages").html("");

	// console.log(selectedPartnersProd[currentProdCatID]);

});

$(document).on("click", ".btnChangePartnersProdSelectedImgs", function(){
	var prodCatID = $(this).attr("id");

	// console.log(typeof selectedPartnersProd[prodCatID]);

	if (typeof selectedPartnersProd[prodCatID] == "object"){
		getPartnersMotifsByProdCat(prodCatID);
		$(".partnerMotifImages").html("Please select motif again");
	}

});

// #######################################################################################################
// #######################################################################################################
// #######################################################################################################
// #######################################################################################################

function getAllMenus(){
	$.post(
		"../controller/getAllMenus.php",
		function(data){
			displayAllMenus(data);
		}
	);
}

function displayAllMenus(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var menus = "";

	for(var i=0; i<dataLen; i++){
		menus += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
			menus += "<table class='table table-bordered menuSetTb'>";
				menus += "<thead>";
					menus += "<tr>";
						menus += "<th colspan='2' style='text-align:center'>";
							menus += dataObj[i].setTitle + " @ " + dataObj[i].setPrice;
						menus += "</th>";
					menus += "</tr>";
				menus += "</thead>";
				menus += "<tbody>";

					// Soup
					menus += "<tr>";
						menus += "<td>Soup</td>";
						menus += "<td>"+ dataObj[i].soup +"</td>";
					menus += "</tr>";

					// Chicken
					menus += "<tr>";
						menus += "<td>Chicken</td>";
						menus += "<td>"+ dataObj[i].chicken +"</td>";
					menus += "</tr>";

					// Seafoods
					menus += "<tr>";
						menus += "<td>Seafoods</td>";
						menus += "<td>"+ dataObj[i].seafoods +"</td>";
					menus += "</tr>";

					// Pork/Beef
					menus += "<tr>";
						menus += "<td>Pork/Beef</td>";
						menus += "<td>"+ dataObj[i].porkBeef +"</td>";
					menus += "</tr>";

					// Vegetable
					menus += "<tr>";
						menus += "<td>Vegetable</td>";
						menus += "<td>"+ dataObj[i].vegetable +"</td>";
					menus += "</tr>";

					// Rice
					menus += "<tr>";
						menus += "<td>Rice</td>";
						menus += "<td>"+ dataObj[i].rice +"</td>";
					menus += "</tr>";

					// Salad
					menus += "<tr>";
						menus += "<td>Salad</td>";
						menus += "<td>"+ dataObj[i].salad +"</td>";
					menus += "</tr>";

					// Dessert
					menus += "<tr>";
						menus += "<td>Dessert</td>";
						menus += "<td>"+ dataObj[i].dessert +"</td>";
					menus += "</tr>";

					// Drinks
					menus += "<tr>";
						menus += "<td>Drinks</td>";
						menus += "<td>"+ dataObj[i].drinks +"</td>";
					menus += "</tr>";

					// Buttons
					menus += "<tr>";
						menus += "<td colspan='2' style='text-align:center'>";
							menus += "<input type='submit' id='"+ dataObj[i].id +"' value='SELECT' class='btn btn-warning btnSelectThisSet'/>";
						menus += "</td>";
					menus += "</tr>";

				menus += "</tbody>";
			menus += "</table>";
		menus += "</div>";
	}

	$(".menusSetsTb").html(menus);
}

$(document).on("click", ".btnSelectThisSet", function(){
	menuID = $(this).attr("id");

	getMenu(menuID);
});

function getMenu(id){
	$.post(
		"../controller/getMenuByID.php",
		{
			"menuID" : id
		},
		function(data){
			// console.log(data);
			displayMenu(data);
		}
	);
}

//
// 		Displaying select menu to change the item
//

function getItemByColumn(task, column, classToDisplay, displayFunc){
	$.post(
		"../controller/getMenuItem.php",
		{
			"task" : task
		},
		function(data){
			displayFunc(data, column, classToDisplay);
		}

	);
}

function displayMenu_items(data, column, classToDisplay){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var items = "<select class='form-control'><option></option>";

	for(var i=0; i<dataLen; i++){
		items += "<option value='"+ dataObj[i][column] +"'>"+ dataObj[i][column] +"</option>";
	}

	items += "</select>";

	$("." + classToDisplay).html(items);
}

function clearChangeItems(){
	$(".changeSoup").html("");
	$(".changeChicken").html("");
	$(".changeSeafoods").html("");
	$(".changePorkBeef").html("");
	$(".changeVegetable").html("");
	$(".changeRice").html("");
	$(".changeSalad").html("");
	$(".changeDessert").html("");
	$(".changeDrinks").html("");
}

function displayMenu(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	clearChangeItems();
	// var menus = "";

	$(".setTitle").html(dataObj[0].setTitle +" @ "+ dataObj[0].setPrice);

	$(".selectedSoup").val(dataObj[0].soup);

	if (dataObj[0].soupIsChangable == "1"){
		getItemByColumn('bySoup','soup', 'changeSoup', displayMenu_items);
	}

	$(".selectedChicken").val(dataObj[0].chicken);

	if (dataObj[0].chickenIsChangable == "1"){
		getItemByColumn('byChicken','chicken', 'changeChicken', displayMenu_items);
	}


	$(".selectedSeafoods").val(dataObj[0].seafoods);

	if (dataObj[0].seafoodsIsChangable == "1"){
		getItemByColumn('bySeafoods','seafoods', 'changeSeafoods', displayMenu_items);
	}

	$(".selectedPorkBeef").val(dataObj[0].porkBeef);

	if (dataObj[0].porkBeefIsChangable == "1"){
		getItemByColumn('byPorkBeef','porkBeef', 'changePorkBeef', displayMenu_items);
	}

	$(".selectedVegetable").val(dataObj[0].vegetable);

	if (dataObj[0].vegetableIsChangable == "1"){
		getItemByColumn('byVegetable','vegetable', 'changeVegetable', displayMenu_items);
	}

	$(".selectedRice").val(dataObj[0].rice);

	if (dataObj[0].riceIsChangable == "1"){
		getItemByColumn('byRice','rice', 'changeRice', displayMenu_items);
	}

	$(".selectedSalad").val(dataObj[0].salad);

	if (dataObj[0].saladIsChangable == "1"){
		getItemByColumn('bySalad','salad', 'changeSalad', displayMenu_items);
	}

	$(".selectedDessert").val(dataObj[0].dessert);

	if (dataObj[0].dessertIsChangable == "1"){
		getItemByColumn('byDessert','dessert', 'changeDessert', displayMenu_items);
	}


	$(".selectedDrinks").val(dataObj[0].drinks);

	if (dataObj[0].drinksIsChangable == "1"){
		getItemByColumn('byDrinks','drinks', 'changeDrinks', displayMenu_items);
	}

	$(".nav-tabs .selectedMenuSet a").trigger("click");
}

//  Soup
$(document).on("change", "td.changeSoup select", function(){
	$(".selectedSoup").val($(this).val());
});

//  Chicken
$(document).on("change", "td.changeChicken select", function(){
	$(".selectedChicken").val($(this).val());
});

//  Seafoods
$(document).on("change", "td.changeSeafoods select", function(){
	$(".selectedSeafoods").val($(this).val());
});

//  Pork/Beef
$(document).on("change", "td.changePorkBeef select", function(){
	$(".selectedPorkBeef").val($(this).val());
});

//  Vegetable
$(document).on("change", "td.changeVegetable select", function(){
	$(".selectedVegetable").val($(this).val());
});

//  Rice
$(document).on("change", "td.changeRice select", function(){
	$(".selectedRice").val($(this).val());
});

//  Salad
$(document).on("change", "td.changeSalad select", function(){
	$(".selectedSalad").val($(this).val());
});

//  Dessert
$(document).on("change", "td.changeDessert select", function(){
	$(".selectedDessert").val($(this).val());
});

//  Drinks
$(document).on("change", "td.changeDrinks select", function(){
	$(".selectedDrinks").val($(this).val());
});


$(document).ready(function(){
	getAllServices();
	getAllVenues();
	getAllMaterials();
	getAllProductCategories();
	getAllMenus();
})

//
//
//
// 	Some condition here: -------
//  Like for example: checking the client selected date if
//  it is acceptable for the organizer:
// 		They can choose the date with 1 week prepartion
// 		They cannot choose the date that already selected by another client
// #############################################
//
//


$(".eventDate").on("change", function(){
	var selectedDate = $(this).val();

	checkIfSelectedDateIsValid(selectedDate);
})

function checkIfSelectedDateIsValid(selectedDate){
	$.post(
		"../controller/checkClientSelectedDate.php",
		{
			"selectedDate" : selectedDate
		},
		function(data){
			var dataObj = JSON.parse(data);

			if (dataObj.done == "TRUE"){
				$(".eventDateMsg").css("color", "white");
			}else{
				$(".eventDateMsg").css("color", "red");
			}

			$(".eventDateMsg").html(dataObj.msg);
		}
	);
}




//
//
//
// 	Displaying Monthly calendar here: -------
// #############################################
//
//

var selectedDates = [];

function getAllSelecteDates(onLoad){
	$.post(
		"../controller/getAllSelectedDates.php",
		function(data){
			var dataObj = JSON.parse(data);
			var dataLen = dataObj.length;

			for(var i=0; i<dataLen; i++){
				selectedDates.push(dataObj[i]);
				// console.log(dataObj[i]);
			}

			// setselectedDates(selectedDates);
			// console.log(selectedDates);

			if (onLoad == true){
				var date = new Date();
			    var year = date.getFullYear();
			    var monthNum = date.getMonth(); // debuging here: just add value 0-Jan 11-Dec
			    var dateNum = date.getDate();

				displayAvailableDates(year, monthNum, dateNum);
			}

		}
	);
}

function checkIfDateIsSelected(selectedDate){

	// console.log(selectedDates);

	var selectedDateLen = selectedDates.length;

	var tempDate = {};

	for(var i=0; i<selectedDateLen; i++){

		tempDate = selectedDates[i];

		// console.log(tempDate.eventDate);
		// console.log(tempDate.count);

		if (tempDate.eventDate == selectedDate){
			if (tempDate.count == "2"){
				return true;
			}
		}
	}

	return false;
}


function displayAvailableDates(year, monthNum, dateNum){


	// console.log(selectedDates.length);

	var months = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
            "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];

	var monthsDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

	var days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];


    var getFirstDay = new Date(year, monthNum, 1);
    var firstDay = getFirstDay.getDay();

    if(Number.isInteger(year / 4)){ // leap years
        //numDays = 366;
        monthsDays[1] = 29
    }

    var monthNow = months[monthNum];
    var monthsDaysNum = monthsDays[monthNum];

    var monthViewTb = "";

    $(".monthLabel").html(monthNow +" "+ year);
    monthViewTb += "<table class='monthViewTb'>";

    // Day title
    monthViewTb += "<tr>";
    for(var i=0; i < days.length; i++){
        monthViewTb += "<th>"+ days[i] +"</th>";
    }
    monthViewTb += "</tr>";

    // Start here
    var count = 0

    // Adjust the first day
    if (firstDay > 0){
        monthViewTb += "<tr>";
        for(var i=0; i < monthsDaysNum; i++){
            if (i < firstDay){
                monthViewTb += "<td></td>";

                count += 1;
            }
        }
    }

    var dayCount = 0;

    for(var i=firstDay + 1; i <= monthsDaysNum + firstDay; i++){
        dayCount = i - firstDay;

        if (i >= firstDay){

            if (Number.isInteger(count / 7)){
                monthViewTb += "</tr>";
                monthViewTb += "<tr>";
            }

            var actualDayCountStr = "";
            var actualmonthNumStr = "";

  			var dayCountStr = dayCount.toString();
  			var dayCountStrLen = dayCountStr.length;

  			var actualmonthNum = parseInt(monthNum + 1);
  			var monthNumStr = actualmonthNum.toString();
  			var monthNumStrLen = monthNumStr.length;

  			if (dayCountStrLen == 1){
  				actualDayCountStr = "0"+ dayCount;
  			}else{
  				actualDayCountStr = ""+ dayCount;
  			}

  			if (monthNumStrLen == 1){
  				actualmonthNumStr = "0" + parseInt(monthNum + 1);
  			}else{
  				actualmonthNumStr = "" + parseInt(monthNum + 1);
  			}

  			var monthDate = year +"-"+ actualmonthNumStr +"-"+ actualDayCountStr;

  			// console.log(monthDate);

            var isSelected = checkIfDateIsSelected(monthDate);

            if (dayCount == dateNum){// current Date

                if (isSelected == true){
                	monthViewTb += "<td class='dayActive selecteDate'> ";
	                monthViewTb += dayCount;
	                monthViewTb += "</td>";
	            }else{
	                monthViewTb += "<td class='dayActive'> ";
	                monthViewTb += dayCount;
	                monthViewTb += "</td>";
	            }

            }else{
	        	if (isSelected == true){
	        		monthViewTb += "<td class='selecteDate'> ";
	                monthViewTb += dayCount;
	                monthViewTb += "</td>";
	        	}else{
	        		monthViewTb += "<td> ";
	                monthViewTb += dayCount;
	                monthViewTb += "</td>";
	        	}

            }

            // console.log( monthDate +" - " + isSelected);

            count += 1;
        }
    }

    monthViewTb += "</table>";

    $(".calView").html(monthViewTb);
}

$(document).ready(function(){
	getAllSelecteDates(true);

	setInterval(function(){
		getAllSelecteDates(false);
	}, 10000);
});


var dateObj = new Date();
var year_btnPrevNext = dateObj.getFullYear();
var monthNum_btnPrevNext = dateObj.getMonth(); // debuging here: just add value 0-Jan 11-Dec
var dateNum_btnPrevNext = dateObj.getDate();

$(".btnNext").on("click", function(){

	getAllSelecteDates(false);

	monthNum_btnPrevNext += 1;

	if (monthNum_btnPrevNext > 11){
		year_btnPrevNext += 1;
		monthNum_btnPrevNext -= 12;
	}

	// console.log(year_btnPrevNext +"-"+ monthNum_btnPrevNext +"-"+ dateNum_btnPrevNext);

	displayAvailableDates(year_btnPrevNext, monthNum_btnPrevNext, dateNum_btnPrevNext);
})

$(".btnPrev").on("click", function(){

	getAllSelecteDates(false);

	monthNum_btnPrevNext -= 1;

	if (monthNum_btnPrevNext < 0){
		year_btnPrevNext -= 1;
		monthNum_btnPrevNext += 12;
	}

	// console.log(year_btnPrevNext +"-"+ monthNum_btnPrevNext +"-"+ dateNum_btnPrevNext);
	displayAvailableDates(year_btnPrevNext, monthNum_btnPrevNext, dateNum_btnPrevNext);
})

//
//
//
// 	Inputing here: -------
// #############################################
//
//

function getEventDetailsFormData(){

	var typeOfEvents = $(".typeOfEvents").val();
	var serviceMotifs = $(".serviceMotifs").val();
	var typeOfVenue =  $(".typeOfVenue").val();
	var venueAddress = ($(".outsideVenueAddress").val() !== "") ?  $(".outsideVenueAddress").val() : "";
	var eventDate = $(".eventDate").val();
	var eventEstimateStartTime = $(".eventEstimateStartTime").val();
	var eventEstimateEndTime = $(".eventEstimateEndTime").val();
	var noOfGuests = $(".noOfGuests").val();

	if (typeOfEvents == ""){
		$(".eventDetailsMsg").html("Type of Event is required");
		return false;
	}

	if (serviceMotifs == ""){
		$(".eventDetailsMsg").html("Event motif is required");
		return false;
	}

	if (typeOfVenue == ""){
		$(".eventDetailsMsg").html("Type of venue is required");
		return false;
	}

	if (eventDate == ""){
		$(".eventDetailsMsg").html("Event Date is required");
		return false;
	}

	// if (checkIfDateIsSelected(eventDate) == true){
	// 	$(".eventDetailsMsg").html("The event date is not available");
	// 	return false;
	// }

	if (eventEstimateStartTime == ""){
		$(".eventDetailsMsg").html("The event estimated starting time is required");
		return false;
	}

	if (eventEstimateEndTime == ""){
		$(".eventDetailsMsg").html("The event estimated ending time is required");
		return false;
	}

	if (noOfGuests == ""){
		$(".eventDetailsMsg").html("The number of guests is required");
		return false;
	}

	if (isNaN(noOfGuests)){
		$(".eventDetailsMsg").html("Invalid no of guests input");
		return false;
	}

	// var typeOfEvents = $(".typeOfEvents").val();
	// var serviceMotifs = $(".serviceMotifs").val();
	// var typeOfVenue =  $(".typeOfVenue").val();
	// var budgetRange = $(".budgetRange").val();
	// var eventDate = $(".eventDate").val();
	// var eventEstimateStartTime = $(".eventEstimateStartTime").val();
	// var eventEstimateEndTime = $(".eventEstimateEndTime").val();
	// var noOfGuests = $(".noOfGuests").val();

	var data = {
		"typeOfEvent" : typeOfEvents,
		"serviceMotif" : serviceMotifs,
		"typeOfVenue" : typeOfVenue,
		"venueAddress" : venueAddress,
		"eventDate" : eventDate,
		"eventEstimateStartTime" : eventEstimateStartTime,
		"eventEstimateEndTime" : eventEstimateEndTime,
		"noOfGuests" : noOfGuests
	}

	return data;
}

$(".btnGotoMaterials").on("click", function(){

	var isValid = getEventDetailsFormData();

	if (typeof isValid == "object"){
		$(".materials").trigger("click");
		$(".eventDetailsMsg").html("");
	}else{
		$(".eventDetailsMsg").append("<br/>Please complete the form");
	}

})

$(".btnGotoFoodsNEntertainment").on("click", function(){
	$(".foodsEntertainment").trigger("click");
})

$(".btnGotoMenus").on("click", function(){
	// console.log(selectedPartnersProd);
	$(".cateringMenus").trigger("click");
})

function getCateringMenuFormData(){
	var selectedSoup = $(".selectedSoup").val();
	var selectedChicken = $(".selectedChicken").val();
	var selectedSeafoods = $(".selectedSeafoods").val();
	var selectedPorkBeef = $(".selectedPorkBeef").val();
	var selectedVegetable = $(".selectedVegetable").val();
	var selectedRice = $(".selectedRice").val();
	var selectedSalad = $(".selectedSalad").val();
	var selectedDessert = $(".selectedDessert").val();
	var selectedDrinks = $(".selectedDrinks").val();

	if (selectedSoup == ""){
		$(".eventDetailsMsg").html("Soup is required");
		return false;
	}

	if (selectedChicken == ""){
		$(".eventDetailsMsg").html("Chicken is required");
		return false;
	}

	if (selectedSeafoods == ""){
		$(".eventDetailsMsg").html("Seafoods is required");
		return false;
	}

	if (selectedPorkBeef == ""){
		$(".eventDetailsMsg").html("Pork/Beef is required");
		return false;
	}

	if (selectedVegetable == ""){
		$(".eventDetailsMsg").html("Vegetable is required");
		return false;
	}

	if (selectedRice == ""){
		$(".eventDetailsMsg").html("Rice is required");
		return false;
	}

	if (selectedSalad == ""){
		$(".eventDetailsMsg").html("Salad is required");
		return false;
	}

	if (selectedDessert == ""){
		$(".eventDetailsMsg").html("Dessert is required");
		return false;
	}

	if (selectedDrinks == ""){
		$(".eventDetailsMsg").html("Drinks is required");
		return false;
	}

	if (menuID == 0){
		$(".eventDetailsMsg").html("Please select one menu");
		return false;
	}

	var data = {
		"selectedSoup" : selectedSoup,
		"selectedChicken" : selectedChicken,
		"selectedSeafoods" : selectedSeafoods,
		"selectedPorkBeef" : selectedPorkBeef,
		"selectedVegetable" : selectedVegetable,
		"selectedRice" : selectedRice,
		"selectedSalad" : selectedSalad,
		"selectedDessert" : selectedDessert,
		"selectedDrinks" : selectedDrinks,
		"menuID" : menuID
	};

	return data;
}

function insertEventPlanMaterials(eventID){
	for(var key in selectedMaterialsObj){
		if(selectedMaterialsObj.hasOwnProperty(key)){
			// console.log(key);
			// console.log(selectedMaterialsObj[key]);

			var materialID = key;
			var imgsIDs = selectedMaterialsObj[key];

			var idsLen = imgsIDs.length;

			for(var i=0; i<idsLen; i++){

				// console.log(imgsIDs[i]);
				$.post(
					"../controller/insertEventPlanMaterials.php",
					{
						"eventID" : eventID,
						"materialID" : materialID,
						"imgID" : imgsIDs[i]
					},
					function(data){
						// console.log(data);
					}
				);
			}


		}
	}
}

function insertEventPlanFoodsEntertainments(eventID){

	for(var key in selectedPartnersProd){
		if(selectedPartnersProd.hasOwnProperty(key)){
			// console.log(key);
			// console.log(selectedPartnersProd[key]);

			var prodCatID = key;
			var imgsIDs = selectedPartnersProd[key];

			var idsLen = imgsIDs.length;

			for(var i=0; i<idsLen; i++){

				$.post(
					"../controller/insertEventPlanFoodsEntertainments.php",
					{
						"eventID" : eventID,
						"prodCatID" : prodCatID,
						"imgID" : imgsIDs[i]
					},
					function(data){
						// console.log(data);
					}
				);
			}

		}
	}
}

function insertEventPlanMenu(eventID){
	var formData = getCateringMenuFormData();

	$.extend(formData, {"eventID" : eventID});

	$.post(
		"../controller/insertEventPlanMenu.php",
		formData,
		function(data){
			// console.log(data);
		}
	);
}

function clearDashboardInputFlds(){
	$(".typeOfEvents").val("");
	$(".serviceMotifs").val("");
	$(".typeOfVenue").val("");
	$(".outsideVenueAddress").val("");
	$(".budgetRange").val("");
	$(".eventDate").val("");
	$(".eventEstimateStartTime").val("");
	$(".eventEstimateEndTime").val("");
	$(".noOfGuests").val("");

	$(".selectedSoup").val("");
	$(".selectedChicken").val("");
	$(".selectedSeafoods").val("");
	$(".selectedPorkBeef").val("");
	$(".selectedVegetable").val("");
	$(".selectedRice").val("");
	$(".selectedSalad").val("");
	$(".selectedDessert").val("");
	$(".selectedDrinks").val("");

	selectedMaterialsObj = {};
	selectedPartnersProd = {};
	currentMaterialID = 0;
	currentProdCatID = 0;
	menuID = 0;
}

function insertEventPlanDetails(){
	var formData = getEventDetailsFormData();

	$.post(
		"../controller/insertEventPlanDetails.php",
		formData,
		function(data){
			console.log(data);

			var dataObj = JSON.parse(data);

			if(dataObj['done'] == "TRUE"){
				var eventID = parseInt(dataObj['id']);

				if (eventID > 0){
					insertEventPlanMaterials(eventID);
					insertEventPlanFoodsEntertainments(eventID);
					insertEventPlanMenu(eventID);
				}

				clearDashboardInputFlds();

				alert("Submited");
				window.location = "clientEventStatus.php";
			}else{
				$(".eventDetailsMsg").html(dataObj['msg']);
			}
		}
	);
}


$(".btnSubmitEventPlannerDetails").on("click", function(){
	insertEventPlanDetails();
});



//
// ####################### UPDATE
//

function getEventDetailsToUpdate(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "actualEventDataByID",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			displayEventDetailsToUpdate(data);
		}
	);
}

function displayEventDetailsToUpdate(data){
	var dataObj = JSON.parse(data);

	$(".typeOfEvents").val(dataObj[0].serviceID).change();

	setTimeout(function(){
		$(".serviceMotifs").val(dataObj[0].serviceMotifID).change();
		$(".typeOfVenue").val(dataObj[0].venueID).change();
		$(".outsideVenueAddress").val(dataObj[0].venueAddress);
		$(".budgetRange").val(dataObj[0].budgetRangeID).change();
		$(".eventDate").val(dataObj[0].eventDate);
		$(".eventEstimateStartTime").val(dataObj[0].eventStartTime);
		$(".eventEstimateEndTime").val(dataObj[0].eventEndTime);
		$(".noOfGuests").val(dataObj[0].noOfGuests);
	}, 500)
}

function getEventMaterialsToUpdate(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "actualMaterialIDs_motifsIDs",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			checkAllClientEventSelecteMaterials(data);
		}
	);
}

// var materialImgs = $(".materialMotifImg");
// 	var imgsLen = materialImgs.length;

// 	var materialMotifsImgIds = [];

// 	for(var i=0; i<imgsLen; i++){

// 		if ($(materialImgs[i]).prop('checked')){
// 			var id = $(materialImgs[i]).attr("id");

// 			materialMotifsImgIds.push(id);
// 		}
// 	}
// 	selectedMaterialsObj[currentMaterialID] = materialMotifsImgIds;

function checkAllClientEventSelecteMaterials(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	for(var i=0; i<dataLen; i++){
		selectedMaterialsObj[dataObj[i].materialID] = dataObj[i].materialImgIds;
	}

	// console.log(selectedMaterialsObj);


	// var materialCbox = $(".chkBoxMaterial");

	// // console.log(materialCbox);

	// for(var j=0; j<materialCbox.length; j++){

	// 	for(var i=0; i<dataLen; i++){

	// 		if (materialCbox[j].value == dataObj[i].materialID){
	// 			materialCbox[j].checked = true;
	// 		}

	// 		// console.log(materialCbox.attr("id")
	// 	}
	// }
}

function getEventFoodsEntertainmentToUpdate(eventID){
	$.post(
		"../controller/getEventsDetails_handler.php",
		{
			"task" : "actualFoodsEntertainmentIDs_motifsIDs",
			"eventID" : eventID
		},
		function(data){
			// console.log(data);
			checkAllClientEventSelecteFoodsEntertainments(data);
		}
	);
}

// var partnerImgs = $(".partnerMotifImg");
// 	var imgsLen = partnerImgs.length;

// 	var partnerMotifsImgIds = [];

// 	for(var i=0; i<imgsLen; i++){

// 		if ($(partnerImgs[i]).prop('checked')){
// 			var id = $(partnerImgs[i]).attr("id");

// 			partnerMotifsImgIds.push(id);
// 		}
// 	}

// 	selectedPartnersProd[currentProdCatID] = partnerMotifsImgIds;

function checkAllClientEventSelecteFoodsEntertainments(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	for(var i=0; i<dataLen; i++){
		selectedPartnersProd[dataObj[i].prodCatID] = dataObj[i].partnersMotifIDs;
	}

	// console.log(selectedPartnersProd);

	// var partnerMotifImgCbox = $(".chkBoxProdCat");
	// // console.log(partnerMotifImgCbox);
	// for(var j=0; j<partnerMotifImgCbox.length; j++){

	// 	for(var i=0; i<dataLen; i++){

	// 		if (partnerMotifImgCbox[j].value == dataObj[i].prodCatID){
	// 			partnerMotifImgCbox[j].checked = true;
	// 		}
	// 	}
	// }
}

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

	menuID = dataObj[0].id;

	$(".setTitle").html(dataObj[0].setTitle +" @ "+ dataObj[0].setPrice);
	$(".selectedSoup").val(dataObj[0].soup);
	$(".selectedChicken").val(dataObj[0].chicken);
	$(".selectedSeafoods").val(dataObj[0].seafoods);
	$(".selectedPorkBeef").val(dataObj[0].porkBeef);
	$(".selectedVegetable").val(dataObj[0].vegetable);
	$(".selectedRice").val(dataObj[0].rice);
	$(".selectedSalad").val(dataObj[0].salad);
	$(".selectedDessert").val(dataObj[0].dessert);
	$(".selectedDrinks").val(dataObj[0].drinks);

}


$(document).ready(function(){
	if (eventID != 0 && eventID > 0 && task == "update-event-details"){
		getEventDetailsToUpdate(eventID);
	}else if(eventID != 0 && eventID > 0 && task == "update-event-material"){
		// getEventMaterialsToUpdate(eventID);
	}else if(eventID != 0 && eventID > 0 && task == "update-event-foods-entertainment"){
		// getEventFoodsEntertainmentToUpdate(eventID);
	}else if(eventID != 0 && eventID > 0 && task == "update-event-menu"){
		getEventSelectedMenu(eventID);
	}
})

function updateEventPlanDetails(eventID){
	var formData = getEventDetailsFormData();

	if (typeof formData == "boolean"){
		alert("Please complete the form fields");
	}

	$.extend(formData, {"eventID" : eventID});

	$.post(
		"../controller/updateEventPlanDetails.php",
		formData,
		function(data){
			// console.log(data);
			var dataObj = JSON.parse(data);

			if(dataObj['done'] == "TRUE"){
				clearDashboardInputFlds();
			}

			$(".eventDetailsMsg").html(dataObj['msg']);
		}
	);
}

$(".btnUpdateEventDetails").on("click", function(){
	if (eventID != 0 && eventID > 0){
		updateEventPlanDetails(eventID);
	}
})

function updateUpdateEventMaterial(eventID){
	for(var key in selectedMaterialsObj){
		if(selectedMaterialsObj.hasOwnProperty(key)){
			// console.log(key);
			// console.log(selectedMaterialsObj[key]);

			var materialID = key;
			var imgsIDs = selectedMaterialsObj[key];

			var idsLen = imgsIDs.length;

			for(var i=0; i<idsLen; i++){

				$.post(
					"../controller/updateEventPlanMaterials.php",
					{
						"eventID" : eventID,
						"materialID" : materialID,
						"imgID" : imgsIDs[i]
					},
					function(data){
						console.log(data);
						var dataObj = JSON.parse(data);

						$(".eventDetailsMsg").append(dataObj.msg + "<br/>");
					}
				);
			}
		}

	}


}

$(".btnUpdateEventMaterial").on("click", function(){
	// console.log(selectedMaterialsObj);

	if (eventID != 0 && eventID > 0){
		updateUpdateEventMaterial(eventID);
		setTimeout(function(){
			$(".eventDetailsMsg").html("");
		}, 3000);
	}
})

function updateEventPlanFoodsEntertainments(eventID){

	for(var key in selectedPartnersProd){
		if(selectedPartnersProd.hasOwnProperty(key)){

			var prodCatID = key;
			var imgsIDs = selectedPartnersProd[key];

			// console.log(prodCatID);
			// console.log(imgsIDs);

			var idsLen = imgsIDs.length;

			for(var i=0; i<idsLen; i++){

				$.post(
					"../controller/updateEventPlanFoodsEntertainments.php",
					{
						"eventID" : eventID,
						"prodCatID" : prodCatID,
						"imgID" : imgsIDs[i]
					},
					function(data){
						var dataObj = JSON.parse(data);

						$(".eventDetailsMsg").append(dataObj.msg + "<br/>");
						// if(data == "TRUE"){
						// 	alert("YES");
						// 	$(".eventDetailsMsg").html("New foods/entertainment item/s added");
						// }
					}
				);
			}

		}
	}

	// $(".eventDetailsMsg").html("New foods/entertainment item/s added");
}

$(".btnUpdateEventFoodsEntertainments").on("click", function(){
	if (eventID != 0 && eventID > 0){
		updateEventPlanFoodsEntertainments(eventID);
		setTimeout(function(){
			$(".eventDetailsMsg").html("");
		}, 3000);
	}
})

function updateEventPlanMenu(eventID){
	var formData = getCateringMenuFormData();

	// console.log(formData);

	$.extend(formData, {"eventID" : eventID});

	$.post(
		"../controller/updateEventPlanMenu.php",
		formData,
		function(data){
			var dataObj = JSON.parse(data);
			$(".eventDetailsMsg").html(dataObj.msg);
		}
	);
}

$(".btnUpdateEventMenu").on("click",function(){
	if (eventID != 0 && eventID > 0){
		updateEventPlanMenu(eventID);
	}
})

function checkSelectedTimesIfValid(start, end){
	$.post(
		"../controller/checkSelectedTime.php",
		{
			"start" : start,
			"end" : end
		},
		function(data){
			var dataObj = JSON.parse(data);
			if (dataObj.done === "TRUE"){
				$(".selectDateMsg").html(dataObj.msg);
			}else{
				$(".selectDateMsg").html("");
			}
		}
	);
}

$(".eventEstimateEndTime").on("change", function(){
	var startTime = $(".eventEstimateStartTime").val();
	var endTime = $(this).val();

	if (startTime !== ""){
		checkSelectedTimesIfValid(startTime, endTime);
	}
})

$(".eventEstimateStartTime").on("change", function(){
	var startTime = $(this).val();
	var endTime = $(".eventEstimateEndTime").val();

	if (endTime !== ""){
		checkSelectedTimesIfValid(startTime, endTime);
	}
})
