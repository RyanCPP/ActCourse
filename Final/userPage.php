<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

$sql = "select name, country, industry, receiveEmails, siteCharacter from userDetails where id = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    
    // Set parameters
    $param_id = $_SESSION["id"];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Get result
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_array($result, MYSQLI_NUM);

        $_SESSION["name"] = $row[0];
        $_SESSION["country"] = $row[1];
        $_SESSION["industry"] = $row[2];
        $_SESSION["receiveEmails"] = $row[3];
        $_SESSION["siteCharacter"] = $row[4];

    }
    else{
            // Display an error message if email doesn't exist
            //$email_err = "No account found with that email.";
    }
}
else{
        echo "Oops! Something went wrong. Please try again later.";
}


// Free result set
mysqli_free_result($result);


$result_array1 = array();
$result_array2 = array();
$result_array3 = array();
$sql = "select userExams.code, userExams.courseProgress, exams.nextExamDate from userExams left join exams on userExams.code = exams.code where userExams.id = ? and registeredIndicator = 1";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    
    // Set parameters
    $param_id = $_SESSION["id"];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Get result
        $result = mysqli_stmt_get_result($stmt);          
        
        $i = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $result_array1[$i] = $row[0];
            $result_array2[$i] = $row[1];
            $result_array3[$i] = $row[2];
            $i = $i + 1;
        }
        
        $userCourses = json_encode($result_array1);
        $userProgress = json_encode($result_array2);
        $examDates = json_encode($result_array3);

    }
    else{
            // Display an error message if email doesn't exist
    }
}
else{
        echo "Oops! Something went wrong. Please try again later.";
}

// Free result set
mysqli_free_result($result);


$sql = "select code, passedIndicator from userExams where userExams.id = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    
    // Set parameters
    $param_id = $_SESSION["id"];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Get result
        $result = mysqli_stmt_get_result($stmt);          
        
        $i = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $_SESSION[$row[0]] = $row[1];
            $i = $i + 1;
        }
        
    }
    else{
            // Display an error message if email doesn't exist
    }
}
else{
        echo "Oops! Something went wrong. Please try again later.";
}

// Free result set
mysqli_free_result($result);


// Close statement
mysqli_stmt_close($stmt);


// Close connection
mysqli_close($link);

?>

<!DOCTYPE html>

