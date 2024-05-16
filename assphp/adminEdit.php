<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit admin information</title>
        <link href="editFed.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        
        require_once './config/helperFD.php';
        ?>

        

        <?php
        global $hideForm;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //get Method
        //retreive record and display data in the form
        //retreive id from URL
        (isset($_GET["id"]))?
        $adID = strtoupper(trim($_GET["id"])): 
        $adID = "";

        //Step 1:connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //Step 2:sql statement
        $sql = "SELECT * FROM admin WHERE AdminID='$adID'";

        //step 3:run sql
        $result = $con->query($sql);

        if ($record = $result->fetch_object()) {
        //record found
        $adID = $record->AdminID;
                $adname = $record->AdminName;
                $ademail = $record->Email;
                $role = $record->Role;
                $password = $record->Password;
        } else {
        //record not found
        echo"<div class='Ferror' style='margin-left:35%;'>
                    unable to retreive record!
                    <a href='admin.php'>Back to list</a>
                    </div>";
        $hideForm = true;
        }

        $result->free();
        $con->close();
        } else {
        //post method
        $adID = strtoupper(trim($_POST["adID"]));
        $adname=trim($_POST["adname"]);
        $ademail=trim($_POST["ademail"]);
        $role=trim($_POST["role"]);
        $password=trim($_POST["password"]);


        
        $error["adname"] = checkAdName($adname);
        $error["ademail"] = checkAdEmail($ademail);
        $error["password"] = checkRole($role);
        $error["role"] = checkAdPassword($password);
        
        $error = array_filter($error);

        if(empty($error)){
        //No error
        //Step 1:connect
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //step 2:
        $sql = "UPDATE admin SET AdminName=?,Email=?,Role=?,Password=? WHERE AdminID=?";

        $statement = $con->prepare($sql);
        $statement->bind_param("sssss",$adname, $ademail, $role, $password,$adID);

        if($statement->execute()){
        //Updated sucessful
        printf("<div class='Finfo'>Admin %s has been inserted.<a href='admin.php'>Back to feedback list</a></div>", $adname);

        }else{
        //Failed to update
        echo"<div class='Ferror'>Unable to Edit!
                    [<a href='admin.php'>Return to feedback list</a>]</div>";
        }
        $con->close();
        $statement->close();
        }else{
        echo"<ul class='Ferror'>";
        foreach ($error as $value) {
        echo"<li>$value</li>";
        }
        echo"</ul>";
        //update record
        }
        }
        ?>

        <?php if($hideForm==false): ?>
        <form action="" method="POST">
            <table>
                <h1>Edit Admin</h1>
                <tr>
                    <td>Admin ID:</td>
                    <td><?php echo $adID; ?>
                        <input type="hidden" id="text1" name="adID"  class="EditColumn"  value="<?php echo $adID; ?>"/><br><br>
                    </td>
                </tr>

                <tr>
                    <td>Admin Name:</td>
                    <td><input type="text" name="adname" value="<?php echo $adname; ?>"  class="EditColumn" placeholder="Enter your user name"/><br><br></td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="ademail" value="<?php echo $ademail; ?>"  class="EditColumn" placeholder="Email"/><br><br></td>
                </tr>

                <tr>
                    <td>Admin Role:</td>
                    <td><select name="role" id="adrole" class="EditColumn">
                        <?php
$allRole = getAllRole();
foreach ($allRole as $key => $value){
    printf("<option value='%s'%s>%s</option>",$key,
            ($role == $key) ? "selected" : "",
            $value);
}
?>
                        </select></br><br>
                    </td>
                </tr>

                <tr>
                    <td>Admin password:</td>
                    <td><input type="password" name="password" value="<?php echo $password; ?>" class="EditColumn" placeholder="Password" /><br><br>
        </td>
                </tr>



            </table>
            <input type="submit" value="Update" class="editButton" name="btnUpdate"  />
                    <input type="button" value="Cancel" class="editButton" name="btnCancel" onclick="location = 'admin.php'" />
        </form>
        <?php endif;?>
    </body>
</html>
