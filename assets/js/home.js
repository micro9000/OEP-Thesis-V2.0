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


	//
	//
	//
	// 	Displaying Monthly calendar here: -------
	// #############################################
	//
	//

	var selectedDates = [];

	function getAllSelecteDates(onLoad){
		$.post(
			"../controller/getAllSelectedDates.php",
			function(data){
				console.log(data);
				var dataObj = JSON.parse(data);
				var dataLen = dataObj.length;

				for(var i=0; i<dataLen; i++){
					selectedDates.push(dataObj[i]);
					// console.log(dataObj[i]);
				}

				// setselectedDates(selectedDates);
				// console.log(selectedDates);

				if (onLoad == true){
					var date = new Date();
				    var year = date.getFullYear();
				    var monthNum = date.getMonth(); // debuging here: just add value 0-Jan 11-Dec
				    var dateNum = date.getDate();

					displayAvailableDates(year, monthNum, dateNum);
				}

			}
		);
	}

	function checkIfDateIsSelected(selectedDate){

		// console.log(selectedDates);

		var selectedDateLen = selectedDates.length;

		var tempDate = {};

		for(var i=0; i<selectedDateLen; i++){

			tempDate = selectedDates[i];

			// console.log(tempDate.eventDate);
			// console.log(tempDate.count);

			if (tempDate.eventDate == selectedDate){
				if (tempDate.count == "2"){
					return true;
				}
			}
		}

		return false;
	}


	function displayAvailableDates(year, monthNum, dateNum){


		// console.log(selectedDates.length);

		var months = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE",
	            "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];

		var monthsDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

		var days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];


	    var getFirstDay = new Date(year, monthNum, 1);
	    var firstDay = getFirstDay.getDay();

	    if(Number.isInteger(year / 4)){ // leap years
	        //numDays = 366;
	        monthsDays[1] = 29
	    }

	    var monthNow = months[monthNum];
	    var monthsDaysNum = monthsDays[monthNum];

	    var monthViewTb = "";

	    $(".monthLabel").html(monthNow +" "+ year);
	    monthViewTb += "<table class='monthViewTb'>";

	    // Day title
	    monthViewTb += "<tr>";
	    for(var i=0; i < days.length; i++){
	        monthViewTb += "<th>"+ days[i] +"</th>";
	    }
	    monthViewTb += "</tr>";

	    // Start here
	    var count = 0

	    // Adjust the first day
	    if (firstDay > 0){
	        monthViewTb += "<tr>";
	        for(var i=0; i < monthsDaysNum; i++){
	            if (i < firstDay){
	                monthViewTb += "<td></td>";

	                count += 1;
	            }
	        }
	    }

	    var dayCount = 0;

	    for(var i=firstDay + 1; i <= monthsDaysNum + firstDay; i++){
	        dayCount = i - firstDay;

	        if (i >= firstDay){

	            if (Number.isInteger(count / 7)){
	                monthViewTb += "</tr>";
	                monthViewTb += "<tr>";
	            }

	            var actualDayCountStr = "";
	            var actualmonthNumStr = "";

	  			var dayCountStr = dayCount.toString();
	  			var dayCountStrLen = dayCountStr.length;

	  			var actualmonthNum = parseInt(monthNum + 1);
	  			var monthNumStr = actualmonthNum.toString();
	  			var monthNumStrLen = monthNumStr.length;

	  			if (dayCountStrLen == 1){
	  				actualDayCountStr = "0"+ dayCount;
	  			}else{
	  				actualDayCountStr = ""+ dayCount;
	  			}

	  			if (monthNumStrLen == 1){
	  				actualmonthNumStr = "0" + parseInt(monthNum + 1);
	  			}else{
	  				actualmonthNumStr = "" + parseInt(monthNum + 1);
	  			}

	  			var monthDate = year +"-"+ actualmonthNumStr +"-"+ actualDayCountStr;

	  			// console.log(monthDate);

	            var isSelected = checkIfDateIsSelected(monthDate);

	            if (dayCount == dateNum){// current Date

	                if (isSelected == true){
	                	monthViewTb += "<td class='dayActive selecteDate'> ";
		                monthViewTb += dayCount;
		                monthViewTb += "</td>";
		            }else{
		                monthViewTb += "<td class='dayActive'> ";
		                monthViewTb += dayCount;
		                monthViewTb += "</td>";
		            }

	            }else{
		        	if (isSelected == true){
		        		monthViewTb += "<td class='selecteDate'> ";
		                monthViewTb += dayCount;
		                monthViewTb += "</td>";
		        	}else{
		        		monthViewTb += "<td> ";
		                monthViewTb += dayCount;
		                monthViewTb += "</td>";
		        	}

	            }

	            // console.log( monthDate +" - " + isSelected);

	            count += 1;
	        }
	    }

	    monthViewTb += "</table>";

	    $(".calView").html(monthViewTb);
	}

	$(document).ready(function(){
		getAllSelecteDates(true);

		setInterval(function(){
			getAllSelecteDates(false);
		}, 10000);
	});


	var dateObj = new Date();
	var year_btnPrevNext = dateObj.getFullYear();
	var monthNum_btnPrevNext = dateObj.getMonth(); // debuging here: just add value 0-Jan 11-Dec
	var dateNum_btnPrevNext = dateObj.getDate();

	$(".btnNext").on("click", function(){

		getAllSelecteDates(false);

		monthNum_btnPrevNext += 1;

		if (monthNum_btnPrevNext > 11){
			year_btnPrevNext += 1;
			monthNum_btnPrevNext -= 12;
		}

		// console.log(year_btnPrevNext +"-"+ monthNum_btnPrevNext +"-"+ dateNum_btnPrevNext);

		displayAvailableDates(year_btnPrevNext, monthNum_btnPrevNext, dateNum_btnPrevNext);
	})

	$(".btnPrev").on("click", function(){

		getAllSelecteDates(false);

		monthNum_btnPrevNext -= 1;

		if (monthNum_btnPrevNext < 0){
			year_btnPrevNext -= 1;
			monthNum_btnPrevNext += 12;
		}

		// console.log(year_btnPrevNext +"-"+ monthNum_btnPrevNext +"-"+ dateNum_btnPrevNext);
		displayAvailableDates(year_btnPrevNext, monthNum_btnPrevNext, dateNum_btnPrevNext);
	});

	// $(document).delegate(".monthViewTb tr td", "mouseover", function(e){
	// 	if (e.type === "mouseover"){
	// 		console.log("YES");
	// 	}
	// });

	$(".monthViewTb tr td").hover(function(){
		alert("HI");
	});
