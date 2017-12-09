
var slideIndex = 1;
// 
// Retrieving slideshow
// 

$(document).ready(function(){

	if (typeof eventID == "undefined"){
		getAllSlideShow();
		showSlides(slideIndex);
		showSlides_auto();
	}

});

function getAllSlideShow(){
	$.post(
		"../controller/getAllSlideShow.php",
		{},
		function(data){
			displaySlideshow(data);
		}
	);
}

function displaySlideshow(data){
	var dataObj = JSON.parse(data);
	var dataLen = dataObj.length;

	// console.log(dataObj);

	var slide = "";

	for(var i=0; i<dataLen; i++){
		slide += "<div class='mySlides fadeShow'>";
			slide += "<img src='../uploads/Slideshow/"+ dataObj[i].imgServerFileName +"' style='width:100%'>";
			slide += "<div class='text'>";
				slide += "<h3>"+ dataObj[i].firstTitle +"</h3>";
				slide += "<h6>"+ dataObj[i].secondTitle +"</h6>";
				slide += "<div class='container'>";
					slide += "<div class='row'>";
						slide += "<div class='col-lg-3 col-md-3 col-sm-12'></div>";

						slide += "<div class='col-lg-6 col-md-6 col-sm-12'>";
							slide += "<p class='pramis-bola-to'>";
							slide += dataObj[i].content;
							slide += "</p>";
						slide += "</div>";

						slide += "<div class='col-lg-3 col-md-3 col-sm-12'></div>";
					slide += "</div>";
				slide += "</div>";
				slide += "<button class='getInTouch'><a href='#'>GET IN TOUCH</a></button>";
			slide += "</div>";
		slide += "</div>";
	}

	slide += "<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>";
	slide += "<a class='next' onclick='plusSlides(1)'>&#10095;</a>";

	$(".slideshow-data").html(slide);
}

$(document).on("click", ".getInTouch", function(){
	window.location = "clientRegistration.php";
});

function showSlides_auto() {
	var i;
	var slides = $(".mySlides");//document.getElementsByClassName("mySlides");

	var dots = document.getElementsByClassName("dot");
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";  
	}

	slideIndex++;

	if (slideIndex > slides.length) {slideIndex = 1}    

	for (i = 0; i < dots.length; i++) {
	 	dots[i].className = dots[i].className.replace(" active", "");
	}
	
	// slides[slideIndex-1].style.display = "block"; 
	$(".mySlides:eq("+ parseInt(slideIndex-1) +")").css("display", "block");
	dots[slideIndex-1].className += " active";
	setTimeout(showSlides_auto, 5000); // Change image every 2 seconds
}


function showSlides(n) {
	setTimeout(function(){

		var i;
		// var slides = document.getElementsByClassName("mySlides");
		var slides = $(".mySlides");
		var dots = document.getElementsByClassName("dot");
		if (n > slides.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
		    slides[i].style.display = "none";  
		}
		for (i = 0; i < dots.length; i++) {
		    dots[i].className = dots[i].className.replace(" active", "");
		}
		$(".mySlides:eq("+ parseInt(slideIndex-1) +")").css("display", "block");
		// slides[slideIndex-1].style.display = "block";  
		dots[slideIndex-1].className += " active";

	}, 200);
}


function plusSlides(n) {
	showSlides(slideIndex += n);
}

function currentSlide(n) {
	showSlides(slideIndex = n);
}


