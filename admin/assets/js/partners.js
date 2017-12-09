$(".btnAddNewPartner").on("click", function(){
	insertNewPartnersInfo();
	getAllPartners();
})

function getFormData(){

	var partnersName = $(".partnersName").val();
	var partnersInfo = $(".partnersInfo").val();
	var partnersSmart = $(".partnersSmart").val();
	var partnersGlobe = $(".partnersGlobe").val();
	var partnersEmail = $(".partnersEmail").val();

	if (partnersName == "" && partnersInfo == ""){
		alert("Please enter partner name or info");
	}else{

		var data = {
			"partnerName" : partnersName,
			"partnerInfo" : partnersInfo,
			"contactSmart" : partnersSmart,
			"contactGlobe" : partnersGlobe,
			"contactEmail" : partnersEmail
		};

		return data;
	}
}

function insertNewPartnersInfo(){
	var data = getFormData();

	$.post(
		"controller/insertNewPartner.php",
		data,
		function(data){
			// console.log(data);
			var dataObj = JSON.parse(data);

			if (dataObj.done == "TRUE"){

				insertUserAction("Add New Partner ("+ $(".partnersName").val() +")");

				clearInputs();
			}

			$(".partnerInputMsg").html(dataObj.msg);
		}
	);
}

function clearInputs(){
	$(".partnersName").val("");
	$(".partnersInfo").val("");
	$(".partnersSmart").val("");
	$(".partnersGlobe").val("");
	$(".partnersEmail").val("");
}


function getPartnersInfoByID(id){
	$.post(
		"controller/getPartners_handler.php",
		{
			"task" : "byID",
			"partnerID" : id
		},
		function(data){
			// console.log(data);
			displayPartners(data);
			displayPartners_inputs(data);
		}
	)
}

function getAllPartners(){
	$.post(
		"controller/getPartners_handler.php",
		{
			"task" : "all"
		},
		function(data){
			displayPartners(data);
		}
	)
}

function displayPartners_inputs(data){
	var dataObj = JSON.parse(data);

	$(".partnersName").val(dataObj[0].partnerName);
	$(".partnersInfo").val(dataObj[0].info);
	$(".partnersSmart").val(dataObj[0].contactSmart);
	$(".partnersGlobe").val(dataObj[0].contactGlobe);
	$(".partnersEmail").val(dataObj[0].contactEmail);
}

function displayPartners(data){
	var dataObj = JSON.parse(data);

	// console.log(dataObj);

	var dataLen = dataObj.length;

	var partners = "";
	for(var i=0; i<dataLen; i++){
		partners += "<tr>";
		partners += "<td>"+ dataObj[i].partnerName +"</td>";
		partners += "<td>"+ dataObj[i].info +"</td>";
		partners += "<td>"+ dataObj[i].contactSmart +"</td>";
		partners += "<td>"+ dataObj[i].contactGlobe +"</td>";
		partners += "<td>"+ dataObj[i].contactEmail +"</td>";
		partners += "<td><a href='partners.php?partnerID="+ dataObj[i].id +"'>select</a></td>";
		partners += "</tr>";
	}

	$(".partnersList").html(partners);
}

$(".btnDeletePartner").on("click", function(){

	if (partnerID > 0 && partnerID != 0){

		var r = confirm("Are you sure you want to delete this partner?");

		if (r == true){
			$.post(
				"controller/delete_partner_info.php",
				{
					"partnerID" : partnerID
				},
				function(data){
					if (data == "TRUE"){

						insertUserAction("Delete Partner info ("+ $(".partnersName").val() +")");

						alert("Deleted");
						window.location = "partners.php";
					}
				}
			)
		}

	}
});

function updatePartnersInfo(id){
	var data = getFormData();

	$.extend(data, {"partnerID" : id});

	$.post(
		"controller/updatePartnerInfo.php",
		data,
		function(data){
			//console.log(data);
			var dataObj = JSON.parse(data);

			if (dataObj.done == "TRUE"){

				insertUserAction("Update Partner info ("+ $(".partnersName").val() +")");

				clearInputs();
			}

			$(".partnerInputMsg").html(dataObj.msg);
			getPartnersInfoByID(id);
		}
	);
}

$(".btnUpdatePartner").on("click", function(){
	
	if (partnerID > 0 && partnerID != 0){
		updatePartnersInfo(partnerID);
	}

})

