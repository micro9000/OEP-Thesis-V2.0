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
		var confirmPass = $(".confirmPass").val();

		if (newPass !== "" && confirmPass !== ""){
			if (newPass !== confirmPass){
				$(".recMsg").html("Password does not match the confirm password");
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
					}
				}
			);
		}
	}



})
