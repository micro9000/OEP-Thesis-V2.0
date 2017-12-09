
function getFormData(){

	var setTitle = $(".setTitle").val();
	var setPrice = $(".setPrice").val();

	// Soup
	var soup = $(".soup").val();
	var soup_changable = "";
	if ($('.soup_changable').is(':checked') ){
		soup_changable = $(".soup_changable").val();
	}
	if (soup == ""){
		alert("Please enter soup");
		return;
	}

	// Chicken
	var chicken = $(".chicken").val();
	var chicken_changable = "";
	if ($('.chicken_changable').is(':checked') ){
		chicken_changable = $(".chicken_changable").val();
	}
	if (chicken == ""){
		alert("Please enter chicken");
		return;
	}


	// Seafoods
	var seafoods = $(".seafoods").val();
	var seafoods_changable = "";
	if ($('.seafoods_changable').is(':checked') ){
		seafoods_changable = $(".seafoods_changable").val();
	}
	if (seafoods == ""){
		alert("Please enter seafoods");
		return;
	}


	// Port beef
	var pork_beef = $(".pork_beef").val();
	var pork_beef_changable = "";
	if ($('.pork_beef_changable').is(':checked') ){
		pork_beef_changable = $(".pork_beef_changable").val();
	}
	if (pork_beef == ""){
		alert("Please enter pork_beef");
		return;
	}

	// Vegetable
	var vegetable = $(".vegetable").val();
	var vegetable_changable = "";
	if ($('.vegetable_changable').is(':checked') ){
		vegetable_changable = $(".vegetable_changable").val();
	}
	if (vegetable == ""){
		alert("Please enter vegetable");
		return;
	}

	// Rice
	var rice = $(".rice").val();
	var rice_changable = "";
	if ($('.rice_changable').is(':checked') ){
		rice_changable = $(".rice_changable").val();
	}
	if (rice == ""){
		alert("Please enter rice");
		return;
	}


	// Salad
	var salad = $(".salad").val();
	var salad_changable = "";
	if ($('.salad_changable').is(':checked') ){
		salad_changable = $(".salad_changable").val();
	}
	if (salad == ""){
		alert("Please enter salad");
		return;
	}


	// Dessert
	var dessert = $(".dessert").val();
	var dessert_changable = "";
	if ($('.dessert_changable').is(':checked') ){
		dessert_changable = $(".dessert_changable").val();
	}
	if (dessert == ""){
		alert("Please enter dessert");
		return;
	}

	// Drinks
	var drinks = $(".drinks").val();
	var drinks_changable = "";
	if ($('.drinks_changable').is(':checked') ){
		drinks_changable = $(".drinks_changable").val();
	}
	if (drinks == ""){
		alert("Please enter drinks");
		return;
	}

	var data = {
		"setTitle" : setTitle,
		"setPrice" : setPrice,
		"soup" : soup,
		"soup_changable" : soup_changable,
		"chicken" : chicken,
		"chicken_changable" : chicken_changable,
		"seafoods" : seafoods,
		"seafoods_changable" : seafoods_changable,
		"pork_beef" : pork_beef,
		"pork_beef_changable" : pork_beef_changable,
		"vegetable" : vegetable,
		"vegetable_changable" : vegetable_changable,
		"rice" : rice,
		"rice_changable" : rice_changable,
		"salad" : salad,
		"salad_changable" : salad_changable,
		"dessert" : dessert,
		"dessert_changable" : dessert_changable,
		"drinks" : drinks,
		"drinks_changable" : drinks_changable
	};

	return data;
}

$(".btnInsertMenu").on("click", function(){
	var data = getFormData();

	$.post(
		"controller/insert_new_menu.php",
		data,
		function(data){
			if (data == "TRUE"){

				insertUserAction("Add new menu ("+ $(".setTitle").val() +")");

				$('.menusInputMsg').html("Inserted");
				clearMenuInputs();
				getAllMenus();
			}
		}
	);
});

function clearMenuInputs(){
	$(".setTitle").val("");
	$(".setPrice").val("");

	$(".soup").val("");
	$('.soup_changable').prop('checked', false);
	$(".chicken").val("");
	$('.chicken_changable').prop('checked', false);
	$(".seafoods").val("");
	$('.seafoods_changable').prop('checked', false);
	$(".pork_beef").val("");
	$('.pork_beef_changable').prop('checked', false);
	$(".vegetable").val("");
	$('.vegetable_changable').prop('checked', false);
	$(".rice").val("");
	$('.rice_changable').prop('checked', false);
	$(".salad").val("");
	$('.salad_changable').prop('checked', false);
	$(".dessert").val("");
	$('.dessert_changable').prop('checked', false);
	$(".drinks").val("");
	$('.drinks_changable').prop('checked', false);
}

