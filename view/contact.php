<?php session_start(); ?>
<?php require_once("header.php"); ?>

<?php require_once("navbar.php"); ?>
<div class="main">

	<div class="client-registration-form">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<div class="registration-form">
						<div class="regFormHeader">
							<h3>Contact Us</h3>
						</div>
						<div class="regFormBody">

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="email">Email (Required)</label>
	  								<input type="text" class="form-control email inqEmail">
									<p class="ingEmailErr"></p>
								</div>

								<div class="form-group">
									<label for="name">Fullname (Required)</label>
	  								<input type="text" class="form-control name inqName" placeholder="Ex: Ollie Bonifacio">
									<p class="inqNameErr"></p>
								</div>

								<div class="form-group">
									<label for="contactNum">Contact Number (Required)</label>
	  								<input type="text" class="form-control contactNum inqContactNum" placeholder="+63 or 0 + ten numbers">
									<p class="inqContactNumErr"></p>
								</div>

								<div class="form-group">
									<label for="typeOfEvents">Type of Events (Required)</label>
	  								<select class="form-control typeOfEvents inqEvent">
	  								</select>
								</div>

								<div class="form-group">
									<label for="typeOfVenue">Type of Venue (Required)</label>
	  								<select class="form-control typeOfVenue inqVenue">
	  								</select>
								</div>

								<div class="form-group venueAddress">
									<label for="outsideVenueAddress">Venue Address (If outside)</label>
									<input type="text" class="form-control outsideVenueAddress">
								</div>

								<div class="form-group">
									<p class="noOfGuestsNotes"></p>
								</div>

								<div class="form-group">
									<label for="noOfGuest">No of Guests</label>
	  								<input type="text" class="form-control noOfGuest inqnoOfGuest">
									<p class="inqnoOfGuestErr"></p>
								</div>

								<div class="form-group">
									<label for="inquiry">Inquiry (Required)</label>
	  								<textarea class="inquiry inqInquiry"></textarea>
								</div>

								<div class="form-group">
									<p class="contactErrMsg"></p>
								</div>

								<div class="form-group">
									<button type="button" class="btn btnSendInquiry">SEND</button>
								</div>
							</div>

						</div>
						<div class="regFormFooter">

						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
				</div>
			</div>
		</div>
	</div>

</div>

<div class="loader"></div>
<script type="text/javascript" src="../assets/js/contact.js"></script>
<?php require_once("footer.php"); ?>
