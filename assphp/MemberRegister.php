<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Member Register Page</title>
        <link href="member_register.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>

    <body>
        <?php
        require_once './config/event_helper.php';
        ?>

        <?php
        
        global $name,$pass, $email, $gender, $phone, $id, $program;
        
        if (!empty($_POST)) {
            //YES, user clicked the insert button
            //retreive ALL user input
            

                (isset($_POST['mbFName']))?
                $name = trim($_POST['mbFName']):
                $name = "";
                                
                (isset($_POST['mbPass']))?
                $pass = trim($_POST['mbPass']):
                $pass = "";
                
                (isset($_POST['mbEmail']))?
                $email = trim($_POST['mbEmail']):
                $email = "";
                
                (isset($_POST['list-gender']))?
                $gender = $_POST['list-gender']:
                $gender = "";
                
                (isset($_POST['mbPhone']))?
                $phone = trim($_POST['mbPhone']):
                $phone = "";
                
                (isset($_POST['mbStudentID']))?
                $id = trim($_POST['mbStudentID']):
                $id = "";
                
                (isset($_POST['mbProgram']))?
                $program = trim($_POST['mbProgram']):
                $program = "";

                //check error and validation
                $error["name"] = checkFirst($name);
                $error["pass"] = checkPass($pass);
                $error["email"] = checkEmail($email);
                $error["gender"] = checkGender($gender);
                $error["phone"] = checkPhoneNum($phone);
                $error["id"] = checkStudentID($id);
                $error["program"] = checkProgram($program);
                $error = array_filter($error);

            if(empty($error)) {
                //NO error Insert Value
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
                $sql = "INSERT INTO student_detail(StudentID,Std_name,Email,Password,Gender,PhoneNumber,Programme)
                       VALUES(?,?,?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssssss",$id,$name,$email,$pass,$gender,$phone,$program);
                $stmt->execute();
                
                //sucessfully
                if($stmt->affected_rows > 0){
                    //insert successfully
                    printf("<div class='mbInfo'>Student %s has been Register
                            <a href='login.php'>Login Page</a>
                            </div>",$name);
                    
                //unsucessful
                }else{
                    echo"<div class='mbError'>Unable to Insert!
                        [<a href='MemberRegister.php'>Back To Register Page</a>])
                    </div>";
                }
                
            }else {
                //WITH error, DISPLAY ERROR MSG
                echo"<ul class='mbError'>";
                foreach ($error as $value) {
                    echo"<li class='mbErrorText'>$value</li>";
                }
                echo"</ul>";
            }
        }
        ?>

        <form action="" method="POST">
            <div class="allback-size">
                <div class="background-size">
                    <div class="title">
                        <h1>Registration Member</h1>
                    </div>
                    </br>

                    <div class="register-form">
                        <div class="left-box">
                            <div class="box-size">
                                <label>Name</label>
                                <input type="text" name="mbFName" placeholder="Enter your First Name" class="inputBox-size" value="<?php echo $name;?>"/>  
                            </div>

                            <div class="box-size">
                                <label>Password</label>
                                <input type="password" name="mbPass" placeholder="Enter your Password" class="inputBox-size" value="<?php echo $pass;?>"/>  
                            </div>

                            <div class="box-size">
                                <label>Email Address</label>
                                <input type="text" name="mbEmail" placeholder="Enter your Email Address" class="inputBox-size" value="<?php echo $email;?>"/>  
                            </div>
                        </div>

                        <div class="right-box">
                            <div class="box-size">
                                <label>Gender</label>
                                <select name="list-gender" class="inputBox-size">
                                    <?php
                                    $allGender = getAllGender();
                                    
                                    foreach ($allGender as $key => $value){
                                        printf("<option value='%s' %s >%s</option>",$key,
                                                ($program == $key)?"selected":"",$value);
                                }
                                ?>
                                </select>
                            </div>


                            <div class="box-size">
                                <label>Phone Number</label>
                                <input type="text" name="mbPhone" placeholder="(01x-xxxxxxx)" class="inputBox-size" value="<?php echo $phone;?>"/>  
                            </div>

                            <div class="box-size">
                                <label>Student ID</label>
                                <input type="text" name="mbStudentID" placeholder="Enter your Student ID" class="inputBox-size" value="<?php echo $id;?>"/> 
                            </div>

                            <div class="box-size">
                                <label>Programme</label>
                                <input type="text" name="mbProgram" placeholder="Enter your Programme" class="inputBox-size" value="<?php echo $program;?>"/>  
                            </div>


                        </div>

                    </div>

                    <div class="register-btn">
                        <input type="submit" value="Confirm EDIT" name="btnSubmit" class="register-btn"/>
                        <input type="reset" value="Reset EDIT" class="register-btn"/>  
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
