<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit member Feedback</title>
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
        $FbID = strtoupper(trim($_GET["id"])): 
        $FbID = "";

        //Step 1:connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //Step 2:sql statement
        $sql = "SELECT * FROM feedback WHERE FeedbackID='$FbID'";

        //step 3:run sql
        $result = $con->query($sql);

        if ($record = $result->fetch_object()) {
        //record found
        $FbID = $record->FeedbackID;
        $sname = $record->StudentName;
        $email = $record->Email;
        $event = $record->TypeOfevent;
        $feeling = $record->Feeling;
        $comment = $record->Feedback;
        } else {
        //record not found
        echo"<div class='Ferror'style='margin-left:35%;'>
                    unable to retreive feedback record!
                    <a href='list-feedback.php'><b>Back to list</b></a>
                    </div>";
        $hideForm = true;
        }

        $result->free();
        $con->close();
        } else {
        //post method
        $FbID = strtoupper(trim($_POST["FbID"]));
        $sname = trim($_POST["sdfname"]);
        $email = trim($_POST["semail"]);
        $event = trim($_POST["sEvent"]);
        $feeling = trim($_POST["sfeeling"]);
        $comment = trim($_POST["feedback"]);

        
        $error["sname"] = checkStudentName($sname);
        $error["email"] = checkEmail($email);
        $error["event"] = checkEvent($event);
        $error["feeling"] = checkFeeling($feeling);
        $error["comment"]=checkFeedback($comment);
        $error = array_filter($error);

        if(empty($error)){
        //No error
        //Step 1:connect
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //step 2:
        $sql = "UPDATE feedback SET StudentName=?,Email=?,TypeOfevent=?,Feeling=?,Feedback=? WHERE FeedbackID=?";

        $statement = $con->prepare($sql);
        $statement->bind_param("ssssss",$sname, $email, $event, $feeling, $comment,$FbID);

        if($statement->execute()){
        //Updated sucessful
        printf("<div class='Finfo'>Feedback student %s  has been Edited.<a href='list-feedback.php'>Return to feedback list</a></div>", $sname);

        }else{
        //Failed to update
            echo"<div class='Ferror' >Feedback Record Unable to Edit!
                    [<a href='list-feedback.php'>Back to feedback list</a>]</div>";
        }
        $con->close();
        $statement->close();
        }else{
        echo"<ul class='error'>";
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
                
                <h1>Edit student feedback</h1>
                <tr>
                    <td>Feedback ID:</td>
                    <td><?php echo $FbID; ?>
                        <input type="hidden" id="text1" name="FbID" class="EditColumn" value="<?php echo $FbID; ?>"/><br><br>
                    </td>
                </tr>

                <tr>
                    <td>Student Name:</td>
                    <td><input type="text" id="text1" name="sdfname" class="EditColumn" value="<?php echo $sname; ?>"/><br><br></td>
                </tr>

                <tr>
                    <td>Email:</td>
                    <td><input type="email" id="edate" name='semail' class="EditColumn"  value="<?php echo $email; ?>"><br><br></td>
                </tr>

                <tr>
                    <td>Type Of Event:</td>
                    <td><select name="sEvent" id="event" class="EditColumn">
                        <?php
        $allEvent = getAllEvent();
        foreach ($allEvent as $key => $value) {
        printf("<option value='%s'%s>%s</option>", $key,
        ($event == $key) ? "selected" : "",
        $value);
        }
        ?>
                        </select><br><br>
                    </td>
                </tr>

                <tr>
                    <td>Do you think this activity is wonderful?:</td>
                    <td><?php
                        $allFeeling = getAllFeeling();
                        foreach ($allFeeling as $key => $value) {
                        printf(" <input type='radio' name='sfeeling' value='%s' %s/>%s", $key,
                        ($feeling == $key) ? 'checked' : '',
                        $value);
                        }
        ?><br><br></td>
                </tr>

                <tr>
                    <td>comment:</td>
                    <td><input type="text" name="feedback" class="EditColumn" value="<?php echo $comment; ?>"><br><br></td>
                </tr>


            </table>
            <input type="submit" value="Update" class="editButton" name="btnUpdate" />
                    <input type="button" value="Cancel" class="editButton" name="btnCancel" onclick="location = 'list-feedback.php'" />
        </form>
        <?php endif;?>
    </body>
</html>
