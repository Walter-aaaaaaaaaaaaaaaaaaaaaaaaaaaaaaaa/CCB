<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Member Edit Page</title>
        <link href="event_edit.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
            include'./header.php';
            require_once './config/event_helper.php';
        ?>
        
        <?php
            global $hideForm;
            
            if($_SERVER["REQUEST_METHOD"]=="GET"){
                //retreive and display
                (isset($_GET["date"]))?
                $date = strtoupper(trim($_GET["date"])):
                $date = "";
                
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                $sql = "SELECT * FROM event_detail WHERE EventDate = '$date'";
                $result = $con->query($sql);
                
                if($record = $result->fetch_object()){
                //record found
                    $event = $record-> EventName;
                    $desc = $record-> Description;
                    $date = $record->EventDate;
                    $venue = $record->EventtVenue;
                    
                    
                }else{
                    echo "<div class='mbError'>
                          Unable to retrieve record!
                          <a href='EventView.php' class='editLink'>Back to Event View</a>
                          </div>";
                    $hideForm = true;
                }
                $result->free();
                $con->close();
            
            }else{
                //POST method
                
                $event = trim($_POST["newEvent"]);
                $desc = trim($_POST["eDesc"]);
                $date = $_POST["hdDate"];
                $venue = trim($_POST["eVenue"]);

               //check error
                $error["event"] = checkEventName($event);
                $error["desc"] = checkDescription($desc);
                $error["venue"] = checkVenue($venue);
                $error = array_filter($error);
                
                if(empty($error)){
                    //no error
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    $sql = "UPDATE event_detail SET EventName = ?,Description = ?,EventtVenue = ?
                            WHERE EventDate = ?";
                    $statement = $con->prepare($sql);
                    $statement->bind_param("ssss", $event,$desc,$venue,$date);
                    
                    if($statement->execute()){
                    //Updated sucessful
                    printf("<div class='sucessInsert'>Event in date %s has been edited.
                            <a href='EventView.php' class='editLink'>Back to Event View</a>
                            </div>",$date);
                    }else{
                    //Failed to Updated
                        echo"<div class='errorRecord'>Unable to Edit!
                            <a href='EventView.php'>Back To Event View</a>
                            </div>";
                    }
                    $con->close();
                    $statement->close();
                
                }else{
                    //Got error
                    echo"<ul class='mbError'>";
                        foreach($error as $value){
                            echo"<li>$value</li>";
                        }
                    echo"</ul>";
                }
                
            }
        ?>
        
        <?php if($hideForm == false) :  ?>
        <form action="" method="POST">
            <div class="background-edit">

                <div class="title-edit">
                    <h1>Edit Event Details</h1>
                </div>

                <table class="table-edit">

                    <tr>
                        <td>New Event Name</td>
                        <td><input type="text" name="newEvent" placeholder="Enter your Event Name" class="inputBox-size" value="<?php echo $event;?>"/>  </td>
                    </tr>
                    
                    <tr>
                        <td>New Event Description</td>
                        <td><input type="text" name="eDesc" placeholder="Enter your Description" class="inputBox-size" value="<?php echo $desc;?>"/>  </td>
                    </tr>

                    <tr>
                        <td>Date</td>
                        <td><?php echo $date;?>
                            <input type="hidden" name="hdDate" value="<?php echo $date ?>" /></td>
                    </tr>

                    <tr>
                        <td>New Event Venue</td>
                        <td><input type="text" name="eVenue" placeholder="Enter your New Venue" class="inputBox-size" value="<?php echo $venue;?>"/></td>
                    </tr>

                 
                </table>

                <div>
                    <input type="submit" value="Confirm" class="edit-btn"/>
                    <input type="reset" value="Reset" class="reset-btn"/>
                </div>

            </div>
        </form>    
        <?php endif; ?>
        
    </body>
</html>
