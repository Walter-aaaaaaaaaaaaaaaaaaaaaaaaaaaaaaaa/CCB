<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Announcement</title>
        <link href="announcementstyle.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
        
        
    </head>
    <body>
        <?php
        include'./header.php';
        require_once './config/helper.php';
        ?>
        
        <?php
        $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        $sql="SELECT * FROM announcement";
        
        if($result=$con->query($sql)){
            //record found
            while($record=$result->fetch_object()){
            printf("<div class='storing'>
                    <h1 class='head1'>%s</h1>
                    <div class='announce'><h2>%s</h2></div>
                    </div>
                    ",$record->title_announcement,
                      $record->description);
            }
            $result->free();
            $con->close();        
        }
         ?>
        
        <div class="keep">
        <div class="slider">
            <figure>
                <img id="img1" src="Image1.jpg" alt=""/>
                <img id="img2" src="Image2.jpg" alt=""/>
                <img id="img3" src="Image3.jpg" alt=""/>
                <img id="img1" src="Image1.jpg" alt=""/>
                
                
            </figure>
        </div>
            </div>
    </body>
</html>
