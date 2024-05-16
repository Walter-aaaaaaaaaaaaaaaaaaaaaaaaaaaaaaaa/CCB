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

//check student id
function checkStudentID($id){
    if($id == NULL){
        return "*Enter Your <b>Student ID</b>";
    }
    else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $id)){
        return "*Invaild <b>Student ID</b>";
    }
    else if(!studentIDExist($id)){
        return "*<b>StudentID</b> Not Found!";
    }
}

function studentIDExist($id){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM student_detail WHERE StudentID = '$id'";
    
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

function checkStaffID($id){
    if($id == NULL){
        return "*Enter Your <b>Staff ID</b>";
    }
    else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $id)){
        return "*Invaild <b>Staff ID</b>";
    }
    else if(!StaffIDExist($id)){
        return "*<b>StaffID</b> Not Found!";
    }
}

function StaffIDExist($id){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM admin_detail WHERE adminID = '$id'";
    
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

function checkStudentPass($password){
    if($password == NULL){
        return "*Enter Your <b>Password</b>";
    }
    else if(strlen($password) < 8){
        return "*<b>Password</b> To Short Must Be Atleast 8 Character!";
    }
    else if(!PasswordExist($password)){
        return "*Incorrect <b>Password</b>!";
    }
}

function PasswordExist($password){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM student_detail WHERE Password = '$password'";
    
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

function checkStaffPass($password){
    if($password == NULL){
        return "*Enter Your <b>Password</b>";
    }
    else if(strlen($password) < 8){
        return "*<b>Password</b> To Short Must Be Atleast 8 Character!";
    }
    else if(!StaffPasswordExist($password)){
        return "*Incorrect <b>Password</b>!";
    }
}

function StaffPasswordExist($password){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM admin_detail WHERE Password = '$password'";
    
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

function checkEmail($email){
    if($email == NULL){
        return "*Enter Your <b>Email</b>";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return "*<b>Email</b> Format Incorrect!";
    }
    else if(!StudentEmailExist($email)){
        return "*<b>Email</b> Not Founded!";
    }
}

function StudentEmailExist($email){
    $exist = false;
    
    //step 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //step 2: sql statement
    $sql = "SELECT * FROM student_detail WHERE Email = '$email'";
    
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

function checkSamePassword($password,$password2){
    if($password == NULL){
        return "*Enter Your <b>Password</b>";
    }
    else if(strlen($password) < 8){
        return "*<b>Password</b> To Short Must Be Atleast 8 Character!";
    }
    else if($password != $password2){
        return "<b>Confirm Password</b> is Not Match With <b>First Password</b>!";
    }
}