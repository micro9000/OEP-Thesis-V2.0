<?php session_start();
	require_once("model/database/Admin_Connection.php");

	$admin_con = new Admin_Connection();

	if (! $admin_con->isAdminLoggedIn()){
		header("Location: index.php");
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.auditTrail{
		border-bottom: 2px solid white;
	}
	.auditLogTb{
		width: 100%;
		margin: auto;
	}

	.auditLogTb, .auditLogTb tr th, .auditLogTb tr td{
		border: 1px solid gray;
		border-collapse: collapse;
		text-align: center;
	}

	.auditLogTb tr th{
		background-color: #133455;
		color:white;
	}

	.filterByDateTb{
		width: 30%
	}
	.filterByDateTb, .filterByDateTb tr td{
		border: 1px solid gray;
		border-collapse: collapse;
	}
</style>

<?php require_once("navbar.php"); ?>
		
	<div class="inputFlds">
		<table class="filterByDateTb">
			<tr>
				<td>Start Date</td>
				<td><input type="text" class="startDate"></td>
			</tr>
			<tr>
				<td>End Date</td>
				<td><input type="text" class="endDate"></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center">
					<input type="submit" class="btn btnFilterAuditByDate" value="Filter">
					<input type="submit" class="btn btnRefresh" value="Refresh">
				</td>
			</tr>
		</table>
	</div>

	<div class="inputFlds">
		<table class="auditLogTb">
			<thead>
				<tr>
					<th>Action</th>
					<th>User</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody class="auditLogs"></tbody>
		</table>
	</div>

	<script type="text/javascript">
		
		$(".startDate").datepicker();
		$(".endDate").datepicker();

		function displayAudits(data){
			var dataObj = JSON.parse(data);
			var dataLen = dataObj.length;

			var logs = "";

			for(var i=0; i<dataLen; i++){
				logs += "<tr>";
				logs += "<td>"+ dataObj[i].action +"</td>";
				logs += "<td>"+ dataObj[i].currUser +"</td>";
				logs += "<td>"+ dataObj[i].dateEntry +"</td>";
				logs += "</tr>";
			}

			$(".auditLogs").html(logs);
		}

		function getAllAudits(){
			$.post(
				"controller/getAuditTrail_handler.php",
				{
					"task" : "all"
				},
				function(data){
					displayAudits(data);
				}
			);
		}

		$(document).ready(function(){
			getAllAudits();
		});

		$(".btnRefresh").on("click", function(){
			getAllAudits();
		});

		$(".btnFilterAuditByDate").on("click", function(){

			var start = $(".startDate").val();
			var end = $(".endDate").val();

			if (start !== "" && end !== ""){
				$.post(
					"controller/getAuditTrail_handler.php",
					{
						"task" : "dateRange",
						"startDate" : start,
						"endDate" : end
					},
					function(data){
						displayAudits(data);
					}
				);
			}
		});
	</script>
<?php require_once("footer.php"); ?>