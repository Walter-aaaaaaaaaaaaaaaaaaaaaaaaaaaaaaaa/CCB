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
//check Event drop down list

//check feelings
function checkStudentID($sID){
    if($sID==null){
        return"Please enter your <b>STUDENT ID</b>!";
    }else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/',$sID)){
        return "Invalid <b>STUDENT ID</b> format!";
        
    }else if(checkStudentIDExist($sID)){
        return "Duplicated <b>STUDENT ID</b> detected";
    
        
    }
}




//check Student Name format
function checkStudentName($sname){
    if($sname==null){
        return"Please enter your <b>name!</b>";
    }else if(!preg_match("/^[A-Z a-z@,\"\-\.\/]+$/",$sname)){
        return "Invalid <b>student name!</b>";
    }else if(strlen($sname)>30){
        return"Your name too long!Only 30 character allow!";
    }
}

//check input Email
function checkEmail($email){
    if($email==NULL){
        return"Please enter your <b>Email!</b>";
    }else if(!preg_match("/^[A-Za-z0-9 @\_\-\.\@\#]+$/", $email)){
        return "Invalid <b>Email format!</b>";
    }else if(strlen($email)>30){
        return"Your email too long!Only <b>30 character</b> allow!";
    }
}

//check input Event
function checkEvent($event){
    if($event==NULL){
        return"Please select <b>your event</b>";
    }else if(!array_key_exists($event, getAllEvent())){
        return"Invalid event Selected!";
        
    }
}

//check feelings
function checkFeeling($feeling){
     if($feeling==null){
        return"Please give your <b>respond</b>";
    }else if(!array_key_exists($feeling, getAllFeeling())){
        return"Invalid respond identified!";
}

}
//check input feedback
function checkFeedback($comment){
    if($comment==null){
        return"Please give your <b>feedback</b>";
    }
}

function getAllFeeling(){
    return array("B"=>"not good😭","N"=>"Normal😐","G"=>"Good😄️");
}

function getAllEvent(){
    return array(
        "LT"=>"Literature",
        "DC"=>"Dance",
        "DR"=>"Drama"
        );
}
//------------------------------------------------------

//check input format Admin ID
function checkAdminID($adID){
    if($adID==NULL){
        return"Please enter <b>Admin ID</b>!";
    }else if(!preg_match('/^[A-Z]{2}[0-9]{3}$/',$adID)){
        return "Invalid <b>Admin ID</b> format!";
        
    }else if(checkAdminIDExist($adID)){
        return "Duplicated <b>Admin ID</b>detected";
}
}

//check PK Admin ID
function checkAdminIDExist($adID){
    $exist=false;
    
    //STEP 1:connect PHP app with DP
    $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
    
    //STEP 2:sql statement
    //$sql="SELECT * FROM Student WHERE StudentID=22PMD12345";
    $sql="SELECT * FROM admin WHERE AdminID='$adID'";
    
    //STEP 3:run sql statement
    if($result=$con->query($sql)){
        if($result->num_rows >0){
            //record found!SAME PK
            $exist=true;
        }
    }
    //STEP 4:close connection,free $result
    $result->free();
    $con->close();
    return $exist;
            
}

//check format Input Admin Name
function checkAdName($adname){
    if($adname==null){
        return"Please enter <b>admin name!</b>";
    }else if(!preg_match("/^[A-Z a-z@,\"\-\.\/]+$/",$adname)){
        return "Invalid <b>admin name!<b>";
    }else if(strlen($adname)>30){
        return"Your name too long!Only 30 character allow!";
    }
}

//check input format Adminn email
function checkAdEmail($ademail){
    if($ademail==NULL){
        return"Please enter <b>Admin Email!</b>";
    }else if(!preg_match("/^[A-Za-z0-9 @\_\-\.\@\#]+$/", $ademail)){
        return "Invalid Email format!";
    }else if(strlen($ademail)>30){
        return"Your email too long!Only 30 character allow!";
    }
}



function checkRole($role){
    if($role==NULL){
        return"Please select the role";
    }else if(!array_key_exists($role, getAllRole())){
        return"Invalid role Selected!";
        
    }
}
//check Password Format
function checkAdPassword($password){
    if($password==NULL){
        return"Please enter your <b>Password!</b>";
    }else if(strlen($password)<8){
        return "Your password must contain as least 1 number!";
    }else if(!preg_match("#[A-Z]+#", $password)){
        return "Your password must contain as least 1 Capital Letter!";
    }else if(!preg_match("#[a-z]+#", $password)){
        return "Your password must contain as least 1 Lowercase!";
    }else if(!preg_match("#[0-9]+#", $password)){
        return"Your password as least contain 8 characters!";
    }
}




function getAllRole(){
    return array(
        "SA"=>"🧑🏻‍💼Super Admin",
        "EM"=>"🧑‍💼Event Manager",
        "SM"=>"🧑🏼‍💼Sales Manager"
        );
}











