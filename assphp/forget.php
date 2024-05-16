<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forget Password</title>
        <link href="forget.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>     
        <?php
        require_once './config/login_helper.php';
        ?>

        <div class="forgetbox">
            <h1>Forgot Password</h1>
            <?php
            global $id, $email, $otp;

            if (isset($_POST['Change'])) {
                //Yes, user click submit button
                //retreive all use input
                (isset($_POST["txtID"])) ?
                                $id = trim($_POST["txtID"]) : 
                                $id = "";
                (isset($_POST["email"])) ?
                                $email = trim($_POST["email"]) : 
                                $email = "";
                (isset($_POST["otp"])) ?
                                $otp = trim($_POST["otp"]) : 
                                $otp = "";
                $password = trim($_POST["password"]);
                $password2 = trim($_POST["password2"]);

                //check error / vaildation
                $error["id"] = checkStudentID($id);
                $error["email"] = checkEmail($email);
                $error["password"] = checkSamePassword($password, $password2);
                $error = array_filter($error);

                if (empty($error)) {
                    //No error
                    //Step1 :connection
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    //step2: sql statement
                    $sql = "UPDATE student_detail SET Password = ? WHERE StudentID = ? AND Email = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("sss", $password, $id, $email);
                    if($stmt->execute()){
                    //Updated successful
                    printf("<span class='successful' style='color:green;'>Student ID : %s Password Had Been Change! <a href='login.php' class='backtologin'>Back To Login</a></span><br><br>",$id);
                }
                $stmt->close();
                $con->close();
                } else {
                    //with error, print error message
                    echo"<ul class='error' style='color:red;'>";
                    foreach ($error as $value) {
                        echo "<li>$value</li>";
                    }
                    echo"</ul><br><br>";
                }
                
            }
            ?>
            <form action="" method="POST">
                <label for="txtID">Student ID :</label>
                <input type="text" id="txtID" name="txtID" placeholder="Enter Your Student ID" value="<?php echo $id; ?>" required>
                <label for="email">REGISTER EMAIL :</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" required><br/>
                <label for="email">OTP :</label>
                <div class="comotp">
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" value="<?php echo $otp; ?>">
                    <button type="submit" class="btnotp" name="btnotp">Get OTP</button>
                </div><br/>
                <label for="password">PASSWORD:</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" ><br/>
                <label for="password2">CONFIRM PASSWORD :</label>
                <input type="password" id="password2" name="password2" placeholder="Cnfirm your new password" ><br/>
                <div class="btnsubcnl">
                    <button type="submit" class="btnchange" name="Change">Change Password</button>
                    <button class="backbtn" id="backbtn" onclick="window.location.href = 'login.php';">Back</button>
                </div>
            </form>
        </div>
    </body>
</html>
