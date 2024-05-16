<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
define('DB_HOST', "database-1.cjyok84yytm8.us-east-1.rds.amazonaws.com");
define('DB_USER', "admin");
define('DB_PASS', "B1234567b");
define('DB_NAME', "databaseOne");
define('DB_PORT', "3306");

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);

if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

//validation function
//check program drop down list

function checkUserName($name){
    if($name == NULL){
        return "Please Enter Your <b>User Name</b>!";
    }
    else if(!preg_match("/^[a-z A-Z@,\"\-\.\/]+$/",$name)){
        return "Invaild <b>Username</b> Format!";
    }
    else if(strlen($name) > 15){
        return "too long name!(maximum 15 character)";
    }
}

function validateEmail($email) {
    // Validate email
    if($email==NULL){
        return"Please Enter Your <b>EMAIL ADDRESS</b>!";
    }
    else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    } else {
        return "Invalid Format Of <b>EMAIL ADDRESS</b>";
    }
}

function checkPhoneNumber($phoneN){
    if($phoneN == NULL){
        return "Please Enter your <b>PHONE NUMBER</b>!";
    }else if(!preg_match('/^01[0-9]-\d{7,8}$/', $phoneN)){
        return "Invalid <b>PHONE NUMBER</b> Format!";
    }else if(strlen($phoneN)>11){
        return "Your phone number too long! Only 10-11 character allow";
    }
}

function checkPaymentMethod($payment){
    
    if($payment == NULL){
        return "Please Enter Your <b>PAYMENT METHOD</b>!";
    }
    else if(empty($payment)){
        return "Unable to retrieve available payment methods. Please try again later.";
    }
}

function validateMaybankAccountNumber($account){
    if($account==NULL){
        return"Please Enter Your <b>ACCOUNT NUMBER</b>!";
    }
    else if (!preg_match('/^[0-2]\d{11}$/', $account)) {        
        return 'Sorry,Our system Only Allow Maybank Account.We are sorry for the incompetence of the system';
    }
    else if(accNumberExist($account)){
        return"Duplicated <b>ACCOUNT NUMBER</b> Detected!";
    
    }
}

function accNumberExist($account){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM payment WHERE account_number = '$account'";
    
    //step 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //record found!same PK
            $exist = true;
            
        }
}
    $result->free();
    $con ->close();
    return $exist;
}

function validateMaybankCVC($CVC){
    if($CVC==NULL){
        return"Please Enter Your <b>CVC</b>!";
    }
    else if(preg_match('/^\d{3}$/', $CVC)){
        
    }else{
        return"Unable to retrieve available payment methods. Please try again later.";
    }
}

function getAllMethod(){
    return array(
        "DEBIT"=>"💳Debit",
        "CREDIT"=>"💳Credit"
    );
}

function checkDateInput($date){
    if($date == NULL){
        return "Please select a <b>DATE</b>!";
    }
    else{
        
    }
}

function checkTitle($title){
    if($title == NULL){
        return "Please Enter the <b>TITLE<b>!";
    }
    else if(titleExist($title)){
        return"Duplicated <b>Title</b> Detected!";
    }
}

function titleExist($title){
    $exist=false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM announcement WHERE title_announcement = '$title'";
    
    //step 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //record found!same PK
            $exist = true;
}
    }
    //step 4: close connection, free $result
    $result->free();
    $con ->close();
    return $exist;
}


function checkDesc($desc){
    if($desc==NULL){
        return"Please Enter the <b>DESCRIPTION<b>!";
    }
   else if(strlen($desc) > 500){
        return "too long name!(maximum 500 character)";
    }

}


