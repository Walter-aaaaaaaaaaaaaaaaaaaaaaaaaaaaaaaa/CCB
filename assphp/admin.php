<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>
    <head>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <meta charset="UTF-8">
        <title>Admin management</title>
        <link href="adminmng.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>
    <body>
<?php  
        session_start();  
    ?>
        <div class="sidebar">
            <div class="sidebar-brand">
                <img src="adminLogo/lddslogo.jpg" alt="" width="100px"/>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="" class="active"><span class='bx bxs-dashboard'></span>Dashboard</a>
                    </li>
                    <li>
                        <a href="adminViewPaymentDetail.php"><span class='bx bx-user'></span>Payment</a>
                    </li>
                    <li>
                        <a href="MemberEditDelete.php"><span class='las la-users'></span>Member</a>
                    </li>
                    <li>
                        <a href="list-feedback.php"><span class='las la-users'></span>Feedback</a>
                    </li>
                    <li>
                        <a href="admin_announcement.php"><span class='las la-bars'></span>Announcement</a>
                    </li>
                    <li>
                        <a href="EventView.php"><span class='bx bx-calendar-event'></span>Event</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="main-content">
            <header>
                <h2>
                    <label for="">
                        <span class="bx bxs-dashboard"></span>
                    </label>
                    Dashboard
                </h2>

                <div class="search-wrapper">
                    <span class="las la-search"></span>
                    <input type="search" placeholder="Search here"/>
                </div>

                <div class="user-wrapper">
                    <img src="Unknown_person.jpg" alt="" width="30px" height="30px"/>
                    <div>

                        <h4><?php echo $_SESSION['Staff_Name']; ?></h4>
                        <small><?php echo $_SESSION['Staff_Role']; ?></small>
                    </div>
                </div>

            </header>        

            <div class="error">
                <main>
                    <div class="dashboard-cards">
                        <div class="card-single">
                            <div>
                                <h1>54</h1>
                                <span>Customers</span>
                            </div>
                            <div>
                                <span class="las la-users"></span>
                            </div>
                        </div>
                        <div class="card-single">
                            <div>
                                <h1>79</h1>
                                <span>Projects</span>
                            </div>
                            <div>
                                <span class="las la-clipboard"></span>
                            </div>
                        </div>
                        <div class="card-single">
                            <div>
                                <h1>124</h1>
                                <span>Orders</span>
                            </div>
                            <div>
                                <span class="las la-shopping-bag"></span>
                            </div>
                        </div>
                        <div class="card-single">
                            <div>
                                <h1>$6k</h1>
                                <span>Income</span>
                            </div>
                            <div>
                                <span class="lab la-google-wallet"></span>
                            </div>
                        </div>
                    </div>

                    <div class="recent-grid">
                        <div class="projects">
                            <div class="card">
                                <div class="card-header">

                                    <?php
                                    require_once'./config/helperFD.php';

                                    $header = array(
                                        'AdminID' => 'Admin ID',
                                        'AdminName' => 'Admin Name',
                                        'Email' => 'Admin Email',
                                        'Role' => 'Admin Role',
                                        'Password' => 'Password'
                                    );

                                    global $sort, $order;
                                    if (isset($_GET['sort']) && isset($_GET['order'])) {
                                        $sort = (array_key_exists($_GET['sort'], $header) ? $_GET['sort'] : 'AdminID');

                                        $order = ($_GET['order'] == 'DESC') ? 'DESC' : 'ASC';
                                    } else {
                                        $sort = "AdminID";
                                        $order = "ASC";
                                    }
                                    if (isset($_GET['Role'])) {
                                        $role = (array_key_exists($_GET["Role"], getAllRole()) ? $_GET["Role"] : "%");
                                    } else {
                                        $role = "%";
                                    }
                                    ?>

                                    <?php
                                    if (isset($_POST['btnDelete'])) {
                                        (isset($_POST['checked'])) ?
                                                        $check = $_POST['checked'] :
                                                        $check = "";
                                        if (!empty($check)) {
                                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                                            foreach ($check as $value) {
                                                $checkValue[] = $con->real_escape_string($value);
                                            }
                                            $sql = "DELETE FROM admin WHERE AdminID IN('" . implode("','", $checkValue) . "')";

                                            if ($con->query($sql)) {
                                                printf("<div class='info'>%d record has been deleted!</div>", $con->affected_rows);
                                            }
                                            $con->close();
                                        }
                                    }
                                    ?>

                                    <form method="POST">
                                        Filter:
                                        <?php
                                        printf("<a href='?sort=%s&order=%s'>ALL Role</a>", $sort, $order);

                                        $allRole = getAllRole();
                                        foreach ($allRole as $key => $value) {
                                            printf("| <a href='?sort=%s&order=%s&role=%s'>%s</a>",
                                                    $sort, $order, $key, $value);
                                        }
                                        ?>
                                        <table border="1">
                                            <h1>Admin</h1>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <?php
                                                foreach ($header as $key => $value) {
                                                    if ($key == $sort) {
                                                        //Yes,user clicked to perform sorting
                                                        printf('<th>
                                <a href="?sort=%s&order=%s&%s">%s</a>
                                %s
                                    </th>'
                                                                , $key
                                                                , $order == 'ASC' ? 'DESC' : 'ASC'
                                                                , $role//retain filter effect even after sorting the record
                                                                , $value
                                                                , $order == 'ASC' ? '⬇️' : '⬆️');
                                                    } else {
                                                        //NO,user never click anything,default
                                                        printf('<th>
                               <a href="?sort=%s&order=ASC&%s">%s</a>
                               </th>'
                                                                , $key
                                                                , $role//to retain
                                                                , $value);
                                                    }
                                                }
                                                ?>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM admin WHERE Role LIKE '$role' ORDER BY $sort $order";

                if ($result = $con->query($sql)) {
                    while ($record = $result->fetch_object()) {
                        //display output

                        printf("<tr>
                                <td><input type='checkbox' name='checked[]' value='%s'/></td>
                                <td>%s</td> 
                                <td>%s</td> 
                                <td>%s</td>
                                <td>%s</td> 
                                <td>%s</td>  
                                <td><a href='adminEdit.php?id=%s'>Edit</a>|
                                <a href='adminDelete.php?id=%s'>Delete</a></td>
                                </tr>", $record->AdminID
                                , $record->AdminID
                                , $record->AdminName
                                , $record->Email
                                , getAllRole()[$record->Role]
                                , $record->Password
                                , $record->AdminID
                                , $record->AdminID);
                    }
                    printf("<tr><td colspan='6'>" . "%d record(s)returned." . "[<a href='adAdmin.php'>"
                            . "<b>Add Admin</b></a>]" . "<td></tr>", $result->num_rows);
                }
                //step 4
                $result->free();
                $con->close();
                ?>
                

                                        </table>
                                        <br/>
            <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('This will delete all checked record. \nAre you sure?')" />

                                    </form>




                                    <div class="customers">
                                        
                                            <div class="customer">
                                                <div>
                                                    <img src="Unknown_person.jpg" width="40px" height="40px" alt="">

                                                    <div>
                                                        <h4>Lai Wei Shen</h4>
                                                        <small>CEO Excerpt</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="las la-user-circle"></span>
                                                    <span class="las la-comment"></span>
                                                    <span class="las la-user-phone"></span>
                                                </div>
                                            </div>
                                            <div class="customer">
                                                <div>
                                                    <img src="Unknown_person.jpg" width="40px" height="40px" alt="">
                                                    <div>
                                                        <h4>Khong Yao Jun</h4>
                                                        <small>CEO Excerpt</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="las la-user-circle"></span>
                                                    <span class="las la-comment"></span>
                                                    <span class="las la-user-phone"></span>
                                                </div>
                                            </div>
                                            <div class="customer">
                                                <div>
                                                    <img src="Unknown_person.jpg" width="40px" height="40px" alt="">
                                                    <div>
                                                        <h4>Lee Cheng Qian</h4>
                                                        <small>CEO Excerpt</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="las la-user-circle"></span>
                                                    <span class="las la-comment"></span>
                                                    <span class="las la-user-phone"></span>
                                                </div>
                                            </div>
                                            <div class="customer">
                                                <div>
                                                    <img src="Unknown_person.jpg" width="40px" height="40px" alt="">
                                                    <div>
                                                        <h4>Nick Neoh</h4>
                                                        <small>CEO Excerpt</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="las la-user-circle"></span>
                                                    <span class="las la-comment"></span>
                                                    <span class="las la-user-phone"></span>
                                                </div>
                                            </div>
                                            <div class="customer">
                                                <div>
                                                    <img src="Unknown_person.jpg" width="40px" height="40px" alt="">
                                                    <div>
                                                        <h4>Chen Chun Qing</h4>
                                                        <small>CEO Excerpt</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="las la-user-circle"></span>
                                                <span class="las la-comment"></span>
                                                <span class="las la-user-phone"></span>
                                            </div>
                                        </div>


                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                    </body>
                    </html>
