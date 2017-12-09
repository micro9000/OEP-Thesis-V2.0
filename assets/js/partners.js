$(document).ready(function(){
	if (partnerID > 0 && partnerID !== 0){
		getPartner(partnerID);
	}else{
		getAllPartners();
	}
});

function getPartner(id){
	$.post(
		"../controller/getPartnerInfoByID.php",
		{
			"partnerID" : id
		},
		function(data){
			displayAllPartnersInfo(data);
		}
	);
}

function getAllPartners(){
	$.post(
		"../controller/getAllPartners.php",
		{},
		function(data){
			displayAllPartners(data);
		}
	);
}

function displayAllPartners(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var partners = "";

	for(var i=0; i < dataLen; i++){
		partners += "<p><a href='partners_info.php?partnerID="+ dataObj[i].id +"'>";
		partners += dataObj[i].partnerName;
		partners += "</a></p>";
	}

	$(".partners").html(partners);
}

function displayAllPartnersInfo(data){
	var dataObj = JSON.parse(data);
	// console.log(dataObj);

	var dataLen = dataObj.length;

	var partners = "";

	for(var i=0; i < dataLen; i++){
		partners += "<div class='col-lg-12 col-md-12 col-sm-12'>";
			partners += "<h3 class='partnersName'>" + dataObj[i].partnerName +"</h3>";
			partners += "<p class='partnersInfo'>"+ dataObj[i].info +"</p>";
			partners += "<p class='partnersContact'>"
				partners += "Contact Smart " + dataObj[i].contactSmart + "<br/>";
				partners += "Contact GLOBE " + dataObj[i].contactGlobe + "<br/>";
				partners += "Contact Email " + dataObj[i].contactEmail + "<br/>";
			partners += "</p>"
		partners += "</div>";
	}

	$(".partnersInfos").html(partners);
}