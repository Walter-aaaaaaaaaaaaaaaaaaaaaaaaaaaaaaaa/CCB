<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Event</title>
        <link href="event_add.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>

    <body>
        <?php
        require_once './config/event_helper.php';
        ?>

        <?php
        global $event, $desc, $date, $venue;

        if(!empty($_POST)){

            (isset($_POST["newEvent"]))?
            $event = trim($_POST["newEvent"]):
            $event = "";

            (isset($_POST["eDesc"]))?
            $desc = trim($_POST["eDesc"]):
            $desc = "";

            (isset($_POST["eDate"]))?
            $date = $_POST["eDate"]:
            $date = "";

            (isset($_POST["eVenue"])) ?
            $venue = trim($_POST["eVenue"]):
            $venue = "";

            //check error
            $error["event"] = checkEventName($event);
            $error["desc"] = checkDescription($desc);
            $error["date"] = checkEventDate($date);
            $error["venue"] = checkVenue($venue);
            $error = array_filter($error);

            if(empty($error)){
                //NO error
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $sql = "INSERT INTO event_detail(EventName,Description,EventDate,EventtVenue)
                        VALUES(?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssss",$event,$desc,$date,$venue);
                $stmt->execute();
                
                //sucessfully
                if($stmt->affected_rows > 0){
                    //insert successfully
                    printf("<div class='mbInfo'>Event <b>%s</b> has been inserted
                            |<a href='EventPage.php' class='return-page'>Event Page</a>|
                            </div>",$event);
                    
                //unsucessful
                }else{
                    echo"<div class='mbError'>Unable to Insert!
                        [<a href='EventAdd.php'>Back To Event Add Page</a>])
                    </div>";
                }
                
            }else{
                //have error
                echo"<ul class='mbError'>";
                foreach ($error as $value) {
                    echo"<li class='mbErrorText'>$value</li>";
                }
                echo"</ul>";
            }
        }
        ?>


        <form action="" method="POST">
            <div class="size-table-add">
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">New Event Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>New Event :</th>
                            <td><input type="text" name="newEvent" placeholder="Enter Event Name" value="<?php echo $event;?>" class="box-newEvent"/></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><input type="text" name="eDesc" placeholder="Enter Event Descripton" value="<?php echo $desc;?>" class="box-newEvent"/></td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td><input type="date" name="eDate" value="<?php echo $date;?>" class="box-newEvent"/></td>
                        </tr>
                        <tr>
                            <th>Venue:</th>
                            <td><input type="text" name="eVenue" placeholder="Enter Event Venue" value="<?php echo $venue;?>" class="box-newEvent"/></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="backsize-btn">
                <input type="submit" value="Submit" class="btn-submit-event-submit"/>
                <input type="reset" value="Reset" class="btn-submit-event-reset"/>
            </div>

        </form>
    </body>
</html>
