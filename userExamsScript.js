/*-------------------------------------------------------------------------------------------------------------------------------------------------------
---------------UserExams Script--------------------*/

var courses = ["CM1","CM2","SQL"];//,"CT5","CA1"];
var products = ["Course Notes","Course Videos","Past Exam Review","Study Planner","Chat Forum"];
var productStyle = ["One","Two","Three","Four","Five"];
var numCourses = courses.length;
var numProducts = products.length;
var courseText = "";
var productText = "";
var lastIdUsed;
//var selectionFromDash;
//var selectionFromDashNum;


for (i = 0; i < numCourses; i++){
	courseText += "<div class=\"row\"><div class=\"col-md-4\"></div><div class=\"col-md-4\"><button type=\"button\" class=\"btn btn-outline-info\" style=\"width: 100%\" id=\"courseButton" + i + "\" onclick=\"populateContent('" + courses[i] + "', 'courseButton" + i + "')\">" + courses[i] + "</button></div><div class=\"col-md-4\"></div></div><div class=\"row\" style=\"height:10px\"></div>";
}
courseText += "<div class=\"row\" style=\"height: 50px\"></div>";
document.getElementById("courseNames").innerHTML = courseText;

for (i = 0; i < numProducts; i++){
	productText += "<div class=\"card\"><div class=\"card-header\" id=\"heading" + productStyle[i] + "\"><h5 class=\"mb-0\"><button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse" + productStyle[i] + "\" aria-expanded=\"false\" aria-controls=\"collapse" + productStyle[i] + "\">" + products[i] + "</button></h5></div><div id=\"collapse" + productStyle[i] + "\" class=\"collapse\" aria-labelledby=\"heading" + productStyle[i] + "\" data-parent=\"#accordionExample\"><div class=\"card-body\">" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br></div></div></div>";
}

document.getElementById("accordionExample").innerHTML = productText;

/*
if(selectionFromDash != null){
	alert('Here i am');
	populateContent(selectionFromDash, selectionFromDashNum);
	selectionFromDash = null;
	selectionFromDashNum = null;
}
*/

function populateContent(course, idUsed){
	document.getElementById("collapseOne").innerHTML = "this is " + course;
	document.getElementById("collapseTwo").innerHTML = "this is " + course;
	document.getElementById("collapseThree").innerHTML = "this is " + course;
	document.getElementById("collapseFour").innerHTML = "this is " + course;
	document.getElementById("collapseFive").innerHTML = "this is " + course;
	document.getElementById(idUsed).className = "btn btn-info";
	if (lastIdUsed == null){
		lastIdUsed = idUsed;
	}
	else{
		document.getElementById(lastIdUsed).className = "btn btn-outline-info";
		lastIdUsed = idUsed;
	}
}




