/*-------------------------------------------------------------------------------------------------------------------------------------------------------
---------------UserExams Script--------------------*/

//var courses = ["CM1","CM2","SQL"];//,"CT5","CA1"];
var allProducts = ["Course Notes","Course Videos","Past Exam Review","Study Planner","Chat Forum"];
var numCourses = courses.length;
var productStyle = ["One","Two","Three","Four","Five"];
var courseText = "";
var productText = "";
var lastIdUsed;
var accordionOpenCount = 0;

/*---------------------------------------------------------------------------------------------------------------*/
var subAccordionText = "<div class=\"container\" style=\"padding: 10px\"><div class=\"accordion-inner\" id=\"accordionExample2\"><div class=\"card\"><div class=\"card-header\" id=\"headingSix\"><h5 class=\"mb-0\"><button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseSix\" aria-expanded=\"false\" aria-controls=\"collapseSix\">Course Notes</button></h5></div><div id=\"collapseSix\" class=\"collapse\" aria-labelledby=\"headingSix\" data-parent=\"#accordionExample2\"><div class=\"card-body\">first group</div></div></div><div class=\"card\"><div class=\"card-header\" id=\"headingSeven\"><h5 class=\"mb-0\"><button class=\"btn btn-link collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseSeven\" aria-expanded=\"false\" aria-controls=\"collapseSeven\">Course Videos</button></h5></div><div id=\"collapseSeven\" class=\"collapse\" aria-labelledby=\"headingSeven\" data-parent=\"#accordionExample2\"><div class=\"card-body\">second group</div></div></div><div class=\"card\"><div class=\"card-header\" id=\"headingEight\"><h5 class=\"mb-0\"><button class=\"btn btn-link collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseEight\" aria-expanded=\"false\" aria-controls=\"collapseEight\">Past Exam Review</button></h5></div><div id=\"collapseEight\" class=\"collapse\" aria-labelledby=\"headingEight\" data-parent=\"#accordionExample2\"><div class=\"card-body\">third group</div></div></div></div>";

/*---------------------------------------------------------------------------------------------------------------*/

//var products = ["Course Notes","Course Videos"];//,"Past Exam Review","Study Planner","Chat Forum"];
//var productsNotTaken = ["Past Exam Review","Study Planner","Chat Forum"];
//var numProducts = products.length;
//var numproductsNotTaken = 5 - numProducts;
//var selectionFromDash;
//var selectionFromDashNum;


for (i = 0; i < numCourses; i++){
		courseText += "<div class=\"row\"><div class=\"col-md-4\"></div><div class=\"col-md-4\"><button type=\"button\" class=\"btn btn-outline-info\" style=\"width: 100%\" id=\"courseButton" + i + "\" onclick=\"populateContent('" + courses[i] + "', 'courseButton" + i + "', " + i + ")\">" + courses[i] + "</button></div><div class=\"col-md-4\"></div></div><div class=\"row\" style=\"height:10px\"></div>";
	}
	courseText += "<div class=\"row\" style=\"height: 50px\"></div>";
	document.getElementById("courseNames").innerHTML = courseText;

//populateContent(courses[0],'courseButton0',0);



    function populateFoundation(courseNumber){
        
        productText = "";

        if(purchasedPackages[courseNumber] == 1){
            var products = ["Course Notes","Course Videos"];//,"Past Exam Review","Study Planner","Chat Forum"];
            var productsNotTaken = ["Past Exam Review","Study Planner","Chat Forum"];    
        }
        else if(purchasedPackages[courseNumber] == 2){
            var products = ["Course Notes","Course Videos","Past Exam Review"]//,"Study Planner","Chat Forum"];
            var productsNotTaken = ["Study Planner","Chat Forum"];    
        }
        else if(purchasedPackages[courseNumber] == 3){
            var products = ["Course Notes","Course Videos","Past Exam Review","Study Planner","Chat Forum"];
            var productsNotTaken = [];    
        }

        var numProducts = products.length;
        var numproductsNotTaken = 5 - numProducts;


	        for (i = 0; i < numProducts; i++){
		        productText += "<div class=\"card\"><div class=\"card-header\" id=\"heading" + productStyle[i] + "\"><h5 class=\"mb-0\"><button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse" + productStyle[i] + "\" aria-expanded=\"false\" aria-controls=\"collapse" + productStyle[i] + "\" onclick=\"extendDiv('Settings')\">" + products[i] + "</button></h5></div><div id=\"collapse" + productStyle[i] + "\" class=\"collapse\" aria-labelledby=\"heading" + productStyle[i] + "\" data-parent=\"#accordionExample\"><div class=\"card-body\">" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br>" + productStyle[i] + " group<br></div></div></div>";
	        }

	        for (i = 0; i < numproductsNotTaken; i++){
		        productText += "<div class=\"row\" style=\"height:50px;padding-left:15px; padding-right:15px;\"><div class=\"col-md-12\" style=\"background-color: #F3F2F2; text-align: center; padding-top:10px; border-style: solid; border-width: thin; border-color: #D8D7D7\"><a href=\"userProducts.html\">Purchase " + productsNotTaken[i] + "</a></div></div>";
	        }


	        document.getElementById("accordionExample").innerHTML = productText;

    }

	/*
	if(selectionFromDash != null){
		alert('Here i am');
		populateContent(selectionFromDash, selectionFromDashNum);
		selectionFromDash = null;
		selectionFromDashNum = null;
	}
	*/

	function populateContent(course, idUsed, courseNumber){
        populateFoundation(courseNumber);
		document.getElementById("collapseOne").innerHTML = subAccordionText;
		document.getElementById("collapseTwo").innerHTML = subAccordionText;
		if(course == "CM2" || course == "CM1"){
			document.getElementById("collapseSix").innerHTML = "<embed src=\"CalcIII_Complete.pdf#page=50&toolbar=1&navpanes=1&scrollbar=1\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";//"<a href=\"CalcIII_Complete.pdf\" target=\"_blank\">CM2 Notes</a>";
		}
		else {
			document.getElementById("collapseSix").innerHTML = "this is " + course;
        }
		document.getElementById("collapseSeven").innerHTML = "<video width=\"100%\" controls><source src=\"test.mp4\"></video>";
		document.getElementById("collapseThree").innerHTML = "this is " + course;
		document.getElementById("collapseFour").innerHTML = "this is " + course;
		document.getElementById("collapseFive").innerHTML = "this is " + course;
		document.getElementById(idUsed).className = "btn btn-info";
		if (lastIdUsed == null){
			lastIdUsed = idUsed;
            console.log("null and " + idUsed);
		}
		else{
			document.getElementById(lastIdUsed).className = "btn btn-outline-info";
			lastIdUsed = idUsed;
            console.log(idUsed);
		}
}

    function extendDiv(idee){
        if(accordionOpenCount % 2 == 0){        
            document.getElementById(idee).style.height = "1000px";
            accordionOpenCount = accordionOpenCount + 1;
        }
        else{
            document.getElementById(idee).style.height = "400px";
            accordionOpenCount = accordionOpenCount + 1;
        }
    }



	






