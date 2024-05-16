<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
    <head>
        <link href="style.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <title>Header</title>
    </head>
    <script>
        $(document).ready(function(){
    $('#stdbtn').click(function(){
    $('#stddetail').slideToggle();
    });
        });
        
        $(document).ready(function(){
    $('#btnlogout').click(function(){
    $('#surelogout').toggle();
    });
        });
        $(document).ready(function(){
    $('#cancel').click(function(){
    $('#surelogout').hide();
    });
        });
    </script>
    <?php  
        session_start();  
    ?>
    <header>
        
            <img src="lddslogo2.png" width="100" height="63" alt="lddslogo2" class="logo"/>
            <h1 class="headh1">LITERATURE, DANCE & DRAMA SOCIETY</h1>
            <nav class="headnav">
                <a href="announcement.php">Announcement</a>
                <a href="EventPage.php">Event</a>
                <a href="feedback.php">FeedBack</a>
                <a href="orderhistory.php">Add To Cart</a>
                <button class="stdbtn" id="stdbtn"><bold>Student Details</bold></button>
                <?php
                echo "<div id='stddetail' class='stddetail'>";
                echo "<span class='stdheader'>STUDENT DETAILS</span><br>";
                echo"<div class='user'>";
                echo "<span class='insideuser'>User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$_SESSION['Std_Name']."</span>";
                echo "<br>";
                echo "<span class='idshow'>StudentID : ".$_SESSION['Student_ID']."</span>";
                echo "</br></br><a href='MemberDetails.php' class='link-details'><b>Member Details</b></a>";
                echo "</div>";
                echo "</div>";
                ?>
                <button class="btnlogout" id="btnlogout" >Log Out</button>
                <div class="surelogout" id="surelogout">
                    <span>Are You Sure You Want To Log Out?</span>
                    <br><br><br>
                    <button class="sure" id="sure" name="sure" onclick="window.location.href = 'login.php';">Sure</button>
                    <button class="cancel" id="cancel">Cancel</button>
                </div>
            </nav>            
        </header>
    
    <body>
        
    </body>
    
