<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Announcement</title>
        <link href="styleedit.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <?php
        
        require_once './config/helper.php';
        ?>
        
        <h1>Edit Announcement</h1>
        
        <?php
        global $hideForm;
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method 
            //retreive record and display data in the form 
            //retrieve id from URL
            (isset($_GET["title"]))?
            $title= strtoupper(trim($_GET["title"])):
                $title="";
            //Step 1 :connection 
            $con= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            //Step 2:sql statement
            $sql="SELECT * FROM announcement WHERE title_announcement='$title'";
            //Step 3:run sql 
            $result=$con->query($sql);
            
            if($record=$result->fetch_object()){
                //record found 
                $title=$record->title_announcement;
                $desc=$record->description;
            }
            else{
                //record not found
                echo"<div class='error'>Unable to retreive record!
                    <a href='announce-detail.php'>Back to Detail</a></div>";
                $hideForm=true;
            }
            $result->close();
            $con->close();
        }
        else{
            //post method
            $title=trim($_POST['hdtitle']);
            $desc=trim($_POST['desc']);
            
            
            
            
            if(empty($error)){
                //no error 
                //Step 1 :connect
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                //Step 2 :sql
                $sql="UPDATE announcement SET description=?
                      WHERE title_announcement=?";
                
                
                $statement=$con->prepare($sql);
                $statement->bind_param("ss",$desc,$title);
                
                if($statement->execute()){
                    //Update successful 
                    printf("<div class='info'>Title of Announcement %s has been updated 
                            <a href='announce-detail.php'>Back to Announcement Detail</a></div> ",
                            $title);
                }
                else{
                    //failed to update
                    echo"<div class='error'>Unable to edit![<a href='announce-detail.php'>Back to Detail</a>]</div>";
                }
                $con ->close();
                $statement->close();
            }
            else{
                //Got error
                echo"<ul class='error'>";
                foreach($error as $value){
                    echo"<li>$value</li>";
                }
                echo"</ul>";
            }
            //updated record
        }
        ?>
        
        <?php if($hideForm==false): ?>
        <form action="" method="POST">
            <div>
                <?php echo $title;?>
                <input type="hidden" name="hdtitle" placeholder="Edit Title" value="<?php echo $title;?> "/>
            </div>
            
            <div>
                <input type="text" name="desc" placeholder="Edit Description" value="<?php echo $desc?>"/>
            </div>
            <input type="submit" value="Update" name="btnUpdate"/>
            <input type="button" value="Cancel" name="btnCancel" onclick="location='announce-detail.php'"/> 
        </form>
        <?php endif; ?>
    </body>
</html>
