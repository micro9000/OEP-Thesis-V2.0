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

		<div class="eventPlanerTabs">
			<h2>Event Planner</h2>
		  	<ul class="nav nav-tabs">
		  		<li class="active"><a data-toggle="tab" href="#availableDates">Available Dates</a></li>
		    	<li><a data-toggle="tab" href="#eventDetails" class="eventDetails">Event Details</a></li>
		    	<li><a data-toggle="tab" href="#materials" class="materials">Materials</a></li>
		    	<li><a data-toggle="tab" href="#foodsEntertainment" class="foodsEntertainment">Foods & Entertainment</a></li>
		    	<li><a data-toggle="tab" href="#cateringMenus" class="cateringMenus">Catering Menus</a></li>
		    	<li class='selectedMenuSet'><a data-toggle="tab" href="#cateringMenu" class="menu_selected">Catering Menu</a></li>
		  	</ul>

		  	<div class="tab-content">

		  		<div id="availableDates" class="tab-pane fade in active">
			    	<br>
			      	<h3 style="text-align:center;">Available Dates</h3>
			      	<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

							<div class="MonthNowLabel">
								<h3 class="monthLabel"></h3>
								<input type="submit" class="btn btn-warning btnPrev" value='<<'>
								<input type="submit" class="btn btn-warning btnNext" value='>>'>
							</div>

							<div class="calView"></div>
							
							<?php echo date('g:iA', strtotime('1:00pm')); 
								//if ()
							?>
							
							<div class="legends">
								<h4>Legend</h4>
								<label for="unavailable">
									<canvas class="unavailable"></canvas>
									Not Available
								</label>
								<br/>
								<label for="available">
									<canvas class="available"></canvas>
									Available
								</label>
							</div>
						</div>
					</div>
			    </div>

			    <div id="eventDetails" class="tab-pane fade in">
			    	<br>
			      	<h3 style="text-align:center;">Event Details</h3>
			      	<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

									<div class="form-group">
										<label for="typeOfEvents">Type of Event (Required)</label>
										<select class="form-control typeOfEvents">
										</select>
									</div>

									<div class="form-group">
										<label for="serviceMotifs">Event Motif (Required)</label>
										<select class="form-control serviceMotifs">
										</select>
									</div>

									<div class="form-group">
										<label for="typeOfVenue">Type of Venue (Required)</label>
										<select class="form-control typeOfVenue">
										</select>
									</div>

									<div class="form-group">
										<p class="venueNotes"></p>
									</div>

									<div class="form-group venueAddress">
										<label for="outsideVenueAddress">Venue Address (If outside)</label>
										<input type="text" class="form-control outsideVenueAddress">
									</div>
									
									<div class="form-group">
										<label for="eventDate">Event Date (Required)</label>
										<input type="text" class="form-control eventDate">
									</div>

									<div class="form-group">
										<p class="eventDateMsg"></p>
									</div>

								</div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										
									<p>Note: Working Hours 10:00am to 07:00pm. For additional Hour/s (&#8369;500/hr)</p>

									<div class="form-group">
										<label for="eventEstimateStartTime">Estimated starting time (Required)</label>
										<!-- <input type="text" class="form-control eventEstimateStartTime"> -->
										<select class="form-control eventEstimateStartTime">
											<option value=""></option>
											<option value="10:00am">10:00am</option>
											<option value="10:30am">10:30am</option>
											<option value="11:00am">11:00am</option>
											<option value="11:30am">11:30am</option>
											<option value="12:00pm">12:00pm</option>
											<option value="12:30pm">12:30pm</option>
											<option value="1:00pm">1:00pm</option>
											<option value="1:30pm">1:30pm</option>
											<option value="2:00pm">2:00pm</option>
											<option value="2:30pm">2:30pm</option>
											<option value="3:00pm">3:00pm</option>
											<option value="3:30pm">3:30pm</option>
											<option value="4:00pm">4:00pm</option>
											<option value="4:30pm">4:30pm</option>
											<option value="5:00pm">5:00pm</option>
											<option value="5:30pm">5:30pm</option>
											<option value="6:00pm">6:00pm</option>
											<option value="6:30pm">6:30pm</option>
											<option value="7:00pm">7:00pm</option>
										</select>
									</div>

									<p class="selectDateMsg"></p>

									<div class="form-group">
										<label for="eventEstimateEndTime">Estimated ending time (Required)</label>
										<!-- <input type="text" class="form-control eventEstimateEndTime"> -->
										<select class="form-control eventEstimateEndTime">
											<option value=""></option>
											<option value="10:00am">10:00am</option>
											<option value="10:30am">10:30am</option>
											<option value="11:00am">11:00am</option>
											<option value="11:30am">11:30am</option>
											<option value="12:00pm">12:00pm</option>
											<option value="12:30pm">12:30pm</option>
											<option value="1:00pm">1:00pm</option>
											<option value="1:30pm">1:30pm</option>
											<option value="2:00pm">2:00pm</option>
											<option value="2:30pm">2:30pm</option>
											<option value="3:00pm">3:00pm</option>
											<option value="3:30pm">3:30pm</option>
											<option value="4:00pm">4:00pm</option>
											<option value="4:30pm">4:30pm</option>
											<option value="5:00pm">5:00pm</option>
											<option value="5:30pm">5:30pm</option>
											<option value="6:00pm">6:00pm</option>
											<option value="6:30pm">6:30pm</option>
											<option value="7:00pm">7:00pm</option>
											<option value="8:00pm">8:00pm</option>
											<option value="9:00pm">9:00pm</option>
											<option value="10:00pm">10:00pm</option>
											<option value="11:00pm">11:00pm</option>
											<option value="12:00am">12:00am</option>
										</select>
									</div>

									<div class="form-group">
										<label for="noOfGuests" class="noOfGuestsNotes">Number of Guests (Required)</label>
										<input type="text" class="form-control noOfGuests">
									</div>

									<div class="formFooter">

										<?php if(isset($_GET['eventID']) && isset($_GET['task']) && $_GET['task'] == "update-event-details"): ?>
											<input type="submit" class="btn btn-warning btnUpdateEventDetails" value="UPDATE"><br/>
										<?php else: ?>
											<input type="submit" class="btn btn-warning btnGotoMaterials" value="NEXT"><br/>
										<?php endif; ?>	
										
										<p class="eventDetailsMsg"></p>
									</div>
								</div>	
							</div>
						</div>
					</div>

			    </div>


			    <div id="materials" class="tab-pane fade">
			    	<br>
			      	<h3 style="text-align:center;">Materials</h3>
			      	<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

								    <table class="table table-bordered materialsTb">
									    <thead>
										    <tr>
										        <th>Materials</th>
										        <th>Choose</th>
										        <th>Change</th>
										    </tr>
									    </thead>
									    <tbody class="materialsTbList">
										</tbody>
									</table>

									<div class="formFooter">

										<?php if(isset($_GET['eventID']) && isset($_GET['task']) && $_GET['task'] == "update-event-material"): ?>
											<input type="submit" class="btn btn-warning btnUpdateEventMaterial" value="ADD"><br/>
										<?php else: ?>
											<input type="submit" class="btn btn-warning btnGotoFoodsNEntertainment" value="NEXT">
										<?php endif; ?>	

										
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="materialMotifs">Motifs</label>
										<select class="form-control materialMotifs"></select>
									</div>

									<div class="form-group">
										<div class="row motifImages">
										</div>
									</div>

									<div class="formFooter">
										<input type="submit" class="btn btn-warning btnAddMaterialToList" value="Done"><br/>
										<p class="eventDetailsMsg"></p>
									</div>
								</div>

							</div>
						</div>
					</div>  	
			    </div>
			    <div id="foodsEntertainment" class="tab-pane fade">
			    	<br>
			      	<h3 style="text-align:center;">Foods & Entertainments</h3>
			      	<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

								    <table class="table table-bordered materialsTb">
									    <thead>
										    <tr>
										        <th>Item</th>
										        <th>Choose</th>
										        <th>Change</th>
										    </tr>
									    </thead>
									    <tbody class="partnersProduct">
										</tbody>
									</table>

									<div class="formFooter">
										<?php if(isset($_GET['eventID']) && isset($_GET['task']) && $_GET['task'] == "update-event-foods-entertainment"): ?>
											<input type="submit" class="btn btn-warning btnUpdateEventFoodsEntertainments" value="ADD"><br/>
										<?php else: ?>
											<input type="submit" class="btn btn-warning btnGotoMenus" value="NEXT">
										<?php endif; ?>	

										<!-- <p class="eventDetailsMsg"></p> -->
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="eventDate">Motifs (Partner)</label>
										<select class="form-control partnersMotifs"></select>
									</div>

									<div class="form-group">
										<div class="row partnerMotifImages">
										</div>
									</div>

									<div class="formFooter">
										<input type="submit" class="btn btn-warning btnAddPartnersMotifImgs" value="Done"><br/>
										<p class="eventDetailsMsg"></p>
									</div>
								</div>

							</div>
						</div>
					</div> 
			    </div>
			    <div id="cateringMenus" class="tab-pane fade">
			    	<br>
			      	<h3 style="text-align:center;">Catering Menus</h3>
			      	<div class="row menusSetsTb">
						
					</div> 
			    </div>

			    <div id="cateringMenu" class="tab-pane fade">
			    	<br>
			    	<!-- menusSetsSelectedTb -->
			      	<div class="row ">
						<div class="col-lg-12 col-md-12">
							<table class="table table-bordered menuSetTb">
								<thead>	
									<tr>
										<th colspan='3' style='text-align:center'>
											<p class='setTitle'></p>
										</th>
									</tr>
									<tr>
										<th></th>
										<th>Item Name</th>
										<th>Change</th>
									</tr>
								</thead>
								<tbody>	
									<tr>
										<td>Soup</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedSoup" disabled="disabled">
											</div>
										</td>
										<td class="changeSoup">
										</td>
									</tr>

									<tr>
										<td>Chicken</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedChicken" disabled="disabled">
											</div>
										</td>
										<td class="changeChicken">
										</td>
									</tr>

									<tr>
										<td>Seafoods</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedSeafoods" disabled="disabled">
											</div>
										</td>
										<td class="changeSeafoods">
										</td>
									</tr>

									<tr>
										<td>Pork/Beef</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedPorkBeef" disabled="disabled">
											</div>
										</td>
										<td class="changePorkBeef">
										</td>
									</tr>

									<tr>
										<td>Vegetable</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedVegetable" disabled="disabled">
											</div>
										</td>
										<td class="changeVegetable">
										</td>
									</tr>

									<tr>
										<td>Rice</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedRice" disabled="disabled">
											</div>
										</td>
										<td class="changeRice">
										</td>
									</tr>

									<tr>
										<td>Salad</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedSalad" disabled="disabled">
											</div>
										</td>
										<td class="changeSalad">
										</td>
									</tr>

									<tr>
										<td>Dessert</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedDessert" disabled="disabled">
											</div>
										</td>
										<td class="changeDessert">
										</td>
									</tr>

									<tr>
										<td>Drinks</td>
										<td>
											<div class="form-group">
												<input type="text" class="form-control selectedDrinks" disabled="disabled">
											</div>
										</td>
										<td class="changeDrinks">
										</td>
									</tr>

								</tbody>
							</table>

							<div class="formFooter">

								<?php if(isset($_GET['eventID']) && isset($_GET['task']) && $_GET['task'] == "update-event-menu"): ?>
									<input type="submit" class="btn btn-warning btnUpdateEventMenu" value="UPDATE"><br/>
								<?php else: ?>
									<input type="submit" class="btn btn-warning btnSubmitEventPlannerDetails" value="SUBMIT"><br/>
								<?php endif; ?>	

								<p class="eventDetailsMsg"></p>
							</div>

						</div>
					</div> 
			    </div>
			 </div>
		</div>
	</div>

</div>

<script type="text/javascript" src="../assets/jquery-timepicker/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/jquery-timepicker/jquery.timepicker.css">

<script type="text/javascript" src="../assets/jquery-ui/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/jquery-ui/jquery-ui.min.css">

<script type="text/javascript">
	
	// $(".eventEstimateStartTime").timepicker().val("10:00am");
	// $(".eventEstimateEndTime").timepicker();

	$(".eventDate").datepicker({
		dateFormat: "dd-mm-yy"
	});

	$(".nav-tabs .active a").trigger("click");

	var task = "<?php echo isset($_GET['task']) ? $_GET['task'] : ''; ?>";
	var eventID = <?php echo isset($_GET['eventID']) ? $_GET['eventID'] : 0; ?>;
	
	if (task == "update-event-details"){
		$(".eventDetails").trigger("click");

	}else if(task == "update-event-material"){
		$(".materials").trigger("click");

	}else if(task == "update-event-foods-entertainment"){
		$(".foodsEntertainment").trigger("click");
		
	}else if(task == "update-event-menu"){
		$(".menu_selected").trigger("click");
		
	}

</script>
<script type="text/javascript" src="../assets/js/client_Dashboard.js"></script>
<?php require_once("footer.php"); ?>