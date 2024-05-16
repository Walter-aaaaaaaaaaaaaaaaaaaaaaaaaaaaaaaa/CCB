<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="styleedit.css" rel="stylesheet" type="text/css"/>
        <title></title>
    </head>
    <body>
        <?php
       include'./header.php';
        require_once './config/helper.php';
        ?>
        
        <h1>Edit Payment</h1>
        
        <?php
        
        global $hideForm;
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method
            //retreive record and display data in the form 
            //retreive id from URL
            (isset($_GET["account"]))?
            $account= strtoupper(trim($_GET["account"])):
                $account="";
            //Step 1 :connection
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            //Step 2:sql statement
            $sql="SELECT * FROM payment WHERE account_number='$account'";
            //Step 3:run sql
            $result=$con->query($sql);
            
            if($record=$result->fetch_object()){
                //record found
                $name=$record->username;
                $email=$record->email_address;
                $phoneN=$record->phone_number;
                $payment=$record->payment_method;
                $account=$record->account_number;
                $CVC=$record->cvc;
                $date=$record->expired_date;
                $total=$record->total_amount;
            }
            else {
                //record not found
                echo"<div class='error'>Unable to retrieve record!
                     <a href='adminViewPaymentDetail.php'>Back to Detail</a></div>";
                $hideForm=true;
            }
            $result->free();
            $con->close();
        }
        else{
            //post method
            $account= strtoupper(trim($_POST["hdcard-number"]));
            $name=trim($_POST["uname"]);
            $email=trim($_POST["email"]);
            $phoneN=trim($_POST["phone-number"]);
            $payment=trim($_POST["paymentmethod"]);
            $CVC=trim($_POST["cvc"]);
            $date=trim($_POST["day"]);
            
            $error["name"] = checkUserName($name);
            $error["email"] = validateEmail($email);
            $error["phoneN"] = checkPhoneNumber($phoneN);
            $error["payment"] = checkPaymentMethod($payment);
            $error["CVC"] = validateMaybankCVC($CVC);
            $error["date"] = checkDateInput($date);
            $error = array_filter($error);
            
            if(empty($error)){
                //no error
                //Step 1: connect 
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                //Step2:sql
                $sql="UPDATE payment SET username=?,email_address=?,phone_number=?,payment_method=?,cvc=?,expired_date=?
                      WHERE account_number = ? ";
                
                $statement=$con->prepare($sql);
                $statement->bind_param("ssssiss", $name,$email,$phoneN,$payment,$CVC,$date,$account);
                
                if($statement->execute()){
                    //Update successful
                    printf("<div class='info'>Number Account %s has been updated 
                            <a href='adminViewPaymentDetail.php'>Back to Detail</a></div> ",
                            $account);
                }
                else{
                    //Failed to Updated 
                    echo"<div class='error'>Unable to Edit![<a href='adminViewPaymentDetail.php'>Back to Detail</a>]</div>";
                }
                $con->close();
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
                //update record
        }
        
        ?>
        
        <?php if($hideForm==false): ?>
        <form action ="" method="POST">
            <div class="user_acount">
            <input style="width:50%"type="text" name="uname" value="<?php echo $name; ?>" placeholder=" Enter Username" />
            </div>
            
            <div class="user_acount">
            <input style="width:50%;margin-top:25px"type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email Address"/>
            </div>
            
            <div class="user_acount">
            <input style="width:50%"type="text" name="phone-number" value="<?php echo $phoneN; ?>" placeholder=" phone-number"/>
            </div>
            
             <div id="pm">
                        <div class="pm">
                            <?php
                            $allMethod = getAllMethod();
                            foreach ($allMethod as $key => $value) {
                                printf("<input type='radio' name='paymentmethod' id='%s' value='%s' %s>
                                    <label for='%s'><b>%s</b></label>"
                                        , $key, $key,($key==$payment?'checked':''),$key, $value);
                            }
                            ?>
                        </div>
                    </div>
            
            <div class="user_keyin">
            <input type="hidden" id="cardnum" name="hdcard-number" value="<?php echo $account; ?>" placeholder=" Maybank"/>
            </div>
            
            <div class="user_keyin">
            <input type="text" id="cvc" name="cvc" value="<?php echo $CVC; ?>" placeholder=" Enter CVC "/>
            </div>
            
            <div class="user_keyin">
            <input type="date" id="day" name="day" value="<?php echo $date; ?>" placeholder=" Expired Date"/>
            </div>
            
            <div class="user_keyin">
            <input type="text" id="amount" name="amount" value="" placeholder=" RM 0.00" disabled/>
            </div>
            <input type="submit" value="Update" name="btnUpdate"/>
            <input type="button" value="Cancel" name="btnCancel" onclick="location='adminViewPaymentDetail.php'">
        </form>
        <?php endif;?>
        
    </body>
</html>
