<?php

    function db_connect() {

        static $connection;

        if(!isset($connection)){    
        //Load configuration as an array
        $config = parse_ini_file('/con/config.ini');

       // Try and connect to the database
        $connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
        }     


        // If connection was not successful, handle the error
        if($connection === false) {
            // Handle error
            //return mysqli_connect_error();
            die("Error: Could not connect.");
        } 
        
        return $connection;
    }

    function db_query($query) {
        //connect to the database
        $connection = db_connect();

        //Query the database
        $result = mysqli_query($connection, $query);

        return $result;
    }
    

    //$result = db_query("insert into test (id, name, age) values (11, 'TestVal', 99)");
    //$result = db_query("select * from test where id = 11");
    
    //$query1 = "insert into test (id, name, age) values (11, 'TestVal', 99)";
    //$query1 = "select * from test where id = 11";


    function db_select($query) {
       $rows = array();
       $result = db_query($query);
        //$result = db_query("insert into test2 (id, name, age) values (" . $id . "," . $name . "," . $age . ")");

       //if fail, return false
       if($result === false) {
           //Handle failure        
           return false;
       } 
           
       //if successful, put rows into array 
       while ($row = mysqli_fetch_assoc($result)) {
           $rows[] = $row;    
       }
       return $rows;
    }


    function db_error() {
        $connection = db_connect();
        return mysqli_error($connection);
    }

    
    function db_quote($value) {
        $connection = db_connect();
        return "'" . mysqli_real_escape_string($connection,$value) . "'";
    }


    /*
        $id = db_quote($_POST['id']);
        $name = db_quote($_POST['name']);
        $age = db_quote($_POST['age']);
    */
?>

