<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Announcement</title>
        <link href="admin_announcement_style.css" rel="stylesheet" type="text/css"/>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        
        <?php
        require_once './config/helper.php';
        ?>
        
        <?php
        //check user input or not?
        global $title;
        global $desc;
        
        
        if(!empty($_POST)){
            //YES, user click insert button 
            //retreive all use input
            (isset($_POST['title']))?
                            $title=trim($_POST['title']):
                            $title="";
            
            (isset($_POST['description']))?
                            $desc= trim($_POST['description']):
                            $desc="";
            
            //check validation 
            $error["title"]=checkTitle($title);
            $error["description"]=checkDesc($desc);
            $error = array_filter($error);
            
            //check if there are any msg in $error
            if(empty($error)){
                //No error,insert record
                $con=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql="INSERT INTO announcement(title_announcement,description) VALUES(?,?)";
                $stmt= $con-> prepare($sql);
                $stmt->bind_param("ss", $title,$desc);
                $stmt->execute();
                
                if($stmt->affected_rows>0){
                    //insert successful
                    printf("<span class='info'>Insert Successful!");
                }
            } else{
                 //With error, display error msg
                    echo"<ul class='inerror'>";
                    foreach($error as $value){
                          echo "<li>$value</li>";
                    }
                    echo"</ul>";
                }
            }
        
        ?>
        
        <form action="" method="POST">
                   
        <div class="desc">
            <h2 style="margin-top:4%;">Edit Events Announcement</h2>
        </div>
        
        <div class="title">
            <label class="tit" for="tit"><b>Title Announcement</b></label>
            <input name="title" id="box" type="text" id="tit" value="<?php echo $title; ?>">
        </div>
        
        <div class="announce">
            <label class="ann" for="ann"><b>Description</b></label>
            <input name="description" style="margin-left:75px"id="box"type="text"value="<?php echo $desc; ?>">
        </div>
            
          <input type="submit" value="ADD" />
          
          <div><a href="announce-detail.php">View Announcement Detail</a></div>

        </form>
        
          
  
    </body>
    
</html>
