
function getAllClients(){
	$.post(
		"controller/getRegisteredClients_handler.php",
		{
			"task" : "all"
		},
		function(data){
			displayClients(data);
		}
	);
}

$(".btnSearchClientByDaten").on("click", function(){
	var startDate = $(".startDate").val();
	var endDate = $(".endDate").val();

	$.post(
		"controller/getRegisteredClients_handler.php",
		{
			"task" : "dateReg",
			"startDate" : startDate,
			"endDate" : endDate
		},
		function(data){
			displayClients(data);
		}
	);
})

$(".searchClientTxt").on("keyup", function(){
	var search = $(this).val();

	$.post(
		"controller/getRegisteredClients_handler.php",
		{
			"task" : "search",
			"searchStr" : search
		},
		function(data){
			displayClients(data);
		}
	);
})

function displayClients(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var clients = "";

	for(var i=0; i<dataLen; i++){
		clients += "<tr>";
		clients += "<td>"+ dataObj[i].email +"</td>";
		clients += "<td>"+ dataObj[i].fullName +"</td>";
		clients += "<td>"+ dataObj[i].contactNo +"</td>";
		clients += "<td>"+ dataObj[i].dateReg +"</td>";
		clients += "</tr>";
	}

	$(".clientList").html(clients);
}

$(document).ready(function(){
	getAllClients();
})