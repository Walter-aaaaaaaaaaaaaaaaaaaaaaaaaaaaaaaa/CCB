<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Admin</title>
        <link href="Deletefeedback.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        
        require_once './config/helperFD.php';
        ?>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            //get method,retrieve,record to display

            (isset($_GET["id"])) ?
                            $adID = strtoupper(trim($_GET["id"])) :
                            $adID = "";
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM admin WHERE AdminID='$adID'";
            $result = $con->query($sql);
            if ($record = $result->fetch_object()) {
                //Record found
                $adID = $record->AdminID;
                $adname = $record->AdminName;
                $ademail = $record->Email;
                $role = $record->Role;
                $password = $record->Password;

                printf("<p>Are you sure want ot delete the following Admin record?</p>
                        <table>
                        <h1>Delete Admin</h1>
                        <tr>
                        <td>Admin ID:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Admin Name:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Email:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Role of Admin:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Password</td>
                        <td>%s</td>
                        </tr>
                                                </table><br><br>
                        
                        <form action='' method='POST'>
                        <input type='hidden' name='adID' value='%s'/>
                        <input type='hidden' name='hdName' value='%s'/>
                        <input type='submit' value='Delete' class='deleteButton' name='btnFDelete'/>
                        <input type='button' value='Cancel' class='deleteButton' name='btnFCancel' onclick='location=\"admin.php\"'/>
                        </form>", $adID, $adname, $ademail, getAllRole()[$role], $password, $adID, $adname
                );
            } else {
                //Record not found
                echo"<div class='Ferror'>
                    unable to retreive record!
                    <a href='admin.php'>Back to list</a>
                    </div>";
            }
        } else {
            //post method,delete record
            //delete record
            //retreive PK
            $adID = strtoupper(trim($_POST["adID"]));
            $adname = trim($_POST["hdName"]);

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "DELETE FROM admin WHERE AdminID=?";

            $stmt = $con->prepare($sql);

            $stmt->bind_param('s', $adID);

            if ($stmt->execute()) {
                //deleted
                printf("<div class='Finfo'>Admin %s has been deleted.<a href='admin.php'>Back to admin list</a></div>", $adname);
            } else {
                //unable to delete
                echo"<div class='Ferror'>Admin Unable to delete![<a href='admin.php'>Back to list</a>]</div>";
            }
            $con->close();
            $stmt->close();
        }
        ?>

    </body>
</html>
