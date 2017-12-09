
$(".btnUploadSlideshow").on("click", function(){
	uploadSlideshow();
});

function uploadSlideshow(){
	var formData = getFormData();

	 var request = $.ajax({
        url: 'controller/insert_new_slideshow.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false
    });

    request.done(function(data){
		console.log(data);
    	var dataObj = JSON.parse(data);

    	console.log(dataObj);

    	if (dataObj['done'] == "TRUE"){

    		insertUserAction("Upload new slidehow ( "+ $(".firstTitle").val() +" )");

    		clearInputs();
    		getAllSlideshow();

    	}
    	$(".inputMsg").html(dataObj.msg);
    });
}

function getFormData(){
	var title_first = $(".firstTitle").val();
	var title_second = $(".secondTitle").val();
	var slideContent = $(".slideShowContent").val();

	var formData = new FormData();

	if (title_first != "" && title_second != "" && slideContent != ""){

		formData.append("title_first", title_first);
		formData.append("title_second", title_second);
		formData.append("slideContent", slideContent);

		formData.append("slideshow_img", $(".slideshowImage")[0].files[0]);

	}

	return formData;
}

function clearInputs(){
	$(".firstTitle").val("");
	$(".secondTitle").val("");
	$(".slideShowContent").val("");
	$(".slideshowImage").val("");
}

$(document).ready(function(){

	if (slideID != 0 && slideID > 0){
		getSlideshowByID(slideID)
	}else{
		getAllSlideshow();
	}
})

function getAllSlideshow(){
	$.post(
		"controller/getSlideShow_handler.php",
		{
			"task" : "all"
		},
		function(data){
			displaySlideshows(data);
		}
	);
}

function getSlideshowByID(id){
	$.post(
		"controller/getSlideShow_handler.php",
		{
			"task" : "byID",
			"slideID" : id
		},
		function(data){
			displaySlideshows(data);
			displaySlideshows_inputs(data);
		}
	);
}

function displaySlideshows(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	var slideshow = "";
	for(var i=0; i<dataLen; i++){
		slideshow += "<tr>";
		slideshow += "<td>"+ dataObj[i].firstTitle +"</td>";
		slideshow += "<td>"+ dataObj[i].secondTitle +"</td>";
		slideshow += "<td>"+ dataObj[i].content +"</td>";
		slideshow += "<td><a href='slideshow.php?slideID="+ dataObj[i].id +"'>view</a></td>";
		slideshow += "</tr>";
	}

	$(".slidehoswList").html(slideshow);
}

function displaySlideshows_inputs(data){
	var dataObj = JSON.parse(data);
	$(".firstTitle").val(dataObj[0].firstTitle);
	$(".secondTitle").val(dataObj[0].secondTitle);
	$(".slideShowContent").val(dataObj[0].content);

	$(".slideImage").html("<img src='../uploads/Slideshow/"+ dataObj[0].imgServerFileName +"'>");
}

function updateSlideshow(slideID){
	var formData = getFormData();

	formData.append("slideID", slideID);

	var request = $.ajax({
        url: 'controller/update_slideshow.php',
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false
    });

    request.done(function(data){
    	var dataObj = JSON.parse(data);

    	console.log(dataObj);

    	if (dataObj['done'] == "TRUE"){

    		insertUserAction("Update slidehow ( "+ $(".firstTitle").val() +" )");

    		clearInputs();
    		getSlideshowByID(slideID);
    	}
    	$(".inputMsg").html(dataObj.msg);
    });
}

$(".btnUpdateSlideshow").on("click", function(){
	if (slideID != 0 && slideID > 0){
		updateSlideshow(slideID);
	}
});

$(".btnDeleteSlideshow").on("click", function(){
	if (slideID != 0 && slideID > 0){
		var r = confirm("Are you sure you want to delete this slideshow");

		if (r == true){
			$.post(
				"controller/delete_slideshow.php",
				{
					"slideId" : slideID
				},
				function(data){
					var dataObj = JSON.parse(data);

					if (dataObj.done == "TRUE"){

						insertUserAction("Delete slidehow ( "+ $(".firstTitle").val() +" )");

						setTimeout(function(){
							alert(dataObj.msg);
							window.location = "slideshow.php";
						}, 500)
					}else{
						alert(dataObj.msg);
					}
				}
			);
		}
	}
})