function getMotifFormData(){
	var formData = new FormData();

	var motif = $(".motif").val();
	var prodCatID = $(".prodCategory").val();

	if (motif != ""){

		var fileLen = $(".motifImages")[0].files.length;

		if (fileLen > 0){
			for(var i=0; i<fileLen; i++){
				formData.append('motifImages' + i, $(".motifImages")[0].files[i]);
			}

			formData.append('motifTheme', motif);
			formData.append('prodCatID', prodCatID);
		}
	}

	return formData;
}

$(".btnInsertPartnerMotif").on("click", function(){
	if (partnerID > 0 && partnerID != 0){
		var formData = getMotifFormData();

		formData.append("partnerID", partnerID);

		var request = $.ajax({
	        url: 'controller/insertPartnerNewMotif.php',
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
	    		clearInputsMotif();
	    	}
	    	$(".motifError").html(dataObj.msg);

	    	getAllMotifs(partnerID);
	    });
	}
});

function clearInputsMotif(){
	$(".motifImages").val("");
	$(".motif").val("");
	$(".prodCategory").val("");
}

function getAllMotifs(partnerID){
	$.post(
		"controller/getPartners_handler.php",
		{
			"task" : "motifs",
			"partnerID" : partnerID
		},
		function(data){
			// console.log(data);
			displayMotifs(data, partnerID);
		}
	)
}

function getMotifByID(motifID, partnerID){
	$.post(
		"controller/getPartners_handler.php",
		{
			"task" : "motifID",
			"motifID" : motifID,
			"partnerID" : partnerID
		},
		function(data){
			// console.log(data);
			displayMotifs(data, partnerID);
		}
	)
}

function displayMotifs(data, partnerID){

	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var motifs = "";
	for(var i=0; i<dataLen; i++){
		motifs += "<tr>";
		motifs += "<td>"+ dataObj[i].theme +"</td>";
		motifs += "<td>"+ dataObj[i].prodCat +"</td>";
		motifs += "<td><a href='partners.php?partnerID="+ partnerID +"&motifID="+ dataObj[i].id +"'>select</a></td>";
		motifs += "</tr>";
	}

	$(".motifs").html(motifs);
}

function displayMotifImages(motifID, partnerID){
	$.post(
		"controller/getPartners_handler.php",
		{
			"task" : "motifImages",
			"motifID" : motifID
		},
		function(data){
			displayPartnerMotifImages(data, motifID, partnerID);
		}
	)
}

function displayPartnerMotifImages(data, motifID, partnerID){
	var dataObj = JSON.parse(data);
	// console.log(dataObj);
	var dataLen = dataObj.length;

	var images = "";

	for(var i=0; i<dataLen; i++){
		images += "<div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>";
		images += "<a href='partner_motif_images.php?partnerID="+ partnerID +"&motifID="+ motifID +"&imageID="+ dataObj[i].id +"' target='_blank' class='d-block mb-4 h-100'>";
		images += "<img class='img-fluid img-thumbnail' src='../uploads/PartnersMotif/"+ dataObj[i].serverName +"' alt=''>";
		images += "<div class='caption'>";
		images += "Reference # : " + dataObj[i].imageRefNo + "<br/>";
		images += "Price : " + dataObj[i].price + "<br/>";
		images += "</div>";
		images += "</a>";
		images += "</div>";
	}

	$(".partnerMotifsImages").html(images);
}

$(".btnDeleteMotif").on("click", function(){
	if (motifID != 0 && motifID > 0 && partnerID > 0 && partnerID != 0){

		var r = confirm("Are you sure you want to delete this motif?");

		if (r == true){
			$.post(
				"controller/delete_partner_motif.php",
				{
					"motifID" : motifID
				},
				function(data){
					// console.log(data);
					if (data == "TRUE"){
						alert("Deleted");
						window.location = "partners.php?partnerID=" + partnerID;
					}
				}
			)
		}	
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

	var cats = "<option></option>";

	for(var i=0; i<dataLen; i++){
		cats += "<option value='"+ dataObj[i].id +"'>"+ dataObj[i].prodCat +"</option>";
	}

	$(".prodCategory").html(cats);
}

$(document).ready(function(){

	if (partnerID != 0 && partnerID > 0){
		getPartnersInfoByID(partnerID);
		getAllMotifs(partnerID);
		getAllProductCategories();

		if (motifID != 0 && motifID > 0){
			getMotifByID(motifID, partnerID);
			displayMotifImages(motifID, partnerID);
		}
	}else{
		getAllPartners();
	}
	
});

