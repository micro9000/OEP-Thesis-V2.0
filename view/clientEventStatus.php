<?php session_start();
	require_once("header.php"); 
?>

<?php
	
	if (! $contentModel->isClientLoggedIn()){
		header("Location: clientLogin.php");
	}

?>

<?php require_once("navbar.php"); ?>


<div class="clientDashboard">

	<div class="container-fluid">
		<div class="eventStatus">
			<div class="dashboardTitle">
				<h3>CURRENT EVENT STATUS</h3>
				Status : <p id="eventStatus__"></p>
			</div>

			<table class="table table-bordered clientEventsTb">
				<thead>
					<tr>
						<th colspan="2" style="text-align:center">
							Event Details
						</th>
					</tr>
				</thead>
				<thead>
					<tr>
						<td>Type of Event</td>
						<td id='typeOfEvent'></td>
					</tr>

					<tr>
						<td>Motif</td>
						<td id='eventMotif'></td>
					</tr>

					<tr>
						<td>Type of Venue</td>
						<td id='typeOfVenue'></td>
					</tr>

					<tr>
						<td>Venue Address</td>
						<td id='venueAddress'></td>
					</tr>
					
					<tr>
						<td>Date</td>
						<td id='eventDate'></td>
					</tr>

					<tr>
						<td>Star time</td>
						<td id='startTime'></td>
					</tr>

					<tr>
						<td>End time</td>
						<td id='endTime'></td>
					</tr>

					<tr>
						<td>No of Guests</td>
						<td id='noOfGuests'></td>
					</tr>

					<tr>
						<td colspan="2" style="text-align:center">
							<input type="button" class="btn btn-warning btnUpdateEventDetails" value="Update Details">
						</td>
					</tr>
				</thead>
			</table>

			<div class="eventMaterials">
				<h4 class="totalMaterials">Materials </h4>
				<div class="container">
					<div class="row eventMaterialList">
					</div>

					<div class="updateBtn">
						<input type="button" class="btn btn-warning btnUpdateEventMaterials" value="Add Materials">
					</div>
					
				</div>
			</div>

			<div class="eventFoodsEntertainments">
				<h4 class="totalFoodsEnter">Foods & Entertainments</h4>
				<div class="container">
					<div class="row eventFoodsEnterList">
					</div>

					<div class="updateBtn">
						<input type="button" class="btn btn-warning btnUpdateEventFoodsEntertainment" value="Add Foods & Entertaiments">
					</div>
				</div>
			</div>

			<div class="menu">
				<h4>Menu</h4>
				<table class="table table-bordered eventSelectedMenu">
					<thead>
						<tr>
							<th colspan="2" style="text-align:center">
								<p id="setTitle"></p>
							</th>
						</tr>
					</thead>
					<thead>
						<tr>
							<td>Soup</td>
							<td id='menu_soup'></td>
						</tr>

						<tr>
							<td>Chicken</td>
							<td id='menu_chicken'></td>
						</tr>

						<tr>
							<td>Seafoods</td>
							<td id='menu_seafoods'></td>
						</tr>

						<tr>
							<td>Pork/Beef</td>
							<td id='menu_porkBeef'></td>
						</tr>

						<tr>
							<td>Vegetable</td>
							<td id='menu_vegetable'></td>
						</tr>

						<tr>
							<td>Rice</td>
							<td id='menu_rice'></td>
						</tr>

						<tr>
							<td>Salad</td>
							<td id='menu_salad'></td>
						</tr>

						<tr>
							<td>Dessert</td>
							<td id='menu_dessert'></td>
						</tr>

						<tr>
							<td>Drinks</td>
							<td id='menu_drinks'></td>
						</tr>

						<tr>
							<td colspan="2" style="text-align:center">
								<input type="button" class="btn btn-warning btnUpdateEventMenu" value="Update Menu">
							</td>
						</tr>
					</thead>
				</table>
			</div>
				
		</div>
	</div>

	<div class="container-fluid">
		<div class="eventStatus">
			<h3>PAYMENT</h3>

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
							<td id="addionalHrFee"></td>
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
							<td style="text-align:right;">Balance</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="totalBalance"></td>
						</tr>
						<tr>
							<td style="text-align:right;">Downpayment / Full payment</td>
							<td id="phpCurCode">&#8369;</td>
							<td id="downOrFullPaymentTotal"></td>
						</tr>
						<tr>
							<td style="text-align:center;" id="ifPaid" colspan="3"></td>
						</tr>
					</tbody>
				</table>
				<br/>
				<p>50% Down payment 1 day before the event.</p>

				<table class="paymentBtns">
					<tr>
						<td><div id="paypal-button"></div></td>
						<td><div id="cashOnPersonalMeeting"></div></td>
					</tr>
				</table>
				<div class="cancelEvent">
				</div>
			</div>

		
		</div>
	</div>
</div>


<script type="text/javascript" src="../assets/js/event_status.js"></script>
<?php require_once("footer.php"); ?>