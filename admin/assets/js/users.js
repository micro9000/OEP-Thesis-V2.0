
$(".btnChangeUsername").on("click", function(){

	var newUsername = $(".newUsername").val();
	var curPassword = $(".curPassword_username").val();

	$.post(
		"controller/change_admin_username_password.php",
		{
			"task" : "username",
			"new_username" : newUsername,
			"current_password" : curPassword
		},
		function(data){
			if (data == "TRUE"){

				insertUserAction("Change Username");

				$(".newUsername").val("");
				$(".curPassword_username").val("");
				$(".changeUsernameMsg").html("Updated");
			}
		}
	);
});

$(".btnChangePassword").on("click", function(){

	var newPassword = $(".newPassword").val();
	var curPassword = $(".curPassword_password").val();

	$.post(
		"controller/change_admin_username_password.php",
		{
			"task" : "password",
			"new_password" : newPassword,
			"current_password_2" : curPassword
		},
		function(data){
			// console.log(data);
			if (data == "TRUE"){

				insertUserAction("Change Password");

				$(".newPassword").val("");
				$(".curPassword_password").val("");
				$(".changePasswordMsg").html("Updated");
				window.location = "logout.php";
			}
		}
	);
});

$(".btnAddNewUser").on("click", function(){

	var username = $(".username").val();
	var emailAdd = $(".emailAdd").val();
	var password = $(".password").val();
	var userType = $(".userType").val();

	if (username != "" && emailAdd != "" && password != "" && userType != ""){

		if (isNaN(userType)){
			alert("Invalid user type");
			return;
		}

		$.post(
			"controller/insert_new_user.php",
			{
				"newuser_username" : username,
				"newuser_emailadd" : emailAdd,
				"newuser_password" : password,
				"newuser_usertype" : userType
			},
			function(data){
				// console.log(data);
				var dataObj = JSON.parse(data);

				if (dataObj.done == "TRUE"){
					$(".username").val("");
					$(".emailAdd").val("");
					$(".password").val("");
					$(".userType").val("");
				}
				
				$(".addUserMsg").html(dataObj.msg);
				getAllUsers();
			}
		);
	}
});

function getAllUsers(){
	$.post(
		"controller/getUsers_handler.php",
		{
			"task" : "all"
		},
		function(data){
			// console.log(data);
			var dataObj = JSON.parse(data);
			displayUsers(dataObj);
		}
	);
}

function displayUsers(data){
	var dataLen = data.length;

	var users = "";

	for(var i=0; i<dataLen; i++){
		users += "<tr>";
		users += "<td>"+ data[i].username +"</td>";
		users += "<td>"+ data[i].email_address +"</td>";

		if(data[i].user_type == "0"){
			users += "<td>Employee</td>";
		}else{
			users += "<td>Admin</td>";
		}

		users += "<td><a href='users.php?uTag="+ data[i].tag +"'>select</a></td>";
		
		users += "</tr>";
	}

	$(".usersList").html(users);
}

function getUserByTag(tag){
	$.post(
		"controller/getUsers_handler.php",
		{
			"task" : "byTag",
			"tag" : tag
		},
		function(data){
			// console.log(data);
			var dataObj = JSON.parse(data);
			displayUsers(dataObj);
			displayUser_inputs(dataObj);
		}
	);
}

function displayUser_inputs(data){
	$(".username").val(data[0].username);
	$(".emailAdd").val(data[0].email_address);
	$(".userType").val(data[0].user_type);
}

$(document).ready(function(){
	if (uTag != 0){
		getUserByTag(uTag);
	}else{
		getAllUsers();
	}
});

$(".btnUpdateUser").on("click", function(){

	if (uTag != 0){
		var username = $(".username").val();
		var emailAdd = $(".emailAdd").val();
		var password = $(".password").val();
		var userType = $(".userType").val();

		if (username != "" && emailAdd != "" && password != "" && userType != ""){

			if (isNaN(userType)){
				alert("Invalid user type");
				return;
			}

			$.post(
				"controller/update_user.php",
				{
					"newuser_username" : username,
					"newuser_emailadd" : emailAdd,
					"newuser_password" : password,
					"newuser_usertype" : userType,
					"uTag" : uTag
				},
				function(data){
					// console.log(data);
					var dataObj = JSON.parse(data);

					if (dataObj.done == "TRUE"){
						alert(dataObj.msg);
						window.location = "users.php";
					}else{
						$(".addUserMsg").html(dataObj.msg);
					}
				}
			);
		}
	}	
});

$(".btnDeleteUser").on("click", function(){

	if (uTag != 0){
		var r = confirm("Are you sure you want to delete this user?");

		if (r == true){
			$.post(
				"controller/delete_user.php",
				{
					"uTag" : uTag
				},
				function(data){
					if (data == "TRUE"){
						alert("Deleted");
						window.location = "users.php";
					}
				}
			);
		}

	}
});