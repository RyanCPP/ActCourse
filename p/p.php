<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

$config = parse_ini_file('config.ini');

$link = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
//$link = mysqli_connect('localhost','root','rootsql',$config['dbname']);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. ");
}
 
// Prepare an insert statement
$sql = "INSERT INTO test (id, name, age) VALUES (?, ?, ?)";
 
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "isi", $id, $name, $age);
    
    // Set parameters
    $id = mysqli_real_escape_string($link, $_REQUEST['id']);
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);


    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
    }
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
}
 
// Close statement
mysqli_stmt_close($stmt);


// Attempt select query execution
$sql = "select * from test";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<div style='height:100px'></div>";        
        echo "<table>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>name</th>";
                echo "<th>age</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

 
// Close connection
mysqli_close($link);
?>
