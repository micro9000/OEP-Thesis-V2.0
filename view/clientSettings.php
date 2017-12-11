<?php session_start();
	require_once("header.php");

	if (! $contentModel->isClientLoggedIn()){
		header("Location: clientLogin.php");
	}

?>

<?php require_once("navbar.php"); ?>
    <div class="clientSettings">
        <div class="container-fluid">
            <div class="settingsDiv">
                <div class="row">
                    <h2>Settings</h2>

                    <div class="userInfoDiv">
        				<p>User: <?php echo isset($_SESSION['client_FullName']) ? $_SESSION['client_FullName'] : "Unkown Error"; ?></p>
        			</div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="regFormHeader">

							<div class="updateEmail">
                                <div class="form-group">
                                    <label for="clientEmail">New Email Address</label>
                                    <input type="text" class="form-control clientEmail" placeholder="Enter your new email address">
                                    <input type="password" class="form-control clientEmailCurPass" placeholder="Enter your password">
                                    <br/>
                                    <p class="emailErr"></p>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btnUpdateEmailAdd">UPDATE</button>
                                </div>
                            </div>

                            <div class="updateFullname">
                                <div class="form-group">
                                    <label for="clientFullName">Full name</label>
                                    <input type="text" class="form-control clientFullName" placeholder="ex. Johnny Depp">
                                    <input type="password" class="form-control clientFullNameCurPass" placeholder="Enter your password">
                                    <br/>
                                    <p class="fullNameErr"></p>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btnUpdateFullName">UPDATE</button>
                                </div>
                            </div>

                            <div class="updateContactNo">
                                <div class="form-group">
                                    <label for="clientFullName">Contact No</label>
                                    <input type="text" class="form-control clientContactNo" placeholder="+63 or 0 + ten numbers">
									<input type="password" class="form-control clientContactNoCurPass" placeholder="Enter your password">
                                    <br/>
                                    <p class="contactNoErr"></p>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btnUpdateContactNo">UPDATE</button>
                                </div>
                            </div>

                            <div class="updatePassword">
                                <div class="form-group">
                                    <label for="clientFullName">Password</label>
                                    <input type="password" class="form-control clientNewPassword" placeholder="Enter your new password">
                                    <p class="clientNewPasswordErr"></p>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control clientNewPasswordConfirm" placeholder="Confirm your password">
									<input type="password" class="form-control clientPassCurPass" placeholder="Enter your current password">
                                    <br/>
                                    <p class="clientNewPasswordConfirmErr"></p>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btnUpdatePassword">UPDATE</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    </div>

                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="../assets/js/clientSettings.js"></script>
<?php require_once("footer.php"); ?>
