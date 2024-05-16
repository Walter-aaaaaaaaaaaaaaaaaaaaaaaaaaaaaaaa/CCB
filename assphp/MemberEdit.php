<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Member Edit Page</title>
        <link href="member_edit.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
            require_once './config/event_helper.php';
        ?>
        
        <?php
            global $hideForm;
            if($_SERVER["REQUEST_METHOD"]=="GET"){
                //retreive and display
                (isset($_GET["id"]))?
                $id = strtoupper(trim($_GET["id"])):
                $id = "";
                
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $sql = "SELECT * FROM student_detail WHERE StudentID = '$id'";
                $result = $con->query($sql);
                
                if($record = $result->fetch_object()){
                //record found
                    $name = $record->Std_Name;
                    $pass = $record->Password;
                    $gender = $record-> Gender;
                    $email = $record->Email;
                    $phone = $record->PhoneNumber;
                    $id = $record->StudentID;
                    $program = $record->Programme;
                    
                }else{
                    echo "<div class='mbError'>
                          Unable to retrieve record!
                          <a href='MemberEditDelete.php' class='deleteLink'>Back to Member Details</a>
                          </div>";
                    $hideForm = true;
                }
                $result->free();
                $con->close();
            
            }else{
                //POST method
                
                $name = trim($_POST["mbFName"]);
                $gender = trim($_POST["list-gender"]);
                $pass = trim($_POST["mbPass"]);
                $email = trim($_POST["mbEmail"]);
                $phone = trim($_POST["mbPhone"]);
                $id = strtoupper(trim($_POST["hdID"]));
                $program = trim($_POST["mbProgram"]);
            
                $error["name"] = checkFirst($name);
                $error["pass"] = checkPass($pass);
                $error["email"] = checkEmail($email);
                $error["gender"] = checkGender($gender);
                $error["phone"] = checkPhoneNum($phone);
                $error["program"] = checkProgram($program);
                $error = array_filter($error);
                
                if(empty($error)){
                    //no error
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    $sql = "UPDATE student_detail SET Std_Name = ?,
                            Password = ?, Email = ?, Gender = ?,PhoneNumber = ?,Programme = ?
                            WHERE StudentID = ?";
                    $statement = $con->prepare($sql);
                    $statement->bind_param("sssssss", $name,$pass,$email,$gender,$phone,$program,$id);
                    
                    if($statement->execute()){
                    //Updated sucessful
                    printf("<div class='sucessInsert'>Student with Student ID %s has been edited.
                            <a href='MemberEditDelete.php' class='deleteLink'>Back to Member View</a>
                            </div>",$id);
                    }else{
                    //Failed to Updated
                        echo"<div class='errorRecord'>Unable to Edit!
                            <a href='MemberDetails.php'>Back To Member Details</a>
                            </div>";
                    }
                    $con->close();
                    $statement->close();
                
                }else{
                    //Got error
                    echo"<ul class='mbError'>";
                        foreach($error as $value){
                            echo"<li>$value</li>";
                        }
                    echo"</ul>";
                }
                
            }
        ?>
        
        <?php if($hideForm == false) :  ?>
        <form action="" method="POST">
            <div class="background-edit">

                <div class="title-edit">
                    <h1>Edit Member Details</h1>
                </div>

                <table class="table-edit">

                    <tr>
                        <td>First Name</td>
                        <td><input type="text" name="mbFName" placeholder="Enter your First Name" class="inputBox-size" value="<?php echo $name;?>"/>  </td>
                    </tr>
                    
                    <tr>
                        <td>New Password*</td>
                        <td><input type="password" name="mbPass" placeholder="Enter your New Password" class="inputBox-size" value="<?php echo $pass;?>"/></td>
                    </tr>

                    <tr>
                        <td>Confirm New Password*</td>
                        <td><input type="password" name="mbPass" placeholder="Enter your New Password" class="inputBox-size" value="<?php echo $pass;?>"/></td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td>
                            <select name="list-gender" class="inputBox-size">
                            <?php
                                $allGender = getAllGender();

                            foreach ($allGender as $key => $value) {
                                printf("<option value='%s' %s >%s</option>", $key,
                                ($program == $key) ? "selected" : "", $value);
                            }
                            ?>
                            </select></td>
                    </tr>

                    <tr>
                        <td>New Email Address*</td>
                        <td><input type="text" name="mbEmail" placeholder="Enter your Email Address" class="inputBox-size" value="<?php echo $email;?>"/></td>
                    </tr>

                    <tr>
                        <td>New Phone Number*</td>
                        <td><input type="text" name="mbPhone" placeholder="(01x-xxxxxxx)" class="inputBox-size" value="<?php echo $phone;?>"/></td> 
                    </tr>

                    <tr>
                        <td>Student ID</td>
                        <td><?php echo $id;?>
                            <input type="hidden" name="hdID" 
                            value="<?php echo $id ?>" /></td>
                    </tr>

                    <tr>
                        <td>Programme</td>
                        <td><input type="text" name="mbProgram" placeholder="Enter your Programme" class="inputBox-size" value="<?php echo $program; ?>"/></td>
                    </tr>

                </table>

                <div>
                    <input type="submit" value="Confirm EDIT" class="register-btn"/>
                    <input type="reset" value="Reset EDIT" class="register-btn"/>
                </div>

            </div>
        </form>    
        <?php endif; ?>
        
    </body>
</html>
