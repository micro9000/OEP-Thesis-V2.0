function insertUserAction(action){
	$.post(
		"controller/insertUserAction.php",
		{
			"action" : action
		},
		function(data){
			console.log(data);
		}
	);
}