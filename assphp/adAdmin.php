<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Register Form</title>
        <link href="adregister.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">

    </head>
    <body>
        <?php
        
        require_once './config/helperFD.php';
        ?>

        <?php
        global$adID;
        global$adname;
        global$ademail;
        global$role;
        global$password;
        
        if (!empty($_POST)) {
            (isset($_POST["adID"])) ?
                            $adID = trim($_POST["adID"]) :
                            $adID = "";
            (isset($_POST["adname"]))?
            $adname=trim($_POST["adname"]):
                $adname="";
            (isset($_POST["ademail"]))?
            $ademail=trim($_POST["ademail"]):
                $ademail="";
            (isset($_POST["role"]))?
            $role=trim($_POST["role"]):
                $role="";
            (isset($_POST["password"]))?
            $password=trim($_POST["password"]):
                $password="";
            
            //validation input
            $error["adID"] = checkAdminID($adID);
            $error["adname"] = checkAdName($adname);
            $error["ademail"] = checkAdEmail($ademail);
            $error["role"] = checkRole($role);
            $error["password"] = checkAdPassword($password);
            $error=array_filter($error);
            
            if(empty($error)){
                //No ERROR,INSERT RECORD
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $sql="INSERT INTO admin(AdminID,AdminName,Email,Role,Password)
                    VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssss", $adID,$adname, $ademail,$role, $password);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                        //Insert Sucessful
                        printf("<div class='Finfo'>Admin %s has been inserted.<a href='admin.php'>Back to list</a></div>", $adname);
                    } else {
                        echo'<div class="Ferror">Unable to insert!
                    (<a href="admin.php">Back to list</a>)</div>';
                    }
            }else{
                //WITH ERROR,DISPLAY ERROR MSG  
                    echo'<ul class="Ferror">';
                    foreach ($error as $value) {
                        echo"<li>$value</li>";
                        
                        //get is directly give
                        //
            }
            echo"</ul>";
            }
        }
        ?>
        <div class="bck-size-ad">
            <form action="" method="POST">
                
                <h1>Add Admin</h1>

                <div class="adID">
                    <input type="text" name="adID" class="radtext" value="<?php echo $adID; ?>" placeholder="Staff ID"/>
                </div>

                <div class="adname">
                    <input type="text" name="adname" value="<?php echo $adname; ?>" class="radtext" placeholder="Enter your user name"/>
                </div>

                <div class="ademail">
                    <input type="email" name="ademail" value="<?php echo $ademail; ?>" class="radtext" placeholder="Email"/>
                </div>
                
                
                <div>
                    <label for="role">Admin Role:</label>
                    <select name="role" id="adrole">
                        <?php
$allRole = getAllRole();
foreach ($allRole as $key => $value){
    printf("<option value='%s'%s>%s</option>",$key,
            ($role == $key) ? "selected" : "",
            $value);
}
?>

                    </select></br>

                <div class="radpassword">
                    <input type="password" name="password" value="<?php echo $password; ?>" class="radtext" placeholder="Password" />
                </div>



                

                <div class="rsubmit">
                    <input type="submit" name="" class="radregister" value="Add Admin" /><br>
                    <input type="reset"  id="" value="Cancel" onclick="location = 'admin.php'"/>
                </div>





            </form>
        </div>
    </body>
</html>
