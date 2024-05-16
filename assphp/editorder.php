<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="orderstyle.css" rel="stylesheet" type="text/css"/>
        <title>TIcket Details</title>
    </head>
    <body>
        <?php
        include'./header.php';
        require_once './config/order_helper.php';
        ?>
        
        
        <?php
        global $hideForm;
        global $Quantity;
        global $orderid;
        global $ticketprice;
        global $totalprice;
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            (isset($_GET["orderid"]))?
            $orderid = trim($_GET["orderid"]) : $orderid = "";
            $con= new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            //Step 2:sql statement
            $sql="SELECT * FROM order_detail WHERE OrderID='$orderid'";
            //Step 3:run sql 
            $result=$con->query($sql);
            
            if($record=$result->fetch_object()){
                //record found 
                $OrderID=$record->OrderID;
                $Quantity=$record->buyQuantity;
                $ticketprice=$record->TicketPrice;
                $totalprice= $record->TotalPrice;
            }
            else{
                //record not found
                echo"<div class='error'>Unable to retreive record!
                    <a href='orderhistory.php'>Back to Cart</a></div>";
                $hideForm=true;
            }
            $result->close();
            $con->close();
        }
        else{
            //post method
            $orderidid=trim($_POST['hdtitle']);
            $quantityorder=trim($_POST['desc']);
            $ticketpriceprice = trim($_POST['hdticket']);
            $totalpriceprice =$ticketpriceprice * $quantityorder;
            
            
            
            if(empty($error)){
                //no error 
                //Step 1 :connect
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                //Step 2 :sql
                $sql="UPDATE order_detail SET buyQuantity=?,TotalPrice=?
                      WHERE OrderID=?";
                
                
                $statement=$con->prepare($sql);
                $statement->bind_param("iii",$quantityorder,$totalpriceprice,$orderidid);
                
                if($statement->execute()){
                    //Update successful 
                    printf("<div class='infoedit'>OrderID %s : has been updated 
                            <a href='orderhistory.php'>Back to Cart</a></div> ",
                            $orderidid);
                }
                else{
                    //failed to update
                    echo"<div class='erroredit'>Unable to edit![<a href='orderhistory.php'>Back to Detail</a>]</div>";
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
        <div class="formedit">
            <h1 style="color:#fff;">Edit Quantity</h1>
        <?php if($hideForm==false): ?>
        <form action="" method="POST">
            <div>
                <?php echo '<h1 class="edittitle">Edit Order ID :'.$orderid.'</h1>';?>
                <input type="hidden" name="hdtitle" placeholder="Edit OrderID" value="<?php echo $orderid;?> "/>
                <input type="hidden" name="hdtotal" placeholder="Edit Total" value="<?php echo $totalprice;?> "/>
                <input type="hidden" name="hdticket" placeholder="Edit Ticket" value="<?php echo $ticketprice;?> "/>
            </div>
            
            <div>
                <input type="number" name="desc" placeholder="Edit Quantity" value="<?php echo $Quantity; ?>"/>
            </div>
            <input type="submit" value="Update" name="btnUpdate" onclick="location='orderhistory.php'"/>
            <input type="button" class="btncancel" value="Cancel" name="btnCancel" onclick="location='orderhistory.php'"/> 
        </form>
        <?php endif; ?>
            </div>
    </body>  
</html>

