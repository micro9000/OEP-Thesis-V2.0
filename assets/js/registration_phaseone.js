
function getClientEmail(uniqueTag){
	$.post(
		"../controller/getClientEmail.php",
		{
			"uniqueTag" : uniqueTag
		},
		function(data){
			$(".clientEmail").val(data);
		}
	);
}

$(document).ready(function(){
	if (uniqueTag != "-" && uniqueTag != "" && uniqueTag.length == 128){
		getClientEmail(uniqueTag);
	}
});


function getFormDataAndValidation(){

	if (uniqueTag != "-"){
		var clientEmail = $(".clientEmail").val();

		if (validateEmail(clientEmail) == false){
			$(".registerMsg").html("Invalid email address");
			return;
		}else{
			$(".registerMsg").html("");
		}

		var clientFullName = $(".clientFullName").val();
		if (clientFullName == ""){
			$(".registerMsg").html("Fullname is required");
			return;
		}else{

			if (allLetter(clientFullName) === false){
				$(".registerMsg").html("Invalid Full name - at least 2 to 3 word name start with uppercase letter ex: Johnny Depp or Kyrie Andrew Irving");
				return;
			}

			var fullNameLen = clientFullName.length;

			if (fullNameLen < 4){
				$(".registerMsg").html("Your fullname must be at least 4 characters");
				return;
			}

			$(".registerMsg").html("");
		}

		var clientContactNo = $(".clientContactNo").val();
		if (clientContactNo == ""){
			$(".registerMsg").html("Contact no is required");
			return;
		}else{

			// if (allNumeric(clientContactNo) === false){
			// 	$(".registerMsg").html("Invalid Contact No");
			// 	return
			// }

			if (mobileNum(clientContactNo) === false){
				$(".registerMsg").html("Invalid Contact No, please follow this format (+63 or 0 + ten numbers)");
				return
			}

			$(".registerMsg").html("");
		}

		var clientPassword = $(".clientPassword").val();
		if (clientPassword == ""){
			$(".registerMsg").html("Password is required");
			return;
		}else{

			var strength = passwordStrength(clientPassword);

			if (strength[0] === 3 || strength[0] === 4){
				$(".registerMsg").html(strength[1]);
			}else{
				$(".registerMsg").html(strength[1]);
				return;
			}
			// $(".registerMsg").html("");
		}

		var clientConfirmPassword = $(".clientConfirmPassword").val();
		if (clientConfirmPassword == ""){
			$(".registerMsg").html("Password Confirmation is required");
			return;
		}else{
			$(".registerMsg").html("");
		}

		if (clientPassword != clientConfirmPassword){
			$(".registerMsg").html("Password Confirmation doesn't match Password");
			return;
		}else{
			$(".registerMsg").html("");
		}

		var data = {
			"emailAdd" : clientEmail,
			"fullName" : clientFullName,
			"contactNo" : clientContactNo,
			"password" : clientPassword,
			"confirmPass" : clientConfirmPassword,
			"regTag" : uniqueTag
		}

		return data;
	}

	return {};
}

//start HERE

$(".clientContactNo").on("keyup", function(){

	clientContactNo = $(this).val();

	if (mobileNum(clientContactNo) === false){
		$(".registerMsg").html("Invalid Contact No, please follow this format (+63 or 0 + ten numbers)");
	}else{
		$(".registerMsg").html("");
	}
});

$(".clientFullName").on("keyup", function(){

	clientFullName = $(this).val();

	if (allLetter(clientFullName) === false){
		$(".registerMsg").html("Invalid Full name - at least 2 to 3 word name start with uppercase letter ex: Johnny Depp or Kyrie Andrew Irving");
	}else{
		$(".registerMsg").html("");
	}
});

$(".clientPassword").on("keyup", function(){
	var clientPassword = $(this).val();

	var strength = passwordStrength(clientPassword);

	if (strength[0] === 3 || strength[0] === 4){
		$(".registerMsg").html("<br/>"+strength[1]);
	}else{
		$(".registerMsg").html("<br/>"+strength[1]);
		return;
	}
});

$(".clientConfirmPassword").on("keyup", function(){
	var pass = $(".clientPassword").val();
	var confirmPass = $(this).val();

	if (pass !== ""){
		if (confirmPass !== pass){
			$(".registerMsg").html("Password doesn't match");
		}else{
			$(".registerMsg").html("");
		}
	}
});

$(".clientPassword, .clientConfirmPassword").on("focus", function(){

	var msg = "<br/><p>To make your password stronger:</p>";

	msg += "<ul>";
	msg += "<li>Start with a letter</li>";
	msg += "<li>At least 8 or more characters</li>";
	msg += "<li>Add uppercase/lower letters</li>";
	msg += "<li>At least one number</li>";
	msg += "<li>One special character (!, @, #, % etc.)</li>";
	msg += "</ul>";

	$(".registerMsg").html(msg);
});

//end HERE

function clearRegInputs(){
	$(".clientEmail").val("");
	$(".clientFullName").val("");
	$(".clientContactNo").val("");
	$(".clientPassword").val("");
	$(".clientConfirmPassword").val("");
}

$(".btnInsertClientInfo").on("click", function(){
	var formData = getFormDataAndValidation();

	if (typeof formData != "undefined"){
		$.post(
			"../controller/registeredClient.php",
			formData,
			function(data){
				var dataObj = JSON.parse(data);

				if(dataObj.done == "TRUE"){
					clearRegInputs();
					window.location = "clientDashboard.php";
				}
			}
		);
	}
});
