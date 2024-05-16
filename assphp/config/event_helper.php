<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<?php

define('DB_HOST', "database-1.cjyok84yytm8.us-east-1.rds.amazonaws.com");
define('DB_USER', "admin");
define('DB_PASS', "B1234567b");
define('DB_NAME', "databaseOne");
define('DB_PORT', "3306");

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

//START MEMBER HELPER
//check first name
function checkFirst($name){
    if($name == NULL){
        return "Please Enter your <b>First Name</b>";
    }else if(!preg_match("/^[A-Za-z ]+$/", $name)){
        return "Only <b>Allow</b> Character in First Name";
    }else if(strlen($name)>30){
        return "Your first name too long! Only 30 character allow";
    }
}

//check password
function checkPass($pass){
    if($pass == NULL){
        return "Please Enter your <b>Password</b>";
    }else if(!preg_match("/^[A-Za-z0-9 @\_\-\.]+$/", $pass)){
        return "Invalid <b>Password</b> Format!";
    }else if(strlen($pass)>14){
        return "Your name <b>TOO LONG</b>! Only 14 character allow";
    }
}

function checkEmail($email){
    if($email == NULL){
        return "Please Enter your <b>Email Address</b>";
    }else if(!preg_match("/^[A-Za-z0-9 @\_\-\.\@\#]+$/", $email)){
        return "Invalid <b>Email</b> Format!";
    }else if(strlen($email)>30){
        return "Your email too long! Only 30 character allow";
    }
}

//check gender
function checkGender($gender){
    if($gender == null){
        return "Please Select Your <b>Gender</b>";
    }else if(!array_key_exists($gender, getAllGender())){
        return "Invalid Gender <b>Identified</b>";
    }
}

//check phone number
function checkPhoneNum($phone){
    if($phone == NULL){
        return "Please Enter your <b>Password</b>";
    }else if(!preg_match('/^01[0-9]-\d{7,8}$/', $phone)){
        return "Invalid <b>Phone Number</b> Format!";
    }else if(strlen($phone)>11){
        return "Your phone number too long! Only 10-11 character allow";
    }
}

//check student ID
function checkStudentID($id){
    if($id == NULL){
        return "Please Enter your <b>STUDENT ID</b>";
    }else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $id)){
        return "Invalid <b>STUDENT ID</b> format!"; 
    }else if(studentIDExist($id)){
        return "Duplicated <b>STUDENT ID</b> detected!";
        
    }
}

function checkProgram($program){
    if($program == NULL){
        return "Please Enter your <b>Programme</b>";
    }else if(!preg_match("/^[A-Za-z ]+$/", $program)){
        return "Only allows character when Entering <b>Programme</b>!";
    }else if(strlen($program)>50){
        return "Your program Name too long! Only 30 character allow";
    }
}

function studentIDExist($id){
    $exist = false;
    
    //STEP 1: connect PHP app with database
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //STEP 2: sql statement
    $sql = "SELECT * FROM student_detail WHERE StudentID = '$id'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //RECORD FOUND! SAME PK
            $exist = true;
        }
    }
    
    //STEP 4: Close connection, free $result 
    $result->free();
    $con->close();
    return $exist;
    
}

function getAllGender(){
    return array(
      "M" => "🚹Male",
      "F" => "🚺Female"
    );
}

//END MEMBER HELPER

//START EVENT HELPER
function checkEventName($event){
    if($event == NULL){
        return "Please Enter Event Name before Submit";
    }else if(strlen($event)>50){
        return "Your Event Name too long! Only 50 character allow";
    }
}

function checkDescription($desc){
    if($desc == NULL){
        return "Please Enter Description before Submit";
    }else if(strlen($desc)>1000){
        return "Your Description too long! Please Enter Between 1000 character";
    }
}

function checkEventDate($date){
    if($date == NULL){
        return "Please Select Date before Submit";
    }else if(eventDateExist($date)){
        return "Duplicated <b>DATE</b> detected!"; 
    }
}

function checkVenue($venue){
    if($venue == NULL){
        return "Please Enter Venue before Submit";
    }else if(strlen($venue)>40){
        return "Your Venue Name Too long! Please Enter Between 40 character";
    }
}


function eventDateExist($date){
    $exist = false;
    
    //STEP 1: connect PHP app with database
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //STEP 2: sql statement
    $sql = "SELECT * FROM event WHERE EventDate = '$date'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //RECORD FOUND! SAME PK
            $exist = true;
        }
    }
    
    //STEP 4: Close connection, free $result 
    $result->free();
    $con->close();
    return $exist;
}

//END EVENT HELPER