

$(".btnAddService").on("click", function(){

	var service = $(".serviceTitle").val();

	if (service != ""){

		$.post(
			"controller/insertNewService.php",
			{
				"service" : service
			},
			function(data){
				if (data == "TRUE"){

					insertUserAction("Add new service ("+ service +")");

					$(".serviceInputMsg").html("Inserted");
					$(".serviceTitle").val("");
					getAllServices();
				}
			}
		);
	}
});

function getAllServices(){
	$.post(
		"controller/getAllServices.php",
		function(data){
			var dataObj = JSON.parse(data);
			displayServices_tb(dataObj);
			displayServices_select(dataObj);
			displayServices_select_filter(dataObj);
		}
	);
}

function displayServices_tb(data){
	var dataLen = data.length

	var services = "";

	for(var i=0; i<dataLen; i++){
		services += "<tr>";
		services += "<td>"+ data[i].service +"</td>";
		services += "<td><input type='submit' class='btnDeleteService' value='Delete' id='"+ data[i].id +"'></td>";
		services += "</tr>";
	}

	$(".servicesList").html(services);
}

function displayServices_select(data){
	var dataLen = data.length

	var services = "<option></option>";

	for(var i=0; i<dataLen; i++){
		services += "<option value='"+ data[i].id +"'>"+ data[i].service +"</option>";
	}

	$(".serviceSelect").html(services);
}


function displayServices_select_filter(data){
	var dataLen = data.length

	var services = "<option value='0'>all</option>";

	for(var i=0; i<dataLen; i++){
		services += "<option value='"+ data[i].id +"'>"+ data[i].service +"</option>";
	}

	$(".filterServiceMotif").html(services);
}

$(document).on("click", ".btnDeleteService", function(){

	var serviceID = $(this).attr("id");

	if (serviceID != ""){

		var r = confirm("Are you sure you want to delete this service?");

		if (r == true){
			$.post(
				"controller/delete_service.php",
				{
					"serviceID" : serviceID
				},
				function(data){
					if (data == "TRUE"){

						insertUserAction("Delete service");

						alert('Deleted');
						getAllServices();
						getAllServicesMotifs();
					}
				}
			);
		}
	}
});

$(".btnAddServiceMotif").on("click", function(){

	var serviceID = $(".serviceSelect").val();
	var serviceMotif = $(".serviceMotif").val();

	if (serviceID != "" && serviceMotif != ""){

		$.post(
			"controller/insertNewServiceMotif.php",
			{
				"serviceID" : serviceID,
				"serviceMotif" : serviceMotif
			},
			function(data){

				if (data == "TRUE"){

					insertUserAction("Add service motif ("+ serviceMotif +")");

					$(".serviceSelect").val("");
					$(".serviceMotif").val("");
					getAllServicesMotifs();
				}

			}
		)

	}
});

function getAllServicesMotifs(){

	$.post(
		"controller/getAllServicesMotif_handler.php",
		{
			"task" : "all"
		},
		function(data){
			var dataObj = JSON.parse(data);
			displayMotifs(dataObj);
		}
	);
}

function displayMotifs(data){

	var dataLen = data.length;
	var motifs = "";

	for(var i=0; i<dataLen; i++){
		motifs += "<tr>";
		motifs += "<td>"+ data[i].service +"</td>";
		motifs += "<td>"+ data[i].motif +"</td>";
		motifs += "<td><input type='submit' class='btnDeleteMotifs' id='"+ data[i].id +"' value='Delete'></td>";
		motifs += "</tr>";
	}

	$(".motifs").html(motifs);
}

$(document).on("click", ".btnDeleteMotifs", function(){

	var motifID = $(this).attr("id");

	if (motifID != ""){

		var r = confirm("Are you sure you want to delete this motif?");

		if (r == true){

			$.post(
				"controller/delete_service_motif.php",
				{
					"motifID" : motifID
				},
				function(data){
					if (data == "TRUE"){

						insertUserAction("Delete service motif");

						alert("Deleted");
						getAllServicesMotifs();
					}
				}
			);
		}
	}
});

$(document).ready(function(){
	getAllServices();
	getAllServicesMotifs();
});

function getAllServicesMotifsByServiceID(serviceID){

	$.post(
		"controller/getAllServicesMotif_handler.php",
		{
			"task" : "serviceID",
			"serviceID" : serviceID
		},
		function(data){
			// console.log(data);
			var dataObj = JSON.parse(data);
			displayMotifs(dataObj);
		}
	);
}

$(".filterServiceMotif").on("change", function(){

	var serID = $(this).val();

	if (serID != 0 && serID > 0){
		getAllServicesMotifsByServiceID(serID);
	}else{
		getAllServicesMotifs();
	}

});