<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>
    <head>
        <meta charset="UTF-8">
        <link href="event_page.css" rel="stylesheet" type="text/css"/>
        <title>Event Details Page</title>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
        include'./header.php';
        require_once './config/event_helper.php';
        ?>

        <div class="style-background"> 

            <div class="title-event">
                <h1>Event of our society</h1>
            </div>

            <div class="back-allEvent">

                <form method="POST">
                    <?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,DB_PORT);
                    $sql = "SELECT * FROM event_detail";

                    if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("<div class='background_event_first'>
                                            <div class='event_first'>
                                                <h3>%s</h3>
                                                <p><b>About This Event👆</b><br/>%s</p>
                                                <p><b>Date🗓️</b>: %s</p>
                                                <p><b>Venue📍:</b> %s</p>
                                                <div class='text-center'>
                                                    <a href='order1.php?date=%s' class='link-order'><b>Click here To Order</b></a>
                                                </div>
                                            </div>
                                    </div>"
                                    , $record->EventName
                                    , $record->Description
                                    , $record->EventDate
                                    , $record->EventtVenue
                                    , $record->EventDate);
                        }
                        $result->free();
                        $con->close();
                    }
                    ?>

                </form>
            </div>
        </div>
    </body>
</html>
