<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete feedback</title>
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
                            $FbID = strtoupper(trim($_GET["id"])) :
                            $FbID = "";
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM feedback WHERE FeedbackID='$FbID'";
            $result = $con->query($sql);
            if ($record = $result->fetch_object()) {
                //Record found
                $FbID = $record->FeedbackID;
                $sname = $record->StudentName;
                $semail = $record->Email;
                $sevent = $record->TypeOfevent;
                $feeling = $record->Feeling;
                $sfeedback = $record->Feedback;

                printf("
                    
                        <p>Are you sure want ot delete the following feedback record?</p>
                        <table>
                        <h1>Delete feedback</h1>
                        <tr>
                        <td>Feedback ID:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Student Name:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Email:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Type Of Event:</td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>Do you this this activity is wonderful? </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td>comment:</td>
                        <td>%s</td>
                        </tr>
                        </table><br><br>
                        
                        <form action='' method='POST'>
                        <input type='hidden' name='FbID' value='%s'/>
                        <input type='hidden' name='hdName' value='%s'/>
                        <input type='submit' value='Delete' class='deleteButton' name='btnFDelete'/>
                        <input type='button' value='Cancel' class='deleteButton' name='btnFCancel' onclick='location=\"list-feedback.php\"'/>
                        
                        </form>", $FbID, $sname, $semail, getAllEvent()[$sevent], getAllFeeling()[$feeling], $sfeedback, $FbID, $sname
                
                        );
            } else {
                //Record not found
                echo"<div class='Ferror'>
                    unable to retreive feedback record!
                    <a href='list-feedback.php'><b>Back to list</b></a>
                    </div>";
            }
        } else {
            //post method,delete record
            //delete record
            //retreive PK
            $FbID = strtoupper(trim($_POST["FbID"]));
            $sname = trim($_POST["hdName"]);

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "DELETE FROM feedback WHERE FeedbackID=?";

            $stmt = $con->prepare($sql);

            $stmt->bind_param('s', $FbID);

            if ($stmt->execute()) {
                //deleted
                printf("<div class='Finfo'>feedback student %s has been deleted.<a href='list-feedback.php'>Return to feedback list</a></div>", $sname);
            } else {
                //unable to delete
                echo"<div class='error'>feedback Unable to delete![<a href='list-feedback.php'>Back to list</a>]</div>";
            }
            $con->close();
            $stmt->close();
        }
        ?>

    </body>
</html>
