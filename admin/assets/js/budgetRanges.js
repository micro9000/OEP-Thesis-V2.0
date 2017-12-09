
$(".btnAddNewBudgetRange").on("click", function(){
	var budgetRange = $(".budgetRange").val();

	if(budgetRange != ""){
		$.post(
			"controller/insertNewBudgetRange.php",
			{
				"budgetRange" : budgetRange
			},
			function(data){
				if (data == "TRUE"){
					$(".budgetRangeMsg").html("Inserted");
					$(".budgetRange").val("");
					getAllBudgetRanges();
				}
			}
		);
	}
})

$(document).ready(function(){
	getAllBudgetRanges();
})

function getAllBudgetRanges(){
	$.post(
		"controller/getAllBudgetRanges.php",
		function(data){
			displayBudgetRanges(data);
		}
	);
}

function displayBudgetRanges(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var budgets = "";

	for(var i=0; i<dataLen; i++){
		budgets += "<tr>";
		budgets += "<td>"+ dataObj[i].budgetRange +"</td>";
		budgets += "<td><input type='submit' class='btnDeleteBudgetRange' value='Delete' id='"+ dataObj[i].id +"'></td>";
		budgets += "</tr>";
	}

	$(".budgetList").html(budgets);
}

$(document).on("click", ".btnDeleteBudgetRange", function(){
	var budgetID = $(this).attr("id");

	var r = confirm("Are you sure you want to delete this budget range?");

	if(r == true){

		$.post(
			"controller/deleteBudgetRange.php",
			{
				"budgetRangeID" : budgetID
			},
			function(data){
				// console.log(data);

				if (data == "TRUE"){
					alert("Deleted");
					getAllBudgetRanges();
				}
			}
		);

	}
});