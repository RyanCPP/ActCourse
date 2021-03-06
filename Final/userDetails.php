<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["firstLogin"] == 0){
    header("location: userPage.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$firstName = $lastName = $country = $industry = $receiveEmails = $siteCharacter = $siteName = "";
$firstName_err = $lastName_err = $country_err = $industry_err = $receiveEmails_err = $siteCharacter_err = $siteName_err = $exams_err = $examReg_err = "";
//$exams needs to be set via an sql query so that if exams are updated this assignment is automatically updated
$exams = array("CS1","CS2","CM1","CM2","CB1","CB2","CB3","CP1","CP2","CP3","ST0","ST1","ST2","ST4","ST5","ST6","ST7","ST8","ST9","SA0","SA1","SA2","SA3","SA4","SA5","SA6"); 
$examsLength = count($exams);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if first name is empty
    if(empty(trim($_POST["firstName"]))){
        $firstName_err = "Please enter your First Name.";
    } else{
        $firstName = trim($_POST["firstName"]);
    }
    
    // Check if lastName is empty
    if(empty(trim($_POST["lastName"]))){
        $lastName_err = "Please enter your Last Name.";
    } else{
        $lastName = trim($_POST["lastName"]);
    }
    
    //!!!!!!!!!!!! NOTE THAT SITENAME CURRENTLY DOES NOT CHECK FOR DUPLICATES, SITENAME MAY BE USELESS, CHECK IN FUTURE
    // Check if siteName is empty
    if(empty(trim($_POST["siteName"]))){
        $siteName_err = "Please enter your Site Name.";
    } else{
        $siteName = trim($_POST["siteName"]);
    }

    // Check if industry is empty
    if(empty(trim($_POST["industry"]))){
        $industry_err = "Please enter your industry.";
    } else{
        $industry = trim($_POST["industry"]);
    }

    // Check if country is empty
    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter your country.";
    } else{
        $country = trim($_POST["country"]);
    }

    // Validate input
    if(empty($firstName_err) && empty($lastName_err) && empty($siteName_err) && empty($industry_err) && empty($country_err)){
        // Prepare a select statement
        $sql = "insert into userDetails (id, name, surname, siteName, country, industry, receiveEmails, siteCharacter) values (?,?,?,?,?,?,1,1)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssss", $param_id, $param_firstName, $param_lastName, $param_siteName, $param_country, $param_industry);
            
            // Set parameters
            $param_id = $_SESSION["id"];
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_country = $country;
            $param_industry = $industry;
            $param_siteName = $siteName;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                     
                /*
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["email"] = $email;                            
                */
                
                
                if($_SESSION["firstLogin"] == 1) {
                    //set the firstLogin indicator to 0 so that future redirection goes to the welcome page
                    $sql = "update users set firstLogin = 0 WHERE id = ?";

                    $stmt = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $param_id);
                    $param_id = $_SESSION["id"];
                    mysqli_stmt_execute($stmt);
                    
                    for($i = 0; $i < $examsLength; $i++){
                        $sql = "insert into userExams (id, code, passedIndicator, registeredIndicator) values (?, ?, ?, ?)";
                        $stmt = mysqli_prepare($link, $sql);
                        mysqli_stmt_bind_param($stmt,"isii",$param_id,$param_code,$param_ind, $param_regInd);

                        $param_id = $_SESSION["id"];
                        $param_code = $exams[$i];
                        if(isset($_POST[$exams[$i]])){                    
                            $param_ind = 1;}
                        else {
                            $param_ind = 0;}
                        //$param_ind = $i;

                        if(isset($_POST[$exams[$i]."reg"])){                    
                            $param_regInd = 1;}
                        else {
                            $param_regInd = 0;}

                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_reset($stmt);                        
                    }
                    
                }

                // Redirect user to welcome page
                header("location: userPage.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Details</h2>
        <p>Great! Now that you have signed up, please tell us a bit more about yourself.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstName" class="form-control" value="<?php echo $firstName; ?>">
                <span class="help-block"><?php echo $firstName_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastName" class="form-control">
                <span class="help-block"><?php echo $lastName_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($siteName_err)) ? 'has-error' : ''; ?>">
                <label>Site Name - This name will be used when you ask questions in the chat forum.</label>
                <input type="text" name="siteName" class="form-control">
                <span class="help-block"><?php echo $siteName_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($industry_err)) ? 'has-error' : ''; ?>">
                <label>What industry are you currently in?</label>
                <select name="industry" class="form-control">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="lifeInsurance">Life Insurance</option>
                    <option value="generalInsurance">General Insurance</option>
                    <option value="healthInsurance">Health Insurance</option>
                    <option value="banking">Banking</option>
                    <option value="investments">Investments</option>
                    <option value="academia">Academia</option>
                    <option value="student">Student</option>
                    <option value="other">Other</option>
                </select>                
                <span class="help-block"><?php echo $industry_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                <label>What country do you live in?</label>
                <select id="country" name="country" class="form-control">
                    <option disabled selected value> -- select an option -- </option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Åland Islands">Åland Islands</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="French Southern Territories">French Southern Territories</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guernsey">Guernsey</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-bissau">Guinea-bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong">Hong Kong</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Isle of Man">Isle of Man</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jersey">Jersey</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                    <option value="Korea, Republic of">Korea, Republic of</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macao">Macao</option>
                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montenegro">Montenegro</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn">Pitcairn</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Helena">Saint Helena</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Serbia">Serbia</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Timor-leste">Timor-leste</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Viet Nam">Viet Nam</option>
                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                    <option value="Western Sahara">Western Sahara</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                </select>
                <span class="help-block"><?php echo $country_err; ?></span>
            </div>

            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group <?php echo (!empty($exams_err)) ? 'has-error' : ''; ?>">
                                <label>Exams Passed</label><br>
                                <input type="radio" name="CS1"> CS1<br>
                                <input type="radio" name="CS2"> CS2<br>
                                <input type="radio" name="CM1"> CM1<br>
                                <input type="radio" name="CM2"> CM2<br>
                                <input type="radio" name="CB1"> CB1<br>
                                <input type="radio" name="CB2"> CB2<br>
                                <input type="radio" name="CB3"> CB3<br>
                                <input type="radio" name="CP1"> CP1<br>
                                <input type="radio" name="CP2"> CP2<br>
                                <input type="radio" name="CP3"> CP3<br>
                                <input type="radio" name="ST0"> ST0<br>
                                <input type="radio" name="ST1"> ST1<br>
                                <input type="radio" name="ST2"> ST2<br>
                                <input type="radio" name="ST4"> ST4<br>
                                <input type="radio" name="ST5"> ST5<br>
                                <input type="radio" name="ST6"> ST6<br>
                                <input type="radio" name="ST7"> ST7<br>
                                <input type="radio" name="ST8"> ST8<br>
                                <input type="radio" name="ST9"> ST9<br>
                                <input type="radio" name="SA0"> SA0<br>
                                <input type="radio" name="SA1"> SA1<br>
                                <input type="radio" name="SA2"> SA2<br>
                                <input type="radio" name="SA3"> SA3<br>
                                <input type="radio" name="SA4"> SA4<br>
                                <input type="radio" name="SA5"> SA5<br>
                                <input type="radio" name="SA6"> SA6<br>
                                <span class="help-block"><?php echo $exams_err; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group <?php echo (!empty($examReg_err)) ? 'has-error' : ''; ?>">
                                <label>Exams Registered For in the coming Session</label><br>
                                <input type="radio" name="CS1reg"> CS1<br>
                                <input type="radio" name="CS2reg"> CS2<br>
                                <input type="radio" name="CM1reg"> CM1<br>
                                <input type="radio" name="CM2reg"> CM2<br>
                                <input type="radio" name="CB1reg"> CB1<br>
                                <input type="radio" name="CB2reg"> CB2<br>
                                <input type="radio" name="CB3reg"> CB3<br>
                                <input type="radio" name="CP1reg"> CP1<br>
                                <input type="radio" name="CP2reg"> CP2<br>
                                <input type="radio" name="CP3reg"> CP3<br>
                                <input type="radio" name="ST0reg"> ST0<br>
                                <input type="radio" name="ST1reg"> ST1<br>
                                <input type="radio" name="ST2reg"> ST2<br>
                                <input type="radio" name="ST4reg"> ST4<br>
                                <input type="radio" name="ST5reg"> ST5<br>
                                <input type="radio" name="ST6reg"> ST6<br>
                                <input type="radio" name="ST7reg"> ST7<br>
                                <input type="radio" name="ST8reg"> ST8<br>
                                <input type="radio" name="ST9reg"> ST9<br>
                                <input type="radio" name="SA0reg"> SA0<br>
                                <input type="radio" name="SA1reg"> SA1<br>
                                <input type="radio" name="SA2reg"> SA2<br>
                                <input type="radio" name="SA3reg"> SA3<br>
                                <input type="radio" name="SA4reg"> SA4<br>
                                <input type="radio" name="SA5reg"> SA5<br>
                                <input type="radio" name="SA6reg"> SA6<br>
                                <span class="help-block"><?php echo $examReg_err; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <!--<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>-->
        </form>
    </div>    
</body>
</html>
