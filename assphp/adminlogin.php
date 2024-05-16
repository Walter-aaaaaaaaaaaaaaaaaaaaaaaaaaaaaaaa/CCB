<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <title>Admin Login</title>
        <link href="adminlogin.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="video">
            <video autoplay loop muted plays-inline class="backvideo">
                    <source src="loginvid.mp4" type="video/mp4">
                    Your browser does not support the <code>video</code> tag.
            </video>
        <header>
            <img src="lddslogo2.png" width="100" height="63" alt="lddslogo2" class="logo"/>
            <nav class="headnav">
                <button class="btnloginadmin" id="admin"><bold>Admin</bold></button>
                <button class="btnloginpopup" id="popup" onclick="window.location.href = 'login.php';"><bold>Member</bold></button>
            </nav>
        </header>
            <?php
    require_once './config/login_helper.php';
    ?>
            <?php  
            session_start();  
        ?>
        <?php
        //retreive
        global $id;
        global $password;  
        if(isset($_POST['StaffLogin'])){
            //Yes, user click login button
            //retreive all use input
            (isset($_POST["txtStaffID"]))?
            $id = trim($_POST["txtStaffID"]): $id = "";
            $password = trim($_POST["txtStaffPassword"]);
            
            //check error / vaildation
            $error["id"] = checkStaffID($id);
            $error["password"] = checkStaffPass($password);
            $error = array_filter($error);
            
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM admin WHERE AdminID = '$id' AND Password = '$password'";
            if($result = $con->query($sql)){
            if($result -> num_rows == 1){
               while ($row = $result->fetch_object()){
                $staff_id = $row->AdminID;
                $passwordstaff = $row->Password;  
                $staffname = $row->AdminName;
                $staffemail = $row->Email;
                $role= $row->Role;
            }
            
            $_SESSION['Staff_ID']= $staff_id;
            $_SESSION['PasswordStaff'] = $passwordstaff;
            $_SESSION['Staff_Name'] = $staffname;
            $_SESSION['Staff_Email'] = $staffemail;
            $_SESSION['Staff_Role'] = $role;
            header('location: admin.php');
            }
            else{
                //With error, display error msg
                echo "<ul class='error' style='position:fixed;
                                 width:auto;
                                 height:auto;
                                 padding:30px;
                                 background:lightpink;
                                 border: 2px solid rgba(255,255,255,0.6);
                                 border-radius: 20px;
                                 box-shadow: 0 0 30px rgba(0,0,0,.5);
                                 justify-content: center;
                                 align-items: center;
                                 z-index: 100000000;
                                 color: #fff;
                                 margin-left:-230px;
                                 margin-top: 200px;
                                 list-style-type: none;
                                 '>";
                foreach($error as $value){
                    echo "<li>$value</li>";
                }
                echo "</ul>";
            }
        
        }
        }
        ?>
        <div class="wrapper"> 
            <div class="from-box">
               
                <h2>STAFF LOGIN</h2>
                <form action="#" method="POST">
                    <div class="input">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="text" name="txtStaffID" value="<?php 
                    echo $id; ?>"required>
                        <label>Staff ID</label>
                    </div>
                    <div class="input">
                        <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                        <input type="password" name="txtStaffPassword" required>
                        <label>Password</label>
                    </div>
                    <div class="remember">
                        <label><input type="checkbox">Remember Me</label>
                    </div>
                    <button type="submit" class="btnli" name="StaffLogin">LOGIN</button>
                    
                </form>
            </div>  
        </div>
        </div>
    </body>
</html>
