	$(window).scroll(textDisplay);

	function textDisplay(){
		if ($(window).width() > 850){
			$(".commitments").css("display", "none");
			$(".services-section").css("background-color", "#f8f8fa");

			var s = $(this).scrollTop();

			if (s > 300){
				$(".text").fadeOut(500);

				// $(".nav").css("background-color", "#f2f2f2");
				// $(".main").css("position", "static");
			}else{
				$(".text").fadeIn(500);
				// $(".nav").css("background-color", "white");
			}
		}
		
	}

	$(window).resize(function(){
		if ($(this).width() < 850){
			$(".commitments").css("display", "block");
			$(".services-section").css("background-color", "white");
			$(".text").css("display", "none");
		}else{
			$(window).scroll(textDisplay);
		}
	});