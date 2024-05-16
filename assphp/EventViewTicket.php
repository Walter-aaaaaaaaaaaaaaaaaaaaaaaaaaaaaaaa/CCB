<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Event Ticket</title>
        <link href="event_ticket.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        
        <?php
        include'./header.php';
        require_once './config/event_helper.php';

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT * FROM event_detail";
        
        if ($result = $con->query($sql)) {
            while ($record = $result->fetch_object()) {
                printf("<div class='ticket'>
                            <div class='left'>
                                <div class='image'>
                                    <div class='ticket-number'>
                                        <p class='number'>
                                            #20230412
                                        </p>
                                </div>
                            </div>
                            <div class='ticket-info'>
                                <p class='date'>
                                <span>%s</span>
                                </p>
                    
                            <div class='show-time'>
                                <h1>%s</h1>
                            </div>
                    
                            <div class='time'>
                                <p>%s</p>
                            </div>
                                <p class='location'>
                                <span>%s</span>
                                </p>
                            </div>
                            </div>
                            
                            <div class='right'>
                                <div class='right-info-container'>
                                    <div class='show-name'>
                                        <h1>%s</h1>
                                    </div> 
                                    <div class='time'>
                                        <p>%s</p>
                                    </div>
                                    <div class='barcode'>
                                        <img src='barcode.png'/>
                                    </div>
                                    
                                </div>
                            </div>
                            </div>"
                        , $record->EventDate
                        , $record->EventName
                        , $record->EventTime
                        , $record->EventtVenue
                        , $record->EventName
                        , $record->EventTime);
            }
            $result->free();
            $con->close();
        }
        ?>

    </body>
</html>
