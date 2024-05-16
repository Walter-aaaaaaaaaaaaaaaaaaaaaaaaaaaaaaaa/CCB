<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add and delete</title>
        <link href="memberEditDelete.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
        require_once './config/event_helper.php';
        ?>
               
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
                     
                     $sql = "DELETE FROM student_detail WHERE StudentID IN ('" . implode("','",$checkValue) ."')";
                     
                     if($con->query($sql)){
                         printf("<div class='sucessInsert'>
                                 %d record has been deleted!
                                 </div>",$con->affected_rows);
                     }
                     $con->close();
                }
            }
        ?>
        
        <h1>Member Edit & Delete</h1>
        
        <form action="" method="POST" >
            <div class="size-table-dlt">
                
                <table>
                    <thead>
                        <tr>
                            <th>&nbsp</th>
                            <th>Member Name</th>
                            <th>Student ID</th>
                            <th>Password</th>
                            <th>Phone Number</th>
                            <th>Gender</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT * FROM student_detail";

                    if ($result = $con->query($sql)) {
                        while ($record = $result->fetch_object()) {
                            printf("<tbody>
                                    <tr>
                                    <td><input type='checkbox' name='checked[]' value='%s' class='boxDlt'/></td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td><a href='MemberEdit.php?id=%s' class='btn-edit'>Edit Member</a></td>
                                    </tr>
                                    </tbody>"
                                    , $record->StudentID
                                    , $record->Std_Name
                                    , $record->StudentID
                                    , $record->Password
                                    , $record->PhoneNumber
                                    , $record->Gender
                                    , $record->StudentID);
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
