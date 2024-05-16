<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Announcement</title>
        <link href="styledelete.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        
        require_once './config/helper.php';
        ?>
        
        <h2>Delete Announcement</h2>
        <?php
        
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method, retrieve record to display 
            (isset($_GET["title"]))?
            $title=trim($_GET["title"]):
            $title="";
            
            $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql="SELECT * FROM announcement WHERE title_announcement ='$title'";
            
            $result=$con->query($sql);
            if($record =$result->fetch_object()){
                //record found
                $title=$record->title_announcement;
                $desc=$record->description;
                
                printf("<p>Are you sure you want to delete the following announcement?</p>
                         <table border='1'>
                         
                         <tr>
                         <td>Title Announcement:</td>
                         <td>%s</td>
                         </tr>
                         
                         <tr>
                         <td>Description</td>
                         <td>%s</td>
                         </tr>
                         
                         </table>
                         
                         <form action='' method='POST'>
                         <input type='hidden' name='hdtitle' value='%s'/>
                         <input type='submit' value='Delete' name='btnDelete'/>
                         <input type='button' value='Cancel' name='btnCancel' onclick='location=\"admin_announcement.php\"'/>
                         </form>",$title,$desc,$title);
            }
            else {
                //Record not found
                echo"<div class='error'>Unable to retrieve record!<a href='admin_announcement.php'>Back to Detail</a></div>";
            }
        }
        else{
            //Post method,delete record 
            //retreive primary key
            $title=trim($_POST['hdtitle']);
            
            $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql="DELETE FROM announcement WHERE title_announcement=?";
            
            $stmt=$con->prepare($sql);
            
            $stmt->bind_param('s', $title);
            
            if($stmt->execute()){
                //deleted
                printf("<div class='info'>%s has been deleted!
                         [<a href='admin_announcement.php'>Back to detail</a>
                         </div>",$title);
            }
            else{
                //Unable to delete 
                echo"<div class='error'>Unable to delete!
                      [<a href='admin_announcement.php'>
                      Back to Detail</a>]
                      </div>";
            }
            $con->close();
            $stmt->close();
        }
        ?>
    </body>
</html>
