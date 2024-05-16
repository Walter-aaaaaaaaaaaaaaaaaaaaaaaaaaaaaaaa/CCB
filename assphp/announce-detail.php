<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Announcement Detail</title>
        <link href="announce-detail-style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
       <?php
       require_once'./config/helper.php';
       
       //array map between table field name & table
       //display name
       $header =array(
           'title_announcement'=>'Title Of The Announcement',
           'description'=>'Description Of the Announcement'
       );
       
       //check $sort $order variable -> prevent sql error
       //which column to sort
       global $sort,$order;
       
       if(isset($_GET['sort'])&& isset($_GET['order'])){
           $sort=(array_key_exists($_GET['sort'], $header)?
                   $_GET['sort']:'title_announcement');
       }
       
       if(isset($_GET["title_announcement"])){
           $title=(array_key_exists($_GET["title_announcement"],
                   checkTitle($title))
                   ?$_GET['title_announcement']:"%");
       }
       else {
           $title="%";
       }
       ?>
      
        <?php
        
        
        if(isset($_POST['btnDelete'])){
            (isset($_POST['checked']))?
            $check=$_POST['checked']:
                $check="";
            if(!empty($check)){
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                foreach($check as $value){
                    $checkvalue[]=$con->real_escape_string($value);
                }
                $sql="DELETE FROM announcement WHERE title_announcement IN ('".implode("','",$checkvalue)."')";
                
                if($con->query($sql)){
                    printf("<div class='info'>%d records have been deleted</div>",$con->affected_rows);
                }
                $con->close();
            }
        }
        ?>
        <h1 style="margin-top: 8%;margin-left: 43%;">Announcement Detail</h1>
        <form action="" method="POST">
            <table border="1">
                <tr>
                    <?php
                    
                    
                    foreach($header as $key=>$value){
                    printf('<th>
                            %s 
                            </th>',$value);}
                    
                    ?>
                    <th>&nbsp;</th>
                </tr>
                
                <?php
                //step 2 :link php app with database
                //object-oriented method
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                //step 3 : sql statement
                $sql="SELECT * FROM announcement WHERE title_announcement LIKE'$title'";
                
                //step 4 :execute / run sql 
                if($result =$con->query($sql)){
                    
                    //record found
                    while($record=$result->fetch_object()){
                        
                        printf("<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td><a class='link' href='delete-announce.php?title=%s'>Delete</a>|
                                    <a class='link' href='edit-announce.php?title=%s'>Edit</td>?
                                </tr>",$record->title_announcement,
                                       $record->description,
                                       $record->title_announcement,
                                       $record->title_announcement);
                    }
                    printf("<tr><td colspan='3'>%d records returned."."<a class='link' href='admin_announcement.php']>
                            Add announcement</a></td></tr>",$result->num_rows);
                    $result->free();
                    $con->close();
                }
                ?>
                
            </table>
            
        </form>
    </body>
</html>
