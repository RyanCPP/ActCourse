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


var chapters = ["Chapter 1.1","Chapter 1.2","Chapter 1.3","Chapter 1.4","Chapter 1.5","Chapter 2.1","Chapter 2.2","Chapter 2.3"];
var chaptersVid = ["Chapter 1.1 Video","Chapter 1.2 Video","Chapter 1.3 Video","Chapter 2.1 Video","Chapter 2.2 Video"];
var chaptersChatForum = ["Chapter 1.1","Chapter 1.2","Chapter 1.3","Chapter 1.4","Chapter 1.5","Chapter 2.1","Chapter 2.2","Chapter 2.3"];
var chapterLengths = [5,3];
var chapterVidLengths = [3,2];
var chapterChatForumLengths = [5,3];
var preNotesText = "<div class=\"container\" style=\"padding: 15px\"><div class=\"accordion-inner\" id=\"notesAccordion\">";
var preVideosText = "<div class=\"container\" style=\"padding: 15px\"><div class=\"accordion-inner\" id=\"videosAccordion\">";
var preChatForumText = "<div class=\"container\" style=\"padding: 15px\"><div class=\"accordion-inner\" id=\"chatForumAccordion\">";
var postNotesText = "</div></div>";
var postVideosText = "</div></div>";
var postChatForumText = "</div></div>";
    
var courseNotesTextArray = [];
var courseVideosTextArray = [];
var chatForumTextArray = [];

var cumulative = 0;
for (i = 0; i < numCourses; i++){
    courseNotesTextArray[i] = preNotesText;
    for (j = 0; j < chapterLengths[i]; j++) {
        var number = j;
        var heading = chapters[cumulative + j];
        var content = " this is content " + cumulative + j;
        courseNotesTextArray[i] += "<div class=\"card\"><div class=\"card-header\" id=\"heading" + number + "\"><h5 class=\"mb-0\"><button class=\"btn btn-link collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapse" + number + "\" aria-expanded=\"false\" aria-controls=\"collapse" + number + "\">" + heading + "</button></h5></div><div id=\"collapse" + number + "\" class=\"collapse\" aria-labelledby=\"heading" + number + "\" data-parent=\"#notesAccordion\"><div class=\"card-body\">" + content + "</div></div></div>";
    }
    cumulative += chapterLengths[i];
    courseNotesTextArray[i] += postNotesText;
}


cumulative = 0;
for (i = 0; i < numCourses; i++){
    courseVideosTextArray[i] = preVideosText;
    for (j = 0; j < chapterVidLengths[i]; j++) {
        var number = j;
        var heading = chaptersVid[cumulative + j];
        var content = " this is content " + cumulative + j;
        courseVideosTextArray[i] += "<div class=\"card\"><div class=\"card-header\" id=\"headingVid" + number + "\"><h5 class=\"mb-0\"><button class=\"btn btn-link collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseVid" + number + "\" aria-expanded=\"false\" aria-controls=\"collapseVid" + number + "\">" + heading + "</button></h5></div><div id=\"collapseVid" + number + "\" class=\"collapse\" aria-labelledby=\"headingVid" + number + "\" data-parent=\"#videosAccordion\"><div class=\"card-body\">" + content + "</div></div></div>";
    }
    cumulative += chapterVidLengths[i];
    courseVideosTextArray[i] += postVideosText;
}


cumulative = 0;
for (i = 0; i < numCourses; i++){
    chatForumTextArray[i] = preChatForumText;
    for (j = 0; j < chapterChatForumLengths[i]; j++) {
        var number = j;
        var heading = chaptersChatForum[cumulative + j];
        var content = " this is content " + cumulative + j;
        chatForumTextArray[i] += "<div class=\"card\"><div class=\"card-header\" id=\"headingChatForum" + number + "\"><h5 class=\"mb-0\"><button class=\"btn btn-link collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseChatForum" + number + "\" aria-expanded=\"false\" aria-controls=\"collapseChatForum" + number + "\">" + heading + "</button></h5></div><div id=\"collapseChatForum" + number + "\" class=\"collapse\" aria-labelledby=\"headingChatForum" + number + "\" data-parent=\"#chatForumAccordion\"><div class=\"card-body\">" + content + "</div></div></div>";
    }
    cumulative += chapterChatForumLengths[i];
    chatForumTextArray[i] += postChatForumText;
}
  

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

populateContent(courses[0],'courseButton0',0);



    function populateFoundation(courseNumber){
        
        productText = "";

        if(purchasedPackages[courseNumber] == 1){
            var products = ["Course Notes","Course Videos"];//,"Past Exam Review","Study Planner","Chat Forum"];
            var productsNotTaken = ["Past Exam Review","Study Planner","Chat Forum"];    
        }
        else if(purchasedPackages[courseNumber] == 2){
            var products = ["Course Notes","Course Videos","Past Exam Review"]//,"Study Planner","Chat Forum"];
            //var products = ["Course Notes","Study Planner","Past Exam Review"]//,"Study Planner","Chat Forum"];
            //var productsNotTaken = ["Course Videos","Chat Forum"];
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
		        productText += "<div class=\"row\" style=\"height:50px;padding-left:15px; padding-right:15px;\"><div class=\"col-md-12\" style=\"background-color: #F3F2F2; text-align: center; padding-top:10px; border-style: solid; border-width: thin; border-color: #D8D7D7\"><a href=\"userProducts.php\">Purchase " + productsNotTaken[i] + "</a></div></div>";
	        }


	        document.getElementById("accordionExample").innerHTML = productText;

    }

	

	function populateContent(course, idUsed, courseNumber){
        populateFoundation(courseNumber);
		document.getElementById("collapseOne").innerHTML = courseNotesTextArray[courseNumber];
		document.getElementById("collapseTwo").innerHTML = courseVideosTextArray[courseNumber];
        document.getElementById("collapseFive").innerHTML = chatForumTextArray[courseNumber];
		/*if(course == "CM2" || course == "CM1"){
			document.getElementById("collapseSix").innerHTML = "<embed src=\"CalcIII_Complete.pdf#page=50&toolbar=1&navpanes=1&scrollbar=1\" type=\"application/pdf\" width=\"100%\" height=\"600px\">";//"<a href=\"CalcIII_Complete.pdf\" target=\"_blank\">CM2 Notes</a>";
		}
		else {
			document.getElementById("collapseSix").innerHTML = "this is " + course;
        }
		document.getElementById("collapseSeven").innerHTML = "<video width=\"100%\" controls><source src=\"test.mp4\"></video>";*/
		document.getElementById("collapseThree").innerHTML = "this is " + course;
		document.getElementById("collapseFour").innerHTML = "this is " + course;
		
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



	