function getAllMenus(){
	$.post(
		"controller/getMenus_handler.php",
		{
			"task" : "all"
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMenus(dataObj);
		}
	);
}

function getMenuByID(id){
	$.post(
		"controller/getMenus_handler.php",
		{
			"task" : "byID",
			"menuID" : id
		},
		function(data){
			console.log(data);
			var dataObj = JSON.parse(data);
			displayMenus(dataObj);
			displayMenus_input(dataObj);
		}
	);
}

function displayMenus_input(data){
	
	var dataLen = data.length;
	$(".setTitle").val(data[0].setTitle);
	$(".setPrice").val(data[0].setPrice);

	$(".soup").val(data[0].soup);
	if (data[0].soupIsChangable == "1"){
		$('.soup_changable').prop('checked', true);
	}

	$(".chicken").val(data[0].chicken);
	if (data[0].chickenIsChangable == "1"){
		$('.chicken_changable').prop('checked', true);
	}

	$(".seafoods").val(data[0].seafoods);
	if (data[0].seafoodsIsChangable == "1"){
		$('.seafoods_changable').prop('checked', true);
	}

	$(".pork_beef").val(data[0].porkBeef);
	if (data[0].porkBeefIsChangable == "1"){
		$('.pork_beef_changable').prop('checked', true);
	}

	$(".vegetable").val(data[0].vegetable);
	if (data[0].vegetableIsChangable == "1"){
		$('.vegetable_changable').prop('checked', true);
	}

	$(".rice").val(data[0].rice);
	if (data[0].riceIsChangable == "1"){
		$('.rice_changable').prop('checked', true);
	}

	$(".salad").val(data[0].salad);
	if (data[0].saladIsChangable == "1"){
		$('.salad_changable').prop('checked', true);
	}

	$(".dessert").val(data[0].dessert);
	if (data[0].dessertIsChangable == "1"){
		$('.dessert_changable').prop('checked', true);
	}

	$(".drinks").val(data[0].drinks);
	if (data[0].drinksIsChangable == "1"){
		$('.drinks_changable').prop('checked', true);
	}
}

function displayMenus(data){
	// console.log(data);
	var dataLen = data.length;

	var menus = "";

	for(var i=0; i< dataLen; i++){
		menus += "<tr>";
		menus += "<td>"+ data[i].setTitle +"</td>";
		menus += "<td>"+ data[i].setPrice +"</td>";
		menus += "<td>"+ data[i].soup +"</td>";
		menus += "<td>"+ data[i].chicken +"</td>";
		menus += "<td>"+ data[i].seafoods +"</td>";
		menus += "<td>"+ data[i].porkBeef +"</td>";
		menus += "<td>"+ data[i].vegetable +"</td>";
		menus += "<td>"+ data[i].rice +"</td>";
		menus += "<td>"+ data[i].salad +"</td>";
		menus += "<td>"+ data[i].dessert +"</td>";
		menus += "<td>"+ data[i].drinks +"</td>";
		menus += "<td><a href='menus.php?menuID="+ data[i].id +"'>select</a></td>";
		menus += "</tr>";
	}

	$(".menusLst").html(menus);
}

$(document).ready(function(){
	if (menuID != 0 && menuID > 0){
		getMenuByID(menuID);
	}else{
		getAllMenus();
	}
});

$(".btnDeleteMenu").on("click", function(){
	if (menuID != 0 && menuID > 0){

		var r = confirm("Are you sure you want to delete this menu?");

		if (r == true){

			$.post(
				"controller/delete_menu.php",
				{
					"menuID" : menuID
				},
				function(data){
					if (data == "TRUE"){

						insertUserAction("Delete menu");

						alert("Deleted");
						window.location = "menus.php";
					}
				}
			);

		}

	}
});



$(".btnUpdateMenu").on("click", function(){
	if (menuID != 0 && menuID > 0){

		var data = getFormData();
		$.extend(data, {'menuID' : menuID});

		$.post(
			"controller/update_menu.php",
			data,
			function(data){
				if (data == "TRUE"){

					insertUserAction("Update menu ("+ $(".setTitle").val() +")");

					$('.menusInputMsg').html("Updated");
					clearMenuInputs();
					getMenuByID(menuID);
				}
			}
		);
	}

		
});