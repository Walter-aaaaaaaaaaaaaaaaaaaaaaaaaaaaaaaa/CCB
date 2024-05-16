
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment</title>
        <link href="Payment.css" rel="stylesheet" type="text/css"/>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        <?php
        include './header.php';
        require_once './config/helper.php';
        ?>
       

        <?php
        //check if button clicked? or user input data?
        global $name;
        global $email;
        global $phoneN;
        global $payment;
        global $account;
        global $CVC;
        global $date;
        global $total;

        if (!empty($_POST)) {
            //Yes, user click insert button
            //retreive all use input
            (isset($_POST["uname"])) ?
                            $name = trim($_POST["uname"]) :
                            $name = "";

            (isset($_POST["email"])) ?
                            $email = trim($_POST["email"]) : 
                            $email = "";
            
            (isset($_POST["phone-number"])) ?
                            $phoneN = trim($_POST["phone-number"]) :
                            $phoneN = "";
            
            (isset($_POST["paymentmethod"])) ?
                            $payment = trim($_POST["paymentmethod"]) :
                            $payment = "";
            
            (isset($_POST["card-number"])) ?
                            $account = trim($_POST["card-number"]) :
                            $account = "";
            
            (isset($_POST["cvc"])) ?
                            $CVC = trim($_POST["cvc"]) : 
                            $CVC = "";
            
            (isset($_POST["day"])) ?
                            $date = trim($_POST["day"]) : 
                            $date = "";
            
            (isset($_POST["amount"])) ?
                            $total = trim($_POST["amount"]) : 
                            $total = "";
            

            //check error & validation
            $error["name"] = checkUserName($name);
            $error["email"] = validateEmail($email);
            $error["phoneN"] = checkPhoneNumber($phoneN);
            $error["payment"] = checkPaymentMethod($payment);
            $error["account"] = validateMaybankAccountNumber($account);
            $error["CVC"] = validateMaybankCVC($CVC);
            $error["date"] = checkDateInput($date);
            $error = array_filter($error);

            //check if there are any msg in $error
            if (empty($error)) {
                //No error,insert record
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,DB_PORT);
                $sql = "INSERT INTO payment(username,email_address,phone_number,payment_method,
                                            account_number,CVC,expired_date,total_amount) VALUES(?,?,?,?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sssssisd", $name, $email, $phoneN, $payment, $account, $CVC, $date, $total);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    //insert successful
                    printf("<span class='info'>Payment Successful!");
                }
            } else {
                //With error, display error msg
                echo"<ul class='pmerror'>";
                foreach ($error as $value) {
                    echo"<li>$value</li>";
                }
                echo"</ul>";
            }
        }
        ?>

        <form action="" method="POST" >
            <div class="boxer">
                <h1 class="header1">Payment Form</h1>


                <div id="key_in">
                    <h3 class="header3"style="width:26%">Account</h3>


                    <div class="user_acount">
                        <input style="width:100%"type="text" name="uname" value="<?php echo $name; ?>" placeholder=" Enter Username" />
                        <ion-icon style="margin-top: 10px" name="people-outline"></ion-icon>
                    </div> 


                    <div class="user_acount">
                        <input style="width:100%;margin-top:25px"type="text" name="email" value="<?php echo $email; ?>" placeholder=" Email Address"/>
                        <ion-icon style="margin-top: 25px" name="mail-outline"></ion-icon>

                        ️</div>
                    <div class="user_acount">
                        <input style="width:100%"type="text" name="phone-number" value="<?php echo $phoneN; ?>" placeholder=" phone-number"/>
                        <ion-icon style="margin-top:10px"name="call-outline"></ion-icon>
                    </div>

                </div> 


                <div class="pd">


                    <h3 class="header3" style="width:35%">Payment Method</h3>
                    <div id="pm">
                        <div style="margin-left:180px" class="pm">
                            <?php
                            $allMethod = getAllMethod();
                            foreach ($allMethod as $key => $value) {
                                printf("<input type='radio' name='paymentmethod' id='%s' value='%s' ;'>
                                    <label for='%s'><b>%s</b></label>"
                                        , $key, $key, $key, $value);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="user_keyin">
                        <input type="text" id="cardnum" name="card-number" value="<?php echo $account; ?>" placeholder=" Maybank"/>
                        <ion-icon class="iconstyle" name="card-outline"></ion-icon>
                    </div>

                    <div class="user_keyin">
                        <input type="text" id="cvc" name="cvc" value="<?php echo $CVC; ?>" placeholder=" Enter CVC "/>
                        <ion-icon class="iconstyle" name="people-outline"></ion-icon>
                    </div>

                    <div class="user_keyin">
                        <input type="date" id="day" name="day" value="<?php echo $date; ?>" placeholder=" Expired Date"/>
                        <ion-icon class="iconstyle" name="calendar-number-outline"></ion-icon>
                    </div>

                    <div class="user_keyin">
                        <input type="text" id="amount" name="amount" value="<?php echo "RM ".$_SESSION['totalprice'];?>" disabled/>
                        <ion-icon class="iconstyle" name="cash-outline"></ion-icon>
                    </div>

                    <div class="user_button">
                        <input type="submit" value="Pay Amount" />
                        <input type="reset" value="Reset" />
                    </div>
                </div>
            </div>

        </form>

    </body>
</html>
