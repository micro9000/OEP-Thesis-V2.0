function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function getValidEmailPass(){
	var clientEmail = $(".clientEmail").val();
	var clientPassword = $(".clientPassword").val();

	if (validateEmail(clientEmail) === false){
		$(".loginMsg").html("Invalid email address");
		return;
	}else{
		$(".loginMsg").html("");
	}

	var data = {
		"emailAdd" : clientEmail,
		"password" : clientPassword
	}

	return data;
}

$(document).ready(function(){
	$(".clientLoginForm").submit(function(e){
		e.preventDefault();

		var emailPass = getValidEmailPass();

		if (typeof emailPass != "undefined"){
			$.post(
				"../controller/clientLogin.php",
				emailPass,
				function(data){
					console.log(data);
					var dataObj = JSON.parse(data);

					if(dataObj.done == "TRUE"){
						window.location = "clientDashboard.php";
					}else{
						$(".loginMsg").html(dataObj.msg);
					}
				}
			);
		}
	})
})
