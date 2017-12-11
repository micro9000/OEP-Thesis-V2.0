
$(".clientEmail").on("keyup", function(){
	var email = $(this).val();

	if (validateEmail(email) === false){
		$(".emailErr").html("Invalid email address");
	}else{
		$(".emailErr").html("");
	}
});

$(".clientFullName").on("keyup", function(){

	clientFullName = $(this).val();

	if (clientFullName !== ""){
		if (allLetter(clientFullName) === false){
			$(".fullNameErr").html("Invalid Full name - at least 2 to 3 word name start with uppercase letter ex: Johnny Depp or Kyrie Andrew Irving");
		}else{
			$(".fullNameErr").html("");
		}
	}else{
		$(".fullNameErr").html("");
	}
});


$(".clientContactNo").on("keyup", function(){

	clientContactNo = $(this).val();

	if (clientContactNo !== ""){
		if (mobileNum(clientContactNo) === false){
			$(".contactNoErr").html("Invalid Contact No, please follow this format (+63 or 0 + ten numbers)");
		}else{
			$(".contactNoErr").html("");
		}
	}else{
		$(".contactNoErr").html("");
	}

});


$(".clientNewPassword").on("keyup", function(){
	var clientPassword = $(this).val();

	var strength = passwordStrength(clientPassword);

	if (strength[0] === 3 || strength[0] === 4){
		$(".clientNewPasswordErr").html("<br/>"+strength[1]);
	}else{
		$(".clientNewPasswordErr").html("<br/>"+strength[1]);
		return;
	}
});

$(".clientNewPasswordConfirm").on("keyup", function(){
	var pass = $(".clientNewPassword").val();
	var confirmPass = $(this).val();

	if (pass !== ""){
		if (confirmPass !== pass){
			$(".clientNewPasswordConfirmErr").html("Password doesn't match");
		}else{
			$(".clientNewPasswordConfirmErr").html("");
		}
	}
});

$(".btnUpdateFullName").on("click", function(){
	var clientFullName = $(".clientFullName").val();
	var clientFullNameCurPass = $(".clientFullNameCurPass").val();

	if (clientFullName !== "" && clientFullNameCurPass !== ""){
		$.post(
			"../controller/updateClientInfo_handler.php",
			{
				"task" : "updateFullname",
				"newFullName" : clientFullName,
				"curPass" : clientFullNameCurPass
			},
			function(data){
				var dataObj = JSON.parse(data);

				if (dataObj.done === "TRUE"){
					$(".fullNameErr").html(dataObj.msg);
					window.location.reload();
				}
			}
		);
	}
});

$(".btnUpdateContactNo").on("click", function(){
	var clientContactNo = $(".clientContactNo").val();
	var clientContactNoCurPass = $(".clientContactNoCurPass").val();

	if (clientContactNo !== "" && clientContactNoCurPass !== ""){
		$.post(
			"../controller/updateClientInfo_handler.php",
			{
				"task" : "updateContactNo",
				"newContactNo" : clientContactNo,
				"curPass" : clientContactNoCurPass
			},
			function(data){
				var dataObj = JSON.parse(data);

				if (dataObj.done === "TRUE"){
					$(".contactNoErr").html(dataObj.msg);
					window.location.reload();
				}
			}
		);
	}
});

$(".btnUpdatePassword").on("click", function(){
	var clientNewPassword = $(".clientNewPassword").val();
	var clientNewPasswordConfirm = $(".clientNewPasswordConfirm").val();
	var clientPassCurPass = $(".clientPassCurPass").val();

	if (clientNewPassword !== "" && clientNewPasswordConfirm !== "" && clientPassCurPass){

		if (clientNewPassword === clientNewPasswordConfirm){
			$(".clientNewPasswordConfirmErr").html("");

			$.post(
				"../controller/updateClientInfo_handler.php",
				{
					"task" : "updateClientPassword",
					"newPass" : clientNewPassword,
					"conNewPass" : clientNewPasswordConfirm,
					"curPass" : clientPassCurPass
				},
				function(data){
					// console.log(data);
					var dataObj = JSON.parse(data);

					if (dataObj.done === "TRUE"){
						$(".clientNewPasswordConfirmErr").html(dataObj.msg);
						window.location.reload();
					}
				}
			);

		}else{
			$(".clientNewPasswordConfirmErr").html("Password doesn't match");
		}

	}
});

$(".btnUpdateEmailAdd").on("click", function(){
	var clientEmail = $(".clientEmail").val();
	var clientEmailCurPass = $(".clientEmailCurPass").val();

	if (clientEmail !== "" && clientEmailCurPass !== ""){
		if (validateEmail(clientEmail) === true){

			$.post(
				"../controller/updateClientInfo_handler.php",
				{
					"task" : "updateClientEmailAddress",
					"newEmail" : clientEmail,
					"curPass" : clientEmailCurPass
				},
				function(data){
					// console.log(data);
					var dataObj = JSON.parse(data);

					if (dataObj.done === "TRUE"){
						$(".emailErr").html(dataObj.msg);
						window.location.reload();
					}
				}
			);

		}
	}

});
