<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transaction Detail</title>
        <link href="adminViewPaymentDetail_style.css" rel="stylesheet" type="text/css"/>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
        
        <?php
        require_once'./config/helper.php';
        
        //array map between table field name & table 
      //display name
      $header = array(
          'username'=>'User Name',
          'email_address'=>'Email',
          'phone_number'=>'Phone Number',
          'payment_method'=>'Payment Method',
          'account_number'=>'Account Number',
          'cvc'=>'CVC',
          'expired_date'=>'Expired Date',
          'total_amount'=>'Total Amount '
      );
      
      //check $sort $order variable -> prevent sql error
      //whick column to sort
      global $sort,$order;
      
      if (isset($_GET['sort']) && isset($_GET['order'])){
      $sort = (array_key_exists($_GET['sort'], $header)?
              $_GET['sort']:'username');
      
      //how to arrange order sequence ASC/DESC
      $order = ($_GET['order']=='DESC')? 'DESC':'ASC';
      }else{
          $sort="account_number";
          $order="ASC";
      }
      
      if(isset($_GET["payment_method"])){
      $payment = (array_key_exists($_GET["payment_method"], 
                    getAllProgram())
                    ?$_GET["payment_method"]:"%");
      }
      else{
          $payment="%";
      }
        ?>
        
      
        <h1 style="margin-top: 9%; margin-left: 41%">Payment History</h1>
        <?php
        if(isset($_POST['btnDelete'])){
             (isset($_POST['checked']))?
            $check=$_POST['checked']:
            $check="";
            if(!empty($check)){
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                foreach($check as $value){
                   $checkValue[]=$con->real_escape_string($value);
                    
                }
                $sql="DELETE FROM payment WHERE username IN('".implode("','",$checkValue)."')";
                
                if($con->query($sql)){
                    printf("<div class='info'>%d records have been deleted</div>",$con->affected_rows);
                }
                $con->close();
            }
        }
            
        ?>
        <form action="" method="POST">
            
        
           
            <table border="1">
                
                <tr>
                    <th>&nbsp;</th>
                    <?php
                    foreach($header as $key=>$value){
                        if($key==$sort){
                            //YES,user clicked to perform sorting
                            
                            printf('<th>
                                    <a href="?sort=%s&order=%s&payment=%s">%s</a>%s
                                    </th>',$key,$order=='ASC'?'DESC':'ASC',$payment,$value,$order=='ASC'?'⬇️':'⬆️');
                        }else{
                            //No,user never click anything,default
                            printf('<th>
                                    <a href="?sort=%s&order=ASC&payment=%s">%s</a>
                                    </th>',$key,$payment,$value);
                        }
                    }
                    ?>
                    <th>&nbsp;</th>
                </tr>
                
                <?php
                //step 2 :link php app with database
                //object-oriented method
                $con=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                
                //step 3: sql statement
                $sql="SELECT * FROM payment WHERE payment_method LIKE '$payment' ORDER BY $sort $order";
                
                //step 4:execute/ run sql
            //$result- contains ALL 5 records
            if($result =$con->query($sql)){
              
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
                        <td>%s</td>
                        <td>%d</td>
                        <td><a href='editpayment.php?account=%s'>Edit</a> |
                            <a href='deletepayment.php?account=%s'>Delete</a></td>?
                        </tr>", $record->username,
                                $record->username,
                                $record->email_address,
                                $record->phone_number,
                                getAllMethod()[$record->payment_method],
                                $record->account_number,
                                $record->cvc,
                                $record->expired_date,
                                $record->total_amount,
                                $record->account_number,
                                $record->account_number);
            }
            printf("<tr><td colspan='10'>%d record(s) returned.</td></tr>",
                    $result->num_rows);
            $result->free();
            $con->close();
            }
                        
                ?>
            </table>
            <input type="submit" value="Multiple Delete" name="btnDelete"
                   onclick="return confirm('This will delete all of the record that you selected. Are you sure you want to delete?')"/>
        </form>
    </body>
</html>
