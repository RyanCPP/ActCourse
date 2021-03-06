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
$courseDescriptions = array();

// Include config file
require_once "config.php";

$sql = "select code, package from coursesPurchased where id = ?";

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
            array_push($coursesPurchased,$row[0]);
            array_push($packages,$row[1]);
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


$userCourses = json_encode($coursesPurchased);
$purchasedPackages = json_encode($packages);
//$allCourses1 = json_encode($allCourses);



$sql = "select description from exams where product = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_prod);
    
    // Set parameters
    $param_prod = 1;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Get result
        $result = mysqli_stmt_get_result($stmt);

        $i = 0;
        while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            array_push($courseDescriptions,$row[0]);
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


$descriptions = json_encode($courseDescriptions);

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
						<a class="nav-link" href="userExams.php">My Exams<span class="sr-only">(current)</span></a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link"  style="width: 200px; Text-align: center" href="#top">Products</a>
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
		
		<div class="container" style="height:100px"></div>
		<div class="container" style="height:100px; text-align: center"><h4>Select a Course</h4></div>
			<div class="container">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<table class="table table-hover" style="text-align:center"> <!-- table-dark -->
						  <thead>
							<tr>
							  <th scope="col">Course</th>
							  <th scope="col">Description</th>
							  <th scope="col">Option</th>
							</tr>
						  </thead>
						  <tbody id="tableBody">
							<!--<tr>
							  <td>CT1</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CT2</td>
							  <td>description variable passed from php</td>
							  <td><i><b>Upgrade</b></i></td>
							</tr>
							<tr>
							  <td>CT3</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CT4</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CT5</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CT6</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CT7</td>
							  <td>description variable passed from php</td>
							  <td><i><b>Upgrade</b></i></td>
							</tr>
							<tr>
							  <td>CT8</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CA1</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CA2</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>CA3</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>Excel</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>
							<tr>
							  <td>SQL</td>
							  <td>description variable passed from php</td>
							  <td>Purchase</td>
							</tr>-->
						  </tbody>
						</table>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
		
		
		<!-- once user selects an exam then the below should be populated with an appropriate price and the "add to cart" buttons should be clickable -->
		<div class="container" style="background-color: white; height:700px">
			<div class="container" style="background-color: white; height: 100px;"></div>
			<div class="container" style="background-color: white; height: 100px; text-align: center"><h4 id="courseName">Select a Package</h4></div> <!-- this heading should be dynamic, ie if user selects CT5 then it should say "Our CT5 Packages" -->
			<div class="container" style="background-color: white; height: 50px;"></div>
			<div class="container">
			  <div class="card-deck mb-3 text-center">
				<div class="card mb-4 shadow-sm">
				  <div class="card-header">
					<h4 class="my-0 font-weight-normal">Basic</h4>
				  </div>
				  <div class="card-body">
					<h1 class="card-title pricing-card-title" style="color: gray" id="basicTotal"><em></em></h1>
					<ul class="list-unstyled mt-3 mb-4">
					  <li>6 Months Full Access</li>
					  <li>Discussion Forum</li>
					  <li>Study Planner</li>
					  <li>Formula Sheet</li>
					  <li>Study Notes</li>
					</ul>
					<div class="row" style="height: 75px"></div>
					<button type="button" class="btn btn-lg btn-block btn-outline-success" onclick="addToCart('Basic')">Add to Cart</button>
				  </div>
				</div>
				<div class="card mb-4 shadow-sm">
				  <div class="card-header">
					<h4 class="my-0 font-weight-normal">Intermediate</h4>
				  </div>
				  <div class="card-body">
					<h1 class="card-title pricing-card-title" style="color: gray" id="intermediateTotal"><em></em></h1>
					<ul class="list-unstyled mt-3 mb-4">
					  <li>6 Months Full Access</li>
					  <li>Discussion Forum</li>
					  <li>Study Planner</li>
					  <li>Formula Sheet</li>
					  <li>Study Notes</li>
					  <li>Excel Files</li>
					  <li>Video Lectures</li>
					</ul>
					<div class="row" style="height: 25px"></div>
					<button type="button" class="btn btn-lg btn-block btn-success" onclick="addToCart('Intermediate')">Add to Cart</button>
				  </div>
				</div>
				<div class="card mb-4 shadow-sm">
				  <div class="card-header">
					<h4 class="my-0 font-weight-normal">Professional</h4>
				  </div>
				  <div class="card-body">
					<h1 class="card-title pricing-card-title" style="color: gray" id="proTotal"><em></em></h1>
					<ul class="list-unstyled mt-3 mb-4">
					  <li>6 Months Full Access</li>
					  <li>Discussion Forum</li>
					  <li>Study Planner</li>
					  <li>Formula Sheet</li>
					  <li>Study Notes</li>
					  <li>Excel Files</li>
					  <li>Video Lectures</li>
					  <li>Past Exam Review</li>
					</ul>
					<button type="button" class="btn btn-lg btn-block btn-success" onclick="addToCart('Pro')">Add to Cart</button>
				  </div>
				</div>
			  </div>
			
			<div class="row" style="height: 50px;"></div>
			<div class="row" style="height: 50px; text-align: center">
				<div class="col-md-5"></div>
				<div class="col-md-2"><h4>My Cart</h4></div>
				<div class="col-md-5"></div>
			</div>			
			<div class="row" style="height:250px" id="spaceHeight">
				<div class="container">
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<table class="table table-hover" style="text-align:center"> <!-- table-dark -->
							  <thead>
								<tr>
								  <th scope="col">Course</th>
								  <th scope="col">Package</th>
								  <th scope="col">Price</th>
								  <th scope="col">Option</th>
								</tr>
							  </thead>
							  <tbody id="cartTableBody">
							  </tbody>
							  <tfoot>
								<tr>
									<td colspan="2"></td>
									<td style="text-align:center"><b>Total</b></td>
									<td id="cartTotal"><b></b></td>
								</tr>
							  </tfoot>
							</table>
						</div>
						<div class="col-md-3"></div>
					</div>
					<div class="row">
					<div class="col-md-5"></div>
					<div class="col-md-2">
						<button type="button" class="btn btn-block btn-info">Checkout</button> <!-- success is green, primary is blue, secondary is grey, info is light blue, light is light grey -->
					</div>
					<div class="col-md-5"></div>
					</div>
				</div>
			</div>
				
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
		<script>
			var allCourses = ["CS1","CS2","CM1","CM2","CB1","CB2","CB3","CP1","CP2","CP3","Excel","SQL"];
            var courseDescriptions = <?php echo $descriptions; ?>;
			//var coursePrices = [100,110,120,130,140,150,160,170,180,190,200,210];		//add multidimensional arrary (one dimension for each product, basic, pro etc)
            var coursePrices = [100,110,120,130,140,150,160,170,180,190,200,210];
			var numAllCourses = allCourses.length;
			//var userExams = ["CM2","CB2","CP2","CS1"];
            var userExams = <?php echo $userCourses; ?>;
            var userPackages = <?php echo $purchasedPackages; ?>;
            //var allCourses = <?php echo $allCourses1; ?>;
			var numUserExams = userExams.length;
			var text = "";
			var textNotRegis = "Purchase";
			var textRegis = "<i><b>Upgrade</b></i>";
			var totalCost = 0;
			var priceText = "";
			var selectedExams = [];
			var selectedExam;
			var selectedExamPrice;
			var cartSum;
			var previousRow;
			
			
			for (i = 0; i < numAllCourses; i++){
				
				var text2;
				
				for (j = 0; j < numUserExams; j++){
					if(allCourses[i] == userExams[j] && userPackages[j] < 3){
						text2 = textRegis;
						break;
					}
                    else if(allCourses[i] == userExams[j] && userPackages[j] == 3){
                        text2 = "Unavailable";
                        break;
                    }
					else
						text2 = textNotRegis;
				}
				
				text += "<tr id=\"course" + i + "\" onclick=\"showCost('" + allCourses[i] + "', coursePrices, allCourses, " + i + ",'" + text2 + "')\"><td>" + allCourses[i] + "</td><td>" + courseDescriptions[i] + "</td><td>" + text2 + "</td></tr>";
			}
			
			document.getElementById("tableBody").innerHTML = text;
			
            			
            function checkOption(check){
                if(check == "Unavailable")
                    alert("You have already purchased this product with the best package.\nPlease select a different product.");
            }

			function showCost(course, prices, courses, rowNumber, textCheck){
                checkOption(textCheck);				
                document.getElementById("basicTotal").innerHTML = "<em>$" + prices[courses.indexOf(course)] + "</em>";
				document.getElementById("intermediateTotal").innerHTML = "<em>$" + prices[courses.indexOf(course)]*1.25 + "</em>";
				document.getElementById("proTotal").innerHTML = "<em>$" + prices[courses.indexOf(course)]*1.5 + "</em>";
				selectedExam = course;
				selectedExamPrice = prices[courses.indexOf(course)];
				document.getElementById("course" + rowNumber).style.backgroundColor = "grey";
				document.getElementById("courseName").innerHTML = "Our " + selectedExam + " Packages";
				if(previousRow == null){
					previousRow = rowNumber;
				}
				else{
					document.getElementById("course" + previousRow).style.backgroundColor = "white";
					previousRow = rowNumber;
					}
			}
			
            
			
			function addToCart(packageChosen){
				if(selectedExam == null){
					alert("Please select an exam.");
				}
				else{
					selectedExams.push(selectedExam, packageChosen, selectedExamPrice);
					amendCart(selectedExams);
				}
					
			}
			
			function amendCart(chosenExamsArray){
				cartSum = 0;
				text = "";
				for (i = 0; i < chosenExamsArray.length / 3; i++){
					text += "<tr><td>" + chosenExamsArray[3 * i] + "</td><td>" + chosenExamsArray[3 * i + 1] + "</td><td>$ " + chosenExamsArray[3 * i + 2] + "</td><td><img src=\"delete.png\" alt=\"Delete\" style=\"height:20px; width:20px\" onclick=\"deleteItem(" + i * 3 + ")\"></td></tr>";
					cartSum += chosenExamsArray[3 * i + 2];
				}
				document.getElementById("cartTableBody").innerHTML = text;
				document.getElementById("spaceHeight").style.height = (chosenExamsArray.length / 3)*50 + 250 + "px";
				document.getElementById("cartTotal").innerHTML = "$ " + cartSum;
			}
			
			function deleteItem(start){
				selectedExams.splice(start,3);
				amendCart(selectedExams);
			}
			
		</script>
	</body>


</html>

