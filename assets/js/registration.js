
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

$(".btnEmailRegister").on("click", function(){
	var clientEmail = $(".clientEmail").val();

	// alert(clientEmail);

	if (validateEmail(clientEmail) == true){
		$(".registerMsg").html("Please wait...");
		$.post(
			"../controller/sendEmailConfirmation.php",
			{
				"emailAdd" : clientEmail
			},
			function(data){
				console.log(data);
				var dataObj = JSON.parse(data);
				if (dataObj.done == "TRUE"){
					$(".registerMsg").html(dataObj.msg);
					$(".clientEmail").val("");
				}

				$(".registerMsg").html(dataObj.msg);
				
				setTimeout(function(){
					$(".registerMsg").html("");
				}, 5000)
			}
		);
	}else{
		$(".registerMsg").html("Invalid Email address");
	}
});