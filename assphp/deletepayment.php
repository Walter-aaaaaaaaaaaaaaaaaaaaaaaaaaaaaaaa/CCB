<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete-Payment</title>
        <link href="styledelete.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        
        require_once './config/helper.php';
        ?>
        
        <h2>Delete Payment</h2>
        <?php
        
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method, retreive record to display
            (isset($_GET["account"]))?
            $account= strtoupper(trim($_GET["account"])):
            $account="";
            
            $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql="SELECT * FROM payment WHERE account_number ='$account'";
            
            $result = $con->query($sql);
            if($record = $result->fetch_object()){
                //Record found
                $name=$record->username;
                $email=$record->email_address;
                $phoneN=$record->phone_number;
                $payment=$record->payment_method;
                $account=$record->account_number;
                $CVC=$record->cvc;
                $date=$record->expired_date;
                $total=$record->total_amount;
                
                printf("<p>Are you sure you want to delete the following payment?</p>
                        <table border='1'>
                        
                        <tr>
                        <td>User Name:</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>Email Address</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>Phone Number</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>Payment Method</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>Account Number</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>CVC</td>
                        <td>%d</td>
                        </tr>
                        
                        <tr>
                        <td>Expired Date</td>
                        <td>%s</td>
                        </tr>
                        
                        <tr>
                        <td>Total Amount</td>
                        <td>%d</td>
                        </tr>
                        
                        </table>
                        <form action='' method='POST'>
                        <input type='hidden' name='hdaccount' value='%s'/>
                        <input style=' font-weight: bold;'type='submit' value='Delete' name='btnDlt'/>
                        <input style=' font-weight: bold;'type='button' value='Cancel' name='btnCancel' onclick='location=\"adminViewPaymentDetail.php\"'/>
                        </form>",$name,$email,$phoneN,$payment,$account,$CVC,$date,$total,$account);
                
            }
            else{
                //Record Not Found
                echo"<div class='error'>Unable to retrieve record!<a href='adminViewPaymentDetail.php'>Back to Detail</a></div>";
            }
        }
        else{
            //POST method, delete record
            //retreive primary key 
            $account= strtoupper(trim($_POST['hdaccount']));
            
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql="DELETE FROM payment WHERE account_number =?";
            
            $stmt=$con->prepare($sql);
            
            $stmt->bind_param('s',$account);
            
            if($stmt->execute()){
                //deleted
                 printf("<div class='info'>Account Number %s has been deleted
                            <a href='adminViewPaymentDetail.php'>Back to Detail</a>
                            </div>",$account);
            }
            else{
                //unable to delete
                echo"<div class='error'>Unable to delete!!!
                        [<a href='adminViewPaymentDetail.php'>
                        Back To Payment Detail</a>]
                        </div>";
            }
            $con->close();
            $stmt->close();
        }
        
        ?>
    </body>
</html>
