$(".recoverPassForm").on("submit", function(e){

	e.preventDefault();

	var clientEmail = $(".clientEmail").val();

	$(".emailRecMsg").html("Please wait...");

	if (clientEmail !== ""){
		$.post(
			"../controller/isEmailRegistered.php",
			{
				"email" : clientEmail
			},
			function(data){
				// console.log(data);
				var dataObj = JSON.parse(data);

				if (dataObj.done === "TRUE"){
					$(".emailRecMsg").html("Please check your email account to continue.");
				}else{
					$(".emailRecMsg").html("Email not found.");
				}

			}
		);
	}
})


$(".recoverMyPassForm").on("submit", function(e){

	e.preventDefault();

	if (tag !== "-" && email !== "-"){
		var newPass = $(".newPass").val();

		if (newPass.length <= 7){
			$(".recMsg").html("<br/>Password must be 8 or more characters <br/> including uppercase/lowercase letters <br/> at least one number and <br/> one special character (!, @, #, %, etc.)");
		}

		var strength = passwordStrength(newPass);

		if (strength[0] === 3 || strength[0] === 4){
			$(".recMsg").html("<br/>"+strength[1]);
		}else{
			$(".recMsg").html("<br/>"+strength[1]);
			return;
		}

		var confirmPass = $(".confirmPass").val();

		if (newPass !== "" && confirmPass !== ""){
			if (newPass !== confirmPass){
				$(".recMsg").html("<br/>Password doesn't match");
				return;
			}

			$(".recMsg").html("Please wait...");

			$.post(
				"../controller/updateClientPassword.php",
				{
					"newPass" : newPass,
					"confirmPass" : confirmPass,
					"tag" : tag,
					"email" : email
				},
				function(data){
					var dataObj = JSON.parse(data);

					if (dataObj.done === "TRUE"){
						$(".recMsg").html(dataObj.msg);
						window.location = "clientLogin.php";
					}
				}
			);
		}
	}
})

$(".newPass").on("keyup", function(){
	var newPass = $(this).val();

	if (newPass.length <= 7){
		$(".recMsg").html("<br/>Password must be 8 or more characters <br/> including uppercase/lowercase letters <br/> at least one number and <br/> one special character (!, @, #, %, etc.)");
	}

	if (newPass !== ""){
		var strength = passwordStrength(newPass);

		if (strength[0] === 3 || strength[0] === 4){
			$(".recMsg").html("<br/>"+strength[1]);
		}else{
			$(".recMsg").html("<br/>"+strength[1]);
			return;
		}
	}
});

$(".confirmPass").on("keyup", function(){
	var conPass = $(this).val();
	var newPass = $(".newPass").val();

	if (conPass !== "" && newPass !== ""){
		if (conPass !== newPass){
			$(".recMsg").html("<br/>Password doesn't match");
		}else{
			$(".recMsg").html("");
		}
	}
});
