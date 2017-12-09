$(".loginForm").on("submit", function(e){
	e.preventDefault();

	if ($(".userName").val() != "" && $(".password").val() != ""){
		$.post(
			"controller/admin_login.php",
			{
				"username" : $(".userName").val(),
				"password" : $(".password").val()
			}, 
			function(data){
				
				var dataObj = JSON.parse(data);

				if(dataObj['done'] == "TRUE"){

					insertUserAction("Logged in");

					setTimeout(function(){
						window.location = "main.php";
					}, 500);
				}else{
					$(".loginMsg").html(dataObj.msg);
				}
			}
		);
	}
})