/*-------------------------------------------------------------------------------------------------------------------------------------------------------
---------------UserPage Script--------------------*/

var userCourses = ["CM1","CM2","SQL"];//,"Excel"];
var courseProgress = [48,52,13,55];
var text = "";
//var selectionFromDash;
//var selectionFromDashNum;

for (i = 0; i < userCourses.length; i++){
	text += "<tr style=\"text-align:center\"><td><a href=\"userExams.html\" onclick=\"setFirstSelection('" + userCourses[i] + "', 'courseButton" + i + "')\">" + userCourses[i] + "</a></td><td>" + courseProgress[i] + "%</td><td id=\"demo" + (i + 1) + "\"></td></tr>";
}

document.getElementById("tableBody").innerHTML = text;
document.getElementById("registeredExamsSection").style.height = (userCourses.length)*40 + 500 + "px";

/*
function setFirstSelection(selection,number){
	selectionFromDash = selection;
	selectionFromDashNum = number;
}
*/

//function setCountdown(){
	// Set the date we're counting down to
	var countDownDate = new Date("Jan 5, 2019 15:37:25").getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get todays date and time
	  var now = new Date().getTime();

	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	  // Display the result in the element with id="demo"
	  document.getElementById("demo1").innerHTML = days + "d " + hours + "h "
	  + minutes + "m " + seconds + "s ";

	  // If the count down is finished, write some text 
	  if (distance < 0) {
		clearInterval(x);
		document.getElementById("demo1").innerHTML = "EXPIRED";
	  }
	}, 1000);
//}

