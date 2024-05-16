<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <link href="login.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <title>LOGIN</title>
    </head>

    <body>   

        <?php
        require_once './config/login_helper.php';
        ?>



        <div class="video">
            <video autoplay loop muted plays-inline class="backvideo">
                <source src="loginvid.mp4" type="video/mp4">
                Your browser does not support the <code>video</code> tag.
            </video>
            <header>
                <img src="lddslogo2.png" width="100" height="63" alt="lddslogo2" class="logo"/>
                <nav class="headnav">
                    <button class="btnloginadmin" id="admin" onclick="window.location.href = 'adminlogin.php';">Admin</button>
                    <button class="btnloginpopup" id="popup">Member</button>
                    <button class="registerbtn" id="registerbtn" onclick="window.location.href = 'MemberRegister.php';">Register</button>
                </nav>
            </header>
            <div class="midcontent">
                <h1>LITERATURE, DANCE & DRAMA SOCIETY</h1>
                <?php
                session_start();
                ?>
                <?php
                //retreive
                global $id;
                global $password;
                if (isset($_POST['Login'])) {
                    //Yes, user click login button
                    //retreive all use input
                    (isset($_POST["txtID"])) ?
                                    $id = trim($_POST["txtID"]) : $id = "";
                    $password = trim($_POST["txtPassword"]);

                    //check error / vaildation
                    $error["id"] = checkStudentID($id);
                    $error["password"] = checkStudentPass($password);
                    $error = array_filter($error);

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,DB_PORT);
                    $sql = "SELECT * FROM student_detail WHERE StudentID = '$id' AND Password = '$password'";
                    if ($result = $con->query($sql)) {
                        if ($result->num_rows == 1) {
                            while ($row = $result->fetch_object()) {
                                $student_id = $row->StudentID;
                                $password1 = $row->Password;
                                $name = $row->Std_Name;
                                $email = $row->Email;
                                $gender = $row->Gender;
                                $phonenumber = $row->PhoneNumber;
                                $program = $row->Programme;
                            }

                            $_SESSION['Student_ID'] = $student_id;
                            $_SESSION['Password'] = $password1;
                            $_SESSION['Std_Name'] = $name;
                            $_SESSION['Email'] = $email;
                            $_SESSION['Gender'] = $gender;
                            $_SESSION['Phone'] = $phonenumber;
                            $_SESSION['Program'] = $program;
                            
                            header('location: EventPage.php');
                        } else {
                            //With error, display error msg
                            echo "<ul class='error' style='position:fixed;
                                 width:300px;
                                 height:200px;
                                 background:rgba(0,0,0,0.7);
                                 border: 2px solid rgba(255,255,255,0.6);
                                 border-radius: 20px;
                                 box-shadow: 0 0 30px rgba(0,0,0,.5);
                                 display:none;
                                 justify-content: center;
                                 align-items: center;
                                 z-index: 100000000;
                                 color: #fff;
                                 margin-left:200px;
                                 margin-top: -50px;
                                 list-style-type: none;
                                 '>";
                            foreach ($error as $value) {
                                echo "<li>$value</li>";
                            }
                            echo "</ul>";
                        }
                    }
                }
                ?>
                <a href="#">BELLO</a>
            </div>
        </div>
        <div class="wrapper">
            <span class="close">
                <ion-icon name="close-circle-outline"></ion-icon>
            </span>    
            <div class="from-box">

                <h2>STUDENT LOGIN</h2>
                <form action="" method="POST">
                    <div class="input">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="text" style="color:#fff;" name="txtID" value="<?php echo $id; ?>" required>
                        <label>Student ID</label>
                    </div>
                    <div class="input">
                        <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                        <input type="password" style="color:#fff;" name="txtPassword" required>
                        <label>Password</label>
                    </div>
                    <div class="remember">
                        <label><input type="checkbox">Remember Me</label>
                        <a href="forget.php">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btnli" name="Login">LOGIN</button>
                    <div class="register">
                        <p>Don't have any account? <a href="MemberRegister.php">Register Here</a></p>
                    </div>
                </form>
            </div>  
        </div>
        <script>
            document.getElementById("popup").addEventListener("click", function () {
                document.querySelector(".wrapper").style.display = "flex";
                document.querySelector(".error").style.display = "flex";
            });

            document.querySelector(".close").addEventListener("click", function () {
                document.querySelector(".wrapper").style.display = "none";
                document.querySelector(".error").style.display = "none";
            });
        </script> 
    </body>
</html>