<html>
	<head>
		<title>Actuarial Exam Prep</title>
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">		
	</head>
	<body>
		
		<!-- Logo section -->
		<div class="container-fluid" style="height: 150px; width: 100%; background-color: white; text-align: center" id="top">
			<img src="logo.jpg" alt="Logo" height="150px" width="150px" style="position: center">
		</div>
	
		<header class="darker navbar-inverse" id="navbar">
			<div class="container">
				<nav class="dark navbar navbar-expand-lg navbar-light bg-light">
				  <a class="navbar-brand" href="#top">My Dashboard</a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarText">
					<ul class="navbar-nav mr-auto">
					  <li class="nav-item active" style="width: 200px; Text-align: center">
						<a class="nav-link" href="userExams.html">My Exams<span class="sr-only">(current)</span></a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link"  style="width: 200px; Text-align: center" href="userProducts.html">Products</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link"  style="width: 200px; Text-align: center" href="logout.php">Logout</a>
					  </li>
					</ul>
					<span class="navbar-text">
					  Value Your Time. Pass First Time.
					</span>
				  </div>
				</nav>
			</div>	
		</header>
		
		<div class="container-fluid" style="background-color: white; height: 500px;">
			<div class="container" style="height: 150px"><h3 style="text-align:center; padding-top: 50px; padding-bottom: 10px">Welcome, <?php echo $_SESSION["name"] ?>!</h3></div>
			<div class="container" style="height: 30px; text-align: center"><b>Associateship Progress: 50%</b></div>		<!-- the percentage stated here and below for fellowship progress must be dynamically assigned -->
			<div class="container">
				<div class="row" style="background-color: white; height:30px;">
                    <div class="col-md-1"></div>
                    <div class="col-md-1" style="text-color: gray; text-align: center;" id="cs1Progress">CS1</div> <!-- outline: 1px solid; outline-color: gray" -->
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cs2Progress">CS2</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cm1Progress">CM1</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cm2Progress">CM2</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cb1Progress">CB1</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cb2Progress">CB2</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cb3Progress">CB3</div>
					<div class="col-md-1" style="text-color: gray; text-align: center;" id="cp1Progress">CP1</div>
					<div class="col-md-1" style="text-color: gray; text-align: center" id="cp2Progress">CP2</div>
					<div class="col-md-1" style="text-color: gray; text-align: center" id="cp3Progress">CP3</div>
                    <div class="col-md-1"></div>
				</div>		
			</div>
			<div class="container" style="height: 30px"></div>
			<div class="container" style="height: 30px; text-align: center"><b>Fellowship Progress: 47%</b></div>
			<div class="container">
				<div class="row" style="background-color: white; height:30px;">
					<div class="col-md-3" style="background-color: white;"></div>
					<div class="col-md-2" style="text-color: gray; text-align: center" id="firstStProgress">ST</div>
					<div class="col-md-2" style="text-color: gray; text-align: center" id="secondStProgress">ST</div>
					<div class="col-md-2" style="text-color: gray; text-align: center" id="saProgress">SA</div>
					<div class="col-md-3" style="background-color: white;"></div>
				</div>		
			</div>
			<div class="container" style="height:100px"></div>
		</div>
		
		<div class="container-fluid" style="background-color: white; height: 400px;" id="registeredExamsSection">
			<div class="container" style="height: 50px"><h4 style="text-align:center; padding-top: 50px; padding-bottom: 10px">Registered Exams</h4></div>
				<div class="container">
					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<div class="row" style="height:50px"></div>
							<div class="row" style="background-color:white">
								<table class="table table-bordered">
								  <thead>
									<tr>
									  <th scope="col" style="text-align:center; width: 33.3%">Exam</th>
									  <th scope="col" style="text-align:center; width: 33.3%">Course Progress</th>
									  <th scope="col" style="text-align:center">Time Remaining</th>
									</tr>
								  </thead>
								  <tbody id="tableBody">
								  </tbody>
								</table>	
							</div>
						</div>
						<div class="col-md-2"></div>
					</div>	
				</div>
		</div>	
		
		<!-- Account Settings -->
		<div class="container-fluid" style="background-color: white; height: 600px;" id="Settings">
			
			<!-- Modal -->
			<div id="myModal" class="modal">
			  <div class="modal-content">
				<div class="modal-header">
				  <span class="close">&times;</span>
				  <h2>Modal Header</h2>
				</div>
				<div class="modal-body">
				  <p>Some text in the Modal Body</p>
				  <p>Some other text...</p>
				  <button>click me</button>
				</div>
				<!--<div class="modal-footer">
				  <h3>Modal Footer</h3>
				</div>-->
			  </div>

			</div>
			
			<div class="container">
				<div class="row" style="height: 100px;">
					<div class="col-md-4"></div>
					<div class="col-md-4" style="text-align:center; padding-top:10px">
						<h4>Account Settings</h4>
					</div>
					<div class="col-md-4"></div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-4">
						<div class="row">	
							<div class="col-md-12">
								<div class="row"><b><i>Username</i></b></div>
								<div class="row"><?php echo $_SESSION["name"] ?></div>
							</div>
							<!--<div class="col-md-4">
								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">Edit</button>
							</div>-->
						</div>
						<div class="row" style="height:20px"></div>
						<div class="row">	
							<div class="col-md-12">
								<div class="row"><b><i>Email Address</i></b></div>
								<div class="row"><?php echo $_SESSION["email"] ?></div>
							</div>
							<!--<div class="col-md-4">
								<button type="button" class="btn btn-secondary">Edit</button>
							</div>-->
						</div>


						<div class="row" style="height:20px"></div>
						<div class="row">	
							<div class="col-md-12">
								<div class="row"><b><i>Country</i></b></div>
								<div class="row"><?php echo $_SESSION["country"] ?></div>
							</div>
							<!--<div class="col-md-4">
								<button type="button" class="btn btn-secondary">Edit</button>
							</div>-->
						</div>
						<div class="row" style="height:20px"></div>
						<div class="row">	
							<div class="col-md-12">
								<div class="row"><b><i>Industry</i></b></div>
								<div class="row"><?php echo $_SESSION["industry"] ?></div>
							</div>
							<!--<div class="col-md-4">
								<button type="button" class="btn btn-secondary">Edit</button>
							</div>-->
						</div>
						<div class="row" style="height:20px"></div>
						<div class="row">	
							<div class="col-md-12">
								<div class="row"><b><i>Receive Email Alerts?</i></b></div>
								<div class="row"><?php if($_SESSION["receiveEmails"] == "1"){ echo "Yes";} else { echo "No";} ?></div>
							</div>
							<!--<div class="col-md-4">
								<button type="button" class="btn btn-secondary">Edit</button>
							</div>-->
						</div>
						<div class="row" style="height:70px"></div>
						<div class="row">	
							<div class="col-md-12">
								<span><button type="button" class="btn btn-secondary">Edit My Account Settings</button></span>
							</div>
						</div>
						<div class="row" style="height:20px"></div>
						<div class="row">	
							<div class="col-md-12">
								<button type="button" class="btn btn-secondary">Submit Exam Results</button>
							</div>
						</div>
					</div>
					<div class="col-md-3"></div>
					<div class="col-md-3" style="text-align:center;">
						This is where the character picture goes
					</div>
					<div class="col-md-1"></div>
				</div>	
			</div>
			
		</div>
		
		<!-- Footer -->
		<div class="container-fluid" style="background-color: powderblue; height: 500px">
			
			<div class="container" style="background-color: powderblue" id="footer">
				<footer class="pt-4 my-md-5 pt-md-5 border-top">
					<div class="row">
					  <div class="col-12 col-md">
						<img class="mb-2" src="../../assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
						<small class="d-block mb-3 text-muted">© 2017-2018</small>
					  </div>
					  <div class="col-6 col-md">
						<h5>Features</h5>
						<ul class="list-unstyled text-small">
						  <li><a class="text-muted" href="#">Cool stuff</a></li>
						  <li><a class="text-muted" href="#">Random feature</a></li>
						  <li><a class="text-muted" href="#">Team feature</a></li>
						  <li><a class="text-muted" href="#">Stuff for developers</a></li>
						  <li><a class="text-muted" href="#">Another one</a></li>
						  <li><a class="text-muted" href="#">Last time</a></li>
						</ul>
					  </div>
					  <div class="col-6 col-md">
						<h5>Resources</h5>
						<ul class="list-unstyled text-small">
						  <li><a class="text-muted" href="#">Resource</a></li>
						  <li><a class="text-muted" href="#">Resource name</a></li>
						  <li><a class="text-muted" href="#">Another resource</a></li>
						  <li><a class="text-muted" href="#">Final resource</a></li>
						</ul>
					  </div>
					  <div class="col-6 col-md">
						<h5>About</h5>
						<ul class="list-unstyled text-small">
						  <li><a class="text-muted" href="#">Team</a></li>
						  <li><a class="text-muted" href="#">Locations</a></li>
						  <li><a class="text-muted" href="#">Privacy</a></li>
						  <li><a class="text-muted" href="#">Terms</a></li>
						</ul>
					  </div>
					</div>
				 </footer>
			</div>
		</div>	
		
		<!--<script src="modalScript.js"></script>-->
		<script src="navbarScript.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src="userExamsScript.js"></script>
		<!--<script src="userPageScript.js"></script>-->
		<script type="text/javascript">
			
			var userCourses = <?php echo $userCourses; ?>;
            var courseProgress = <?php echo $userProgress; ?>;
            var examDates = <?php echo $examDates; ?>;
            var text = "";
            //var selectionFromDash;
            //var selectionFromDashNum;

            for (i = 0; i < userCourses.length; i++){
	            text += "<tr style=\"text-align:center\"><td><a href=\"userExams.html\" onclick=\"setFirstSelection('" + userCourses[i] + "', 'courseButton" + i + "')\">" + userCourses[i] + "</a></td><td>" + courseProgress[i] + "%</td><td id=\"demo" + (i + 1) + "\"></td></tr>";
                setCountdown("demo" + (i + 1), examDates[i]);
            }

            document.getElementById("tableBody").innerHTML = text;
            document.getElementById("registeredExamsSection").style.height = (userCourses.length)*40 + 500 + "px";


            progressColours("cs1Progress",<?php echo $_SESSION["CS1"]?>);
            progressColours("cs2Progress",<?php echo $_SESSION["CS2"]?>);
            progressColours("cm1Progress",<?php echo $_SESSION["CM1"]?>);
            progressColours("cm2Progress",<?php echo $_SESSION["CM2"]?>);
            progressColours("cb1Progress",<?php echo $_SESSION["CB1"]?>);
            progressColours("cb2Progress",<?php echo $_SESSION["CB2"]?>);
            progressColours("cb3Progress",<?php echo $_SESSION["CB3"]?>);
            progressColours("cp1Progress",<?php echo $_SESSION["CP1"]?>);
            progressColours("cp2Progress",<?php echo $_SESSION["CP2"]?>);
            progressColours("cp3Progress",<?php echo $_SESSION["CP3"]?>);

            //count ST exams
            var count = <?php echo $_SESSION["ST0"]?> + <?php echo $_SESSION["ST1"]?> + <?php echo $_SESSION["ST2"]?> + <?php echo $_SESSION["ST4"]?> + <?php echo $_SESSION["ST5"]?> + <?php echo $_SESSION["ST6"]?> + <?php echo $_SESSION["ST7"]?> + <?php echo $_SESSION["ST8"]?> + <?php echo $_SESSION["ST9"]?>;
            if(count == 1){
                progressColours("firstStProgress",1);
            }
            else if(count >= 2){
                progressColours("firstStProgress",1);
                progressColours("secondStProgress",1);
            }


            //count SA exams
            var count = <?php echo $_SESSION["SA0"]?> + <?php echo $_SESSION["SA1"]?> + <?php echo $_SESSION["SA2"]?> + <?php echo $_SESSION["SA3"]?> + <?php echo $_SESSION["SA4"]?> + <?php echo $_SESSION["SA5"]?> + <?php echo $_SESSION["SA6"]?>;
            if(count >= 1){
                progressColours("saProgress",1);
            }



            function progressColours(name,value){
                if(value == 1){
                    document.getElementById(name).style.backgroundColor = "#7AF0C9";
                }
                else{
                    document.getElementById(name).style.backgroundColor = "white";
                }
            }

            /*
            function setFirstSelection(selection,number){
	            selectionFromDash = selection;
	            selectionFromDashNum = number;
            }
            */

            function setCountdown(idName, date1){
	            // Set the date we're counting down to
	            //var countDownDate = new Date("Jan 5, 2019 15:37:25").getTime();
                var countDownDate = new Date(date1).getTime();

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
	              document.getElementById(idName).innerHTML = days + "d " + hours + "h "
	              + minutes + "m " + seconds + "s ";

	              // If the count down is finished, write some text 
	              if (distance < 0) {
		            clearInterval(x);
		            document.getElementById(idName).innerHTML = "EXPIRED";
	              }
	            }, 1000);
            }

		</script>
	
	</body>


</html>

