
function getAllInquiries(){
	$.post(
		"controller/getAllInquiries.php",
		{
			"task" : "all"
		},
		function(data){
			// console.log(data);
			displayInquiries(data);
		}
	);
}

function displayInquiries(data){
	
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;
	
	//console.log(dataObj[0].event);
	
	var inquiries = "";

	for(var i=0; i<dataLen; i++){
		inquiries += "<tr>";
		inquiries += "<td>"+ dataObj[i].email +"</td>";
		inquiries += "<td>"+ dataObj[i].name +"</td>";
		inquiries += "<td>"+ dataObj[i].contactNo +"</td>";
		inquiries += "<td>"+ dataObj[i].event +"</td>";
		inquiries += "<td>"+ dataObj[i].venue +"</td>";
		
		if (dataObj[i].venueAddress !== "none")
			inquiries += "<td>"+ dataObj[i].venueAddress +"</td>";
		else
			inquiries += "<td></td>";
		
		inquiries += "<td>"+ dataObj[i].noOfGuests +"</td>";
		inquiries += "<td>"+ dataObj[i].dateInq +"</td>";
		inquiries += "<td><a href='inquiries.php?inqID="+ dataObj[i].id +"'>view</a></td>";
		inquiries += "</tr>";
	}

	$(".inquiriesList").html(inquiries);
}

function getInquiryBYID(id){
	$.post(
		"controller/getAllInquiries.php",
		{
			"task" : "byID",
			"inqID" : id
		},
		function(data){
			displayInquiry(data);
			displayInquiries(data);
		}
	);
}

function displayInquiry(data){
	var dataObj = JSON.parse(data);
	$(".inquiry").html(dataObj[0].inquiry);
}

$(document).ready(function(){

	if (inqID != 0 && inqID > 0){
		getInquiryBYID(inqID);
	}else{
		getAllInquiries();
	}
	
})

$(".btnDeleteInquiry").on('click', function(){
	
	var inquiryID = $(this).attr("id");
	
	if (inquiryID > 0) {
			
		var r = confirm("Continue?");
		
		if (r === true){
			$.post(
				"controller/deleteInquiry.php",
				{
					"inquiryID" : inquiryID
				},
				function(data){
					if (data === "TRUE"){
						alert("Deleted");
						window.location = "inquiries.php";
					}
				}
			);

		}
		
		
	}
	
	
});