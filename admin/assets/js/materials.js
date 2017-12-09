
$(".btnAddMaterial").on("click", function(){
	var material = $(".material").val();

	if(material != ""){
		$.post(
			"controller/insert_material.php",
			{
				"material" : material
			},
			function(data){
				// console.log(data);

				var dataObj = JSON.parse(data);

				if(dataObj.done == "TRUE"){
					
					insertUserAction("Add New Material ("+ $(".material").val() +")");

					$(".material").val("");
					$(".materialInputMsg").html(dataObj.msg);

					setTimeout(function(){
						$(".materialInputMsg").html("");
						getAllMaterials();
					}, 500);
				}
			}
		);
	}
})

function getAllMaterials(){
	$.post(
		"controller/getMaterial_handler.php",
		{
			"task" : "all"
		},
		function(data){

			var dataObj = JSON.parse(data);
			displayAllMaterials_tb(dataObj);
			displayAllMaterials_select(dataObj);
			displayAllMaterials_select_filter(dataObj)
		}
	);
}

function displayAllMaterials_select(data){
	// console.log(data);
	var dataLen = data.length;

	var materials = "<option value=''></option>";
	for(var i=0; i<dataLen; i++){
		materials += "<option value='"+ data[i].id +"'>"+ data[i].material +"</option>";
	}

	$(".materialsSelect").html(materials);
}

function displayAllMaterials_select_filter(data){
	// console.log(data);
	var dataLen = data.length;

	var materials = "<option value='0'>all</option>";
	for(var i=0; i<dataLen; i++){
		materials += "<option value='"+ data[i].id +"'>"+ data[i].material +"</option>";
	}

	$(".filterMaterialThemeList").html(materials);
}

function displayAllMaterials_tb(data){
	// console.log(data);
	var dataLen = data.length;

	var materials = "";
	for(var i=0; i<dataLen; i++){
		materials += "<tr>";
		materials += "<td>"+ data[i].material +"</td>";
		materials += "<td><input type='submit' class='btnDeleteMaterial' id="+ data[i].id +" value='Delete'></td>";
		materials += "</tr>";
	}

	$(".materialsList").html(materials);
}

$(document).on("click",".btnDeleteMaterial", function(){
	var materialID = $(this).attr("id");
	
	var r = confirm("Are you sure you want to delete this material?");

	if(r == true){

		$.post(
			"controller/delete_material.php",
			{
				"materialID" : materialID
			},
			function(data){
				if (data == "TRUE"){

					insertUserAction("Delete Material");

					alert("Deleted");
					getAllMaterials();
					getAllMaterialThemes();
				}
			}
		);
	}
});

function clearThemeInputs(){
	$(".materialTheme").val("");
	$(".materialsSelect").val("");
	$(".materialImgs").val("");
}

$(".btnAddMaterialTheme").on("click", function(){

	var materialTheme = $(".materialTheme").val();
	var materialsSelect = $(".materialsSelect").val();
	var formData = new FormData();

	if (materialTheme != "" && materialsSelect != ""){

		var fileLen = $(".materialImgs")[0].files.length;

		if (fileLen > 0){

			for(var i=0; i<fileLen; i++){
				formData.append('materialImages' + i, $(".materialImgs")[0].files[i]);
			}

			formData.append("materialTheme" , materialTheme);
			formData.append("materialsSelect" , materialsSelect);

			var request = $.ajax({
		        url: 'controller/insert_material_theme.php',
		        type: "POST",
		        data: formData,
		        contentType: false,
		        cache: false,
		        processData: false
		    });

		    request.done(function(data){
		    	var dataObj = JSON.parse(data);

		    	if (dataObj.done == "TRUE"){

		    		insertUserAction("Add New Material theme ("+ materialTheme +")");

		    		$(".materialThemeMsg").html(dataObj.msg);
		    		clearThemeInputs();

		    		setTimeout(function(){
		    			$(".materialThemeMsg").html("");
		    		}, 1000);

		    		getAllMaterialThemes();
		    	}
		    });

		}else{
			alert("Please add image/s");
			return;
		}
	}

});

function getAllMaterialThemes(){
	$.post(
		"controller/getMaterial_handler.php",
		{
			"task" : "allThemes",
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMaterialThemes(dataObj);
		}
	)
}

function getAllMaterialThemesByThemeID(themeID){
	$.post(
		"controller/getMaterial_handler.php",
		{
			"task" : "themeID",
			"themeID" : themeID
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMaterialThemes(dataObj);
		}
	)
}

function displayMaterialThemes(data){
	var dataLen = data.length;

	var themes = "";
	for(var i=0; i<dataLen; i++){
		themes += "<tr>";
		themes += "<td>"+ data[i].material +"</td>";
		themes += "<td>"+ data[i].theme +"</td>";
		themes += "<td><a href='materials.php?themeID="+ data[i].id +"'>select</a></td>";
		themes += "</tr>";
	}

	$(".materialThemes").html(themes);
}

$(".btnDeleteTheme").on("click", function(){
	if (themeID != 0 && themeID > 0){

		var r = confirm("Are you sure you want to delete this theme?");

		if (r == true){
			$.post(
				"controller/delete_material_theme.php",
				{
					"themeID" : themeID
				},
				function(data){
					if (data == "TRUE"){

						insertUserAction("Delete Material theme");

						alert('Deleted');
						window.location = "materials.php";
					}
				}
			);
		}
	
	}
});

function getMaterialThemesImagesByThemeID(themeID){
	$.post(
		"controller/getMaterial_handler.php",
		{
			"task" : "themesImagesByThemeID",
			"themeID" : themeID
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMaterialThemeImages(dataObj);
		}
	)
}

function displayMaterialThemeImages(data){
	var dataLen = data.length;
	if (themeID != 0 && themeID > 0){
		var images = "";

		for(var i=0; i<dataLen; i++){
			images += "<div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>";
			images += "<a href='material_theme_image.php?themeID="+ themeID +"&imageID="+ data[i].id +"' target='_blank' class='d-block mb-4 h-100'>";
			images += "<img class='img-fluid img-thumbnail' src='../uploads/Materials/"+ data[i].serverName +"' alt=''>";
			images += "<div class='caption'>";
			images += "Reference # : " + data[i].referenceNo + "<br/>";
			images += "Price : " + data[i].price + "<br/>";
			images += "</div>";
			images += "</a>";
			images += "</div>";
		}

		$(".materialsImages").html(images);
	}
}

$(document).ready(function(){
	getAllMaterials();

	if (themeID != 0 && themeID > 0){
		getAllMaterialThemesByThemeID(themeID);
		getMaterialThemesImagesByThemeID(themeID);
	}else{
		getAllMaterialThemes();
	}

	
});

function getAllMaterialThemesByMaterialID(materialID){
	$.post(
		"controller/getMaterial_handler.php",
		{
			"task" : "themesByMaterialID",
			"materialID" : materialID
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMaterialThemes(dataObj);
		}
	)
}

$(".filterMaterialThemeList").on("change", function(){

	var matID = $(this).val();

	if (matID != "" && matID != 0){
		getAllMaterialThemesByMaterialID($(this).val());
	}else{
		getAllMaterialThemes();
	}
});