<?php session_start();
	require_once("model/Content_Model.php");

	$contentObj = new Content_Model();

	if (! $contentObj->isAdminLoggedIn()){
		header("Location: index.php");
	}

	$eventStatus = 0;
	if (isset($_GET['eventID'])){
		$eventStatus = $contentObj->getEventStatus($_GET['eventID']);
	}
?>

<?php require_once("header.php"); ?>

<style type="text/css">
	.homePage{
		border-bottom: 2px solid white;
	}
</style>

<?php require_once("navbar.php"); ?>
	
	<div class="inputFlds">
		<div class="inputFlds_header">
			<h4>Details</h4>
		</div>
		<div class="inputFlds_body">

			<table class="clientInfoTb">
				<thead>
					<tr>
						<th colspan="2" style="text-align:center">Client Info</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Fullname</td>
						<td id='client_fullname'></td>
					</tr>

					<tr>
						<td>Email</td>
						<td id='client_email'></td>
					</tr>

					<tr>
						<td>Contact No</td>
						<td id='client_contactNo'></td>
					</tr>

					<tr>
						<td>Date registration</td>
						<td id='client_dateReg'></td>
					</tr>
				</tbody>
			</table>

			<table class="newEventsTb">
				<thead>
					<tr>
						<th>Type of Event</th>
						<th>Motif</th>
						<th>Type of Venue</th>
						<th>Vnue Address</th>
						<th>Date</th>
						<th>Start time</th>
						<th>End time</th>
						<th>No of Guests</th>
						<th>Entry Date</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody class="newEventsList"></tbody>
			</table>

			<div class="eventMaterials">
				<h4>Materials</h4>
				<div class="container">
					<div class="row eventMaterialList">
					</div>
				</div>
			</div>

			<div class="eventFoodsEntertainments">
				<h4>Foods & Entertainments</h4>
				<div class="container">
					<div class="row eventFoodsEnterList">
					</div>
				</div>
			</div>

			<div class="eventMenu">
				<h4>Menu</h4>
				<table class="menuListTb">
					<thead>
						<tr>
							<th colspan="2" style="text-align:center" id="menu_setTitle"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class='menuItem'>Soup</td>
							<td id="menu_Soup"></td>
						</tr>

						<tr>
							<td class='menuItem'>Chicken</td>
							<td id="menu_Chicken"></td>
						</tr>

						<tr>
							<td>Seafoods</td>
							<td id="menu_Seafoods"></td>
						</tr>

						<tr>
							<td class='menuItem'>Pork/Beef</td>
							<td id="menu_PorkBeef"></td>
						</tr>

						<tr>
							<td class='menuItem'>Vegetable</td>
							<td id="menu_Vegetable"></td>
						</tr>

						<tr>
							<td class='menuItem'>Rice</td>
							<td id="menu_Rice"></td>
						</tr>

						<tr>
							<td class='menuItem'>Salad</td>
							<td id="menu_Salad"></td>
						</tr>

						<tr>
							<td class='menuItem'>Dessert</td>
							<td id="menu_Dessert"></td>
						</tr>

						<tr>
							<td class='menuItem'>Drinks</td>
							<td id="menu_Drinks"></td>
						</tr>
					</tbody>
				</table>

				<div class="btns">
					<h4>Change event status</h4>

					<?php if ($eventStatus == 1): ?>
						<input type="submit" class="btn btnChangeEventStatus" id='2' value="Approved" />
					<?php elseif($eventStatus == 2): ?>
						<input type="submit" class="btn btnChangeEventStatus" id='3' value="On-going preparation" />
					<?php elseif($eventStatus == 3): ?>
						<input type="submit" class="btn btnChangeEventStatus" id='4' value="Event On-going" />
					<?php elseif($eventStatus == 4): ?>
						<input type="submit" class="btn btnChangeEventStatus" id='5' value="DONE" />
					<?php elseif($eventStatus == 5): ?>
						<h4>Done</h4>
					<?php else: ?>
						<h4>Error</h4>
					<?php endif; ?>

					<input type="submit" class="btn btnCancelEvent" value="CANCEL" />
					<br/>
					<p id="apprErrMsg"></p>
				</div>
			</div>

		</div>
	</div>

	<div class="inputFlds computationFlds">
		<div class="inputFlds_header">
			<h4>Payment</h4>
		</div>
		<div class="inputFlds_body">
			<div class="computation">
				<table class="computationTb">
					<thead>
						<tr>
							<th colspan="2" style="text-align:center">Computation</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Reservation Fee: </td>
							<td id="phpCurCode">&#8369;</td>
							<td id="reservationFee">1000</td>
						</tr>
						<tr>
							<td>Additional Hour Fee: </td>
							<td id="phpCurCode">&#8369;</td>
							<td id="additionalHrFee"></td>
						</tr>
						<tr>
							<td>Materials Total: </td>
							<td id="phpCurCode">&#8369;</td>
							<td id="materialsTotal"></td>
						</tr>
						<tr>
							<td>Foods & Entertainments Total</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="foodsEnterTotal"></td>
						</tr>
						<tr>
							<td>Menu Fee (No of Guest * Menu Price)</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="menuFeeTotal"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Total</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="totalComputation"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Downpayment/Payment Total</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="downpaymentOrPaymentTotal"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Balance</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="balance"></td>
						</tr>
					</tbody>
				</table>

				<table class="downpaymentInputFlds">
					<tr>
						<td>Enter Downpayment / Fullpayment</td>
						<td>
							<input type="text" class="downpayment">
						</td>
						<td>
							<input type="submit" class="btn btnEnterDownpayment" value="Submit">
						</td>
					</tr>
				</table>
			</div>

			<div class="downpaymentLog">
				<table class="downpaymentLogTb">
					<thead>
						<tr>
							<th colspan="2">Payment Logs</th>
						</tr>
						<tr>
							<th>Amount</th>
							<th>Date/Time</th>
						</tr>
					</thead>
					<tbody class="paymentLogs"></tbody>
				</table>
			</div>

			<div style="clear:both"></div>
		</div>
	</div>

<script type="text/javascript">
	var eventID = <?php echo isset($_GET['eventID']) ? $_GET['eventID'] : 0; ?>;
</script>
<script type="text/javascript" src="assets/js/eventDetails.js"></script>
<?php require_once("footer.php"); ?>