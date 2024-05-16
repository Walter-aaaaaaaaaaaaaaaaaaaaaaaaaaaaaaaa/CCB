<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add and delete</title>
        <link href="event_view.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
        require_once './config/event_helper.php';
        ?>
        
        <h1>Event Edit & Delete</h1>
        
        <div class="size-link-add">
            <a href="EventAdd.php" class="link-add">Click Here To Add</a>
        </div>
        
        <?php 
            if(isset($_POST['btnDelete'])){
                (isset($_POST['checked']))?
                $check = $_POST['checked']:
                $check = "";
                    
                if(!empty($check)){
                    
                     $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                     
                     foreach($check as $value){
                        $checkValue[] = $con->real_escape_string($value);
                        
                     }
                     
                     //DELETE FROM student WHERE StudentID IN ('21PMD12345','21PMD12346');
                     
                     $sql = "DELETE FROM event_detail WHERE EventDate IN ('" . implode("','",$checkValue) ."')";
                     
                     if($con->query($sql)){
                         printf("<div class='sucessInsert'>
                                 %d record has been deleted!
                                 </div>",$con->affected_rows);
                     }
                     $con->close();
                }
            }
        ?>
        
        
        <form action="" method="POST" >
            <div class="size-table-dlt">
                <table>
                    <thead>
                        <tr>
                            <th>&nbsp</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT * FROM event_detail";

                    if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("<tbody>
                                    <tr>
                                    <td><input type='checkbox' name='checked[]' value='%s' class='boxDlt'/></td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td><a href='EventEdit.php?date=%s' class='btn-edit'>Edit Event</a></td>
                                    </tr>
                                    </tbody>"
                                    , $record->EventDate
                                    , $record->EventName
                                    , $record->EventDate
                                    , $record->EventtVenue
                                    , $record->EventDate);
                        }
                        $result->free();
                        $con->close();
                    }
                    ?>
                    
                </table>
            </div>
            <input type="submit" value="Delete" name="btnDelete" class="multiDlt"
                   onclick="return confirm('The record that Selected will delete.\nAre you Sure?')"/>
        </form>
    </body>
</html>
