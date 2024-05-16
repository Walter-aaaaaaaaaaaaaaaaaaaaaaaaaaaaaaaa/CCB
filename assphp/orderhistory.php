<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <title>History</title>
        <link href="historystyle.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include'./header.php';
        require_once './config/login_helper.php';
        ?>
        
        
        
        <?php 
            $header1 = array(
          
          'OrderID' => 'Order ID',
          'StudentID' => 'Student ID',
          'EventName' => 'Event Name',
          'buyQuantity' => 'Quantity',
          'TicketPrice' => 'Ticket Price',
          'TotalPrice' => 'Total Price'
            );
            
            //check $sort $order variable -> prevent sql error
            //which column to sort
      
            global $sort, $order;
      
            if (isset($_GET['sort']) && isset($_GET['order'])){
            $sort = (array_key_exists($_GET['sort'], $header)?
              $_GET['sort']:'OrderID');
              
            //how to arrange order sequence ASC /DESC
            $order = ($_GET['order']=='DESC')? 'DESC':'ASC';
            }else{
                $sort="OrderID";
                $order="ASC";
            }
            
            if(isset($_GET["OrderID"])){
           $title =(array_key_exists($_GET["OrderID"],
                   checkTitle($title))
                   ?$_GET['OrderID']:"%");
       }
       else {
           $title ="%";
       }

            ?>
        <div class="searchbar">
            <input type="text" name="searchbar" value="" placeholder="Search..." />
            <span class="searchline">|</span>
            <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
        </div>
        
        <?php
        if(isset($_POST['btnDelete'])){
            (isset($_POST['checked']))?
            $check=$_POST['checked']:
                $check="";
            if(!empty($check)){
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
                
                foreach($check as $value){
                    $checkvalue[]=$con->real_escape_string($value);
                }
                $sql="DELETE FROM order_detail WHERE OrderID IN ('".implode("','",$checkvalue)."')";
                
                if($con->query($sql)){
                    printf("<div class='info'>%d records have been deleted</div>",$con->affected_rows);
                }
                $con->close();
            }
        }
        ?>

        
        <div class="history">
            <h1><ion-icon name="book"></ion-icon>Add To Cart<ion-icon name="book"></ion-icon></h1>
            <form action="" method="POST">
            <table class="htable" border="1">
                 <tr>
                    <th>&nbsp;</th>
                    <?php
                    foreach($header1 as $key=>$value){
                        if($key==$sort){
                            //YES,user clicked to perform sorting
                            
                            printf('<th>
                                    %s
                                    </th>',$value);
                        }else{
                            //No,user never click anything,default
                            printf('<th>
                                    %s
                                    </th>',$value);
                        }
                    }
                    ?>
                    <th>&nbsp;</th>
                </tr>
                
                <?php
                //step 2 :link php app with database
                //object-oriented method
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
                $studentid = $_SESSION['Student_ID'];
                
                //step 3: sql statement
                $sql="SELECT * FROM order_detail WHERE StudentID = '$studentid'";
                
                //step 4:execute/ run sql
            //$result- contains ALL 5 records
            if($result =$con->query($sql)){

    // Add this line
    $totalPriceSum = 0;
  
    //record found
    while($record = $result->fetch_object()){
      
        printf("<tr>
                <td><input type='checkbox' name='checked[]' value='%s'/></td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%d</td>
                <td><a href='editorder.php?orderid=%s'>Edit</a></td>
                </tr>",$record->OrderID,
                        $record->OrderID,
                        $record->StudentID,
                        $record->EventName,
                        $record->buyQuantity,
                        $record->TicketPrice,
                        $record->TotalPrice,
                        $record->OrderID);
        
        // Add this line
        $totalPriceSum += $record->TotalPrice;
        $_SESSION['totalprice']= $totalPriceSum;
    }
    printf("<tr><th colspan='6'>Total Price:</th><td colspan='2'>RM %d</td></tr>",$totalPriceSum);
    printf("<tr><td colspan='8'>%d record(s) returned.</td></tr>",$result->num_rows);
  
    $result->free();
    $con->close();
}
                        
                ?>
                

            </table>
                <div class="twobutton">
                <input type="submit" value="Multiple Delete" name="btnDelete" onclick="return confirm('This will delete all of the Order that you selected. Are you sure you want to delete?')"/>
                
                <a href="Payment.php" class="btnpayment" id="payment" name="btnpayment">Payment</a>
                </div>
            </form>
        </div>
        
        
        
        
    </body>
</html>
