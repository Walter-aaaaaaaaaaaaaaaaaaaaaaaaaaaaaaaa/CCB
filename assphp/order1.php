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
        require_once './config/login_helper.php';
        ?>
        
        <?php
        global $EName;
        global $EDate;
        global $EVenue;
        global $Premium;
        global $Standard;
        
        if($_SERVER["REQUEST_METHOD"] == 'GET'){
            (isset($_GET["date"]))?
            $date = strtoupper(trim($_GET["date"])) : $date = "";
            
            
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,DB_PORT);
            $sql = "SELECT * FROM event_detail WHERE EventDate = '$date'";
            
            if($result = $con->query($sql)){
            if($result -> num_rows == 1){
               while ($row = $result->fetch_object()){
                $EName = $row->EventName;
                $EDate = $row->EventDate;  
                $EVenue = $row->EventtVenue;
                $ETime = $row->EventTime;
                $Premium = $row->Price_P;
                $Standard = $row->Price_S;
            }
        }
    }
}
        ?>
        
        <?php 
        if(isset($_POST['add'])){
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,DB_PORT);
        $tclass = $_POST["tclass"];
        $txtquantity = $_POST["txtquantity"];
        $total = $tclass * $txtquantity;
        $studentID = $_SESSION['Student_ID'];
        $sql1 = "SELECT MAX(OrderID) FROM order_detail";
               $result = $con->query($sql1);
        $idrow = $result->fetch_row();
               $max_id = $idrow[0];
               $new_id = $max_id + 1;
        
        $sql = "INSERT INTO order_detail (OrderID,StudentID,TicketPrice,buyQuantity,TotalPrice) VALUES(?,?,?,?,?)";
                $stmt = $con ->prepare($sql);
                $stmt ->bind_param("isiii",$new_id,$studentID,$tclass,$txtquantity,$total);
                $stmt ->execute();
                if($stmt ->affected_rows > 0){
                    //insert successful
                    echo "Insert Successfully!";
                    header('location: EventPage.php');
                }
                else{
                   echo "<div class='error'>Unable To Insert(<a href='list-student.php'>Back to List</a>)</div>";
                }
                $con->close();
        }
        ?>
        
        <div class="combination">
            <div class="asidepic">
                <img src="lddslogo2.png" width="100" height="63" alt="lddslogo2" class="asidelogo"/>
                <h2><?php echo $EName; ?><ion-icon name="bonfire-outline"></ion-icon></h2>
                <h3>Welcome To The <?php echo $EName; ?></h3>
                <p>REMEMBER TO FOLLOW OUR SOCIAL MEDIA FOR MORE INFORMATION!!</p>
                <ul class="socialmedia">
                    <li><a href="#"><span class="facebook"><ion-icon name="logo-facebook"></ion-icon>Facebook</span></a></li>
                    <li><a href="#"><span class="instagram"><ion-icon name="logo-instagram"></ion-icon>Instagram</span></a></li>                                        
                </ul>
            </div>
            <div class="ticketdetails">
                <div class="ticketbox">
                    <form action="#" method="POST">
                        <h2><ion-icon name="cloudy"></ion-icon> <?php echo $EName; ?> <ion-icon name="cloudy"></ion-icon></h2>
                        <div class="tdate">
                            <span><ion-icon name="calendar-sharp"></ion-icon>Date Participate</span><br/>
                            <input type="text" name="txtdate" value="<?php echo $EDate; ?>" readonly>
                        </div>
                        <div class="tvenue">
                            <span><ion-icon name="home"></ion-icon>Venue</span><br/>
                            <input type="text" name="txtvenue" value="<?php echo $EVenue; ?>" readonly>
                        </div>
                        <div class="ttime">
                            <span><ion-icon name="time-sharp"></ion-icon>Time Participate</span><br/>
                            <input type="text" name="txttime" value="<?php echo $ETime; ?>" readonly>
                        </div>
                        <div class="tseat">
                            <span><ion-icon name="cash"></ion-icon>Ticket Class</span><br/>
                            <select name="tclass" id="fare" onchange="calculateTotal()">
                                <option value="choose" hidden>Choose Your Ticket Class</option>
                                <option value="<?php echo $Premium; ?>" name="Premium">Premium(RM<?php echo $Premium; ?>)</option>
                                <option value="<?php echo $Standard; ?>" name="Standard">Standard(RM<?php echo $Standard; ?>)</option>
                            </select>
                        </div>
                        <div class="quantity">
                            <span><ion-icon name="basket"></ion-icon>Purchase Quantity(MAX: 5)</span><br/>
                            <input type="number" id="txtquantity" name="txtquantity" min="1" max="5" value="1" oninput="calculateTotal()">
                        </div>
                        <p id="total" name="total" style="margin-top:5%; margin-left: 5%;">Total : RM0.00</p>
                        <div class="submitnresetbtn">
                            <button class="sure" id="add" name="add">Add</button>
                            <button class="cancel" id="back" name="back">Back</button>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
    function calculateTotal() {
  var seatClass = document.getElementById("fare").value;
  var quantity = document.getElementById("txtquantity").value;
  var total = seatClass * quantity;
  document.getElementById("total").innerHTML = "Total : RM" + total.toFixed(2);
}
    </script>    
</html>

