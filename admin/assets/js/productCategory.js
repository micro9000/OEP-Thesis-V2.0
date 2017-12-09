
$(".btnAddProductCat").on("click", function(){
	var category = $(".category").val();

	if (category != ""){
		$.post(
			"controller/insertNewProductCategory.php",
			{
				"productCat" : category
			},
			function(data){
				if (data == "TRUE"){

					insertUserAction("Add new product category ( "+ category +" )");

					getAllProductCategories();
				}
			}
		);
	}
});

function getAllProductCategories(){
	$.post(
		"controller/getAllProductCategories.php",
		function(data){
			displayCategories(data);
		}
	);
}

function displayCategories(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var cats = "";

	for(var i=0; i<dataLen; i++){
		cats += "<tr>";
		cats += "<td>"+ dataObj[i].prodCat +"</td>";
		cats += "<td><input type='submit' value='Delete' class='btnDeleteCat' id='"+ dataObj[i].id +"'/></td>";
		cats += "</tr>";
	}

	$(".categories").html(cats);
}

$(document).on("click", ".btnDeleteCat", function(){
	var catID = $(this).attr("id");

	var r = confirm("Are you sure you want to delete this category?");

	if(r == true){
		$.post(
			"controller/deleteProductCategory.php",
			{
				"prodCatID" : catID
			},
			function(data){
				if (data == "TRUE"){

					insertUserAction("Delete Product Category");

					alert("Deleted");
					getAllProductCategories();
				}
			}
		);
	}
});

$(document).ready(function(){
	getAllProductCategories();
});