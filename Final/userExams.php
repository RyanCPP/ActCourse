<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$coursesPurchased = array();
$packages = array();
$allCourses = array("CS1","CS2","CM1","CM2","CB1","CB2","CB3","CP1","CP2","CP3","Excel","SQL");
$allCoursesLength = sizeof($allCourses);


// Include config file
require_once "config.php";

$sql = "select userExams.code, coursesPurchased.expiryDate, coursesPurchased.package from userExams inner join coursesPurchased on userExams.id = coursesPurchased.id and userExams.code = coursesPurchased.code where userExams.id = ?";

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
            $_SESSION[$row[0]."expiry"] = $row[1];
            $_SESSION[$row[0]."package"] = $row[2];
            $i = $i + 1;
        }

    }
    else{
            // Display an error message if email doesn't exist
            //$email_err = "No account found with that email.";
    }
}
else{
        echo "Oops! Something went wrong. Please try again later.";
}


for($x = 0; $x < $allCoursesLength; $x++){
    if(isset($_SESSION[$allCourses[$x]."package"]) && $_SESSION[$allCourses[$x]."package"] > 0){
        array_push($coursesPurchased,$allCourses[$x]);
        array_push($packages,$_SESSION[$allCourses[$x]."package"]);
    }
}


$userCourses = json_encode($coursesPurchased);
$purchasedPackages = json_encode($packages);

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
				  <a class="navbar-brand" href="userPage.php">My Dashboard</a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				  </button>
				  <div class="collapse navbar-collapse" id="navbarText">
					<ul class="navbar-nav mr-auto">
					  <li class="nav-item active" style="width: 200px; Text-align: center">
						<a class="nav-link" href="#top">My Exams<span class="sr-only">(current)</span></a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link"  style="width: 200px; Text-align: center" href="userProducts.php">Products</a>
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
		
		<div class="container-fluid" style="background-color: white; height: 100px;"></div>
		
		<div class="container-fluid" style="background-color: white;">  <!--height: 200px;-->
			<div class="container" id="courseNames">
				<!--
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<button type="button" class="btn btn-outline-info" style="width: 100%" onclick="populateContent('CT2')">CT2</button>
					</div>
					<div class="col-md-4"></div>
				</div>	
				<div class="row" style="height:10px"></div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<button type="button" class="btn btn-outline-info" style="width: 100%" onclick="populateContent('CT6')">CT6</button>
					</div>
					<div class="col-md-4"></div>
				</div>
				<div class="row" style="height:10px"></div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<button type="button" class="btn btn-outline-info" style="width: 100%" onclick="populateContent('CA2')">CA2</button>
					</div>
					<div class="col-md-4"></div>
				</div> -->
			</div>
		</div>
		
		<!-- Product Accordion -->
		<div class="container-fluid" style="background-color: white; height: 400px" id="Settings">
			<div class="container">
				<div class="accordion" id="accordionExample">
				  <!--<div class="card">
					<div class="card-header" id="headingOne">
					  <h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						  Course Notes
						</button>
					  </h5>
					</div>
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					  <div class="card-body">
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
						first group<br>
					  </div>
					</div>
				  </div>
				  
				  <div class="card">
					<div class="card-header" id="headingTwo">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						  Course Videos
						</button>
					  </h5>
					</div>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					  <div class="card-body">
						second group
					  </div>
					</div>
				  </div>
				  
				  <div class="card">
					<div class="card-header" id="headingThree">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						  Past Exam Review
						</button>
					  </h5>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					  <div class="card-body">
						third group
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="headingFour">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						  Study Planner
						</button>
					  </h5>
					</div>
					<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
					  <div class="card-body">
						fourth group
					  </div>
					</div>
				  </div>
				  <div class="card">
					<div class="card-header" id="headingFive>
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						  Chat Forum
						</button>
					  </h5>
					</div>
					<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
					  <div class="card-body">
						fifth group
					  </div>
					</div>
				  </div> -->
				</div>
			</div>
		</div>
		
		<!-- Footer -->
		<div class="container-fluid" style="background-color: powderblue; height: 300px">
			
			<div class="container" style="background-color: powderblue" id="footer">
				<footer class="pt-4 my-md-5 pt-md-5 border-top">
					<div class="row">
					  <div class="col-12 col-md">
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
		
		
		<script src="navbarScript.js"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<!--<script src="userPageScript.js"></script>-->
        <script>
            var courses = <?php echo $userCourses; ?>;//["CM1","CM2","SQL"];//,"CT5","CA1"];
            var purchasedPackages = <?php echo $purchasedPackages; ?>;
        </script>
		<script src="userExamsScript.js"></script>
		
	
	</body>


</html>

