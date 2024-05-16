<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Feedback</title>
        <link href="fdb.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>

    <body>
        <?php
        include'./header.php';
        require_once './config/helperFD.php';
        ?>


        <div id="allcolumn">


            <?php
            global$FbID;
            global$sname;
            global$email;
            global$event;
            global$feeling;
            global$comment;

            if (!empty($_POST)) {
                
                (isset($_POST["sdfname"])) ?
                                $sname = trim($_POST["sdfname"]) :
                                $sname = "";
                (isset($_POST["semail"])) ?
                                $email = trim($_POST["semail"]) :
                                $email = "";
                (isset($_POST["sEvent"])) ?
                                $event = trim($_POST["sEvent"]) :
                                $event = "";
                (isset($_POST["sfeeling"])) ?
                                $feeling = trim($_POST["sfeeling"]) :
                                $feeling = "";
                (isset($_POST["feedback"])) ?
                                $comment = trim($_POST["feedback"]) :
                                $comment = "";

                //check error input/validation
                
                $error["sname"] = checkStudentName($sname);
                $error["email"] = checkEmail($email);
                $error["event"] = checkEvent($event);
                $error["feeling"] = checkFeeling($feeling);
                $error["comment"]=checkFeedback($comment);
                $error = array_filter($error);

                if (empty($error)) {
                    //NO ERROR,INSRERT RECORD
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    
                    $sql="SELECT MAX(feedbackID) FROM feedback";
                    $result=$con->query($sql);
                    $lineID=$result->fetch_row();
                    $mx_id=$lineID[0];
                    
                    $FbID=$mx_id+1;
                    
                    $sql = "INSERT INTO Feedback(FeedbackID,StudentName,Email,TypeOfevent,Feeling,Feedback)
                        VALUES(?,?,?,?,?,?)";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("ssssss", $FbID,$sname, $email, $event, $feeling, $comment);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        //Insert Sucessful
                        printf("<div class='Finfo'>Feedback Success</div>");
                    } else {
                        echo'<div class="Ferror">Unable to insert!
                    (<a href="feedback.php">Back to list</a>)</div>';
                    }
                } else {
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


            <form action="" method="POST">  

                <h1>Feedback</h1>
                

                <div class="colum1">
                    <label for="sdfname">Name:</label></br>
                    <input type="text" id="text1" name="sdfname" class="text1" value="<?php echo $sname; ?>"placeholder="Your name..."/></br></br>
                </div>


                <div>
                    <label for="edate">Email:</label></br>
                    <input type="email" id="edate" class="text1" name="semail" value="<?php echo $email; ?>"></br></br>
                </div>

                <div>
                    <label for="tevent">Type of event:</label>
                    <select name="sEvent" id="event">
<?php
$allEvent = getAllEvent();
foreach ($allEvent as $key => $value) {
    printf("<option value='%s'%s>%s</option>",$key,
            ($event == $key) ? "selected" : "",
            $value);
}
?>
                    </select></br></br>


                </div>

                <p>Do you think this activity is wonderful?</p>
                <div id="gradio">
<?php
$allFeeling = getAllFeeling();
foreach ($allFeeling as $key => $value) {
    printf(" <input type='radio' name='sfeeling' value='%s' %s/>%s", $key,
            ($feeling == $key) ? 'checked' : '',
            $value);
}
?>

                </div></br>

                




                <div>
                    <textarea id="feedback" name="feedback" row="50"
                              cols="60" placeholder="Any comment or suggestion?" value="<?php echo $comment; ?>"></textarea></br></br>
                </div>


                <div>
                    <input type="reset" id="fsubmit" value="Reset feedback">
                    <input type="submit" id="fsubmit" class="submit2" value="Send feedback" >
                </div>


            </form>
    </body>

</html>
