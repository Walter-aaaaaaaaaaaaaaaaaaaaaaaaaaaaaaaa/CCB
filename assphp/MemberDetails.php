<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Member Details Page</title>
        <link href="member_details.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">

    </head>

    <body>
        <?php
        include './header.php';
        include './config/event_helper.php';
        ?>



        <div class="membership-prop">
            <div class="size-table">

                <div class="title-memberDetails">
                    <h1>Member Details</h1>
                </div>

                <div class="style">
                    <div class="space-table">
                        <form action="" method="POST">
                            <table class="inform-table">  
                                <?php
                                printf("<tr>
                                                    <td>Name:</td>
                                                    <td>%s</td>
                                                </tr>
                                                <tr>
                                                    <td>Student ID:</td>
                                                    <td>%s</td>
                                                </tr>
                                                <tr>
                                                    <td>Programme</td>
                                                    <td>%s</td>
                                                </tr>
                                                <tr>
                                                    <td>Gender:</td>
                                                    <td>%s</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone Number:</td>
                                                    <td>%s</td>
                                                </tr>
                                                <tr>
                                                    <td>Email Address:</td>
                                                    <td>%s</td>
                                                </tr>
                                                <div class='link-EDIT'> 
                                                    <a href='EventViewTicket.php'><b>View Ticket</b></a>
                                                </div>"
                                                , $_SESSION['Std_Name']
                                                , $_SESSION['Student_ID']
                                                , $_SESSION['Program']
                                                , $_SESSION['Gender']
                                                , $_SESSION['Phone']
                                                , $_SESSION['Email']);
                                    
                                ?>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
