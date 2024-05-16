<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Feedback</title>
        <link href="mgsdfeed.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="lddslogo2.png" type="image/icon type">
    </head>


    <body>
        <?php
        require_once './config/helperFD.php';

        //array map between table field name&table
        //display name
        $header = array(
            'FeedbackID' => 'Feedback_ID',
            'StudentName' => 'Student Name',
            'Email' => 'Email',
            'TypeOfevent' => 'Type of event',
            'Feeling' => 'Do you think this activity is wonderful?	',
            'Feedback' => 'comment'
        );

        //check $sort $order variable->prevent sql error
        //which column to sort
        global $sort, $order;
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $sort = (array_key_exists($_GET['sort'], $header) ? $_GET['sort'] : 'FeedbackID');

            $order = ($_GET['order'] == 'DESC') ? 'DESC' : 'ASC';
        } else {
            $sort = "FeedbackID";
            $order = "ASC";
        }
        if (isset($_GET['event'])) {
            $event = (array_key_exists($_GET["event"], getAllEvent()) ? $_GET["event"] : "%");
        } else {
            $event = "%";
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

                $sql = "DELETE FROM feedback WHERE FeedbackID IN ('" . implode("','", $checkValue) . "')";

                if ($con->query($sql)) {
                    printf("<div class='Finfo'>%d record has been deleted!</div>"
                            , $con->affected_rows);
                }
                $con->close();
            }
        }
        ?>

        <form method="POST">
            <h3>Filter:</h3>
            <?php
            printf("<a href='?sort=%s&order=%s' class='filter'>ALL Event</a>", $sort, $order);

            $allEvent = getAllEvent();
            foreach ($allEvent as $key => $value) {
                printf("| <a href='?sort=%s&order=%s&event=%s'class='filter' >%s</a>",
                        $sort, $order, $key, $value);
            }
            ?>
            <table border="1">
                <h2>Student Feedback</h2>
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
                                    , $event//retain filter effect even after sorting the record
                                    , $value
                                    , $order == 'ASC' ? '⬇️' : '⬆️');
                        } else {
                            //NO,user never click anything,default
                            printf('<th>
                               <a href="?sort=%s&order=ASC&%s">%s</a>
                               </th>'
                                    , $key
                                    , $event//to retain
                                    , $value);
                        }
                    }
                    ?>
                    <th>&nbsp;</th>
                </tr>

                <?php
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $sql = "SELECT * FROM feedback WHERE TypeOfevent LIKE '$event' ORDER BY $sort $order";

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
                                <td>%s</td>
                                <td><a href='edit-feedback.php?id=%s'class='function' >Edit</a> |
                                <a href='delete-feedback.php?id=%s' class='function'>Delete</a></td>
                                </tr>", $record->FeedbackID
                                , $record->FeedbackID
                                , $record->StudentName
                                , $record->Email
                                , getAllEvent()[$record->TypeOfevent]
                                , getAllFeeling()[$record->Feeling]
                                , $record->Feedback
                                , $record->FeedbackID
                                , $record->FeedbackID);
                    }
                    printf("<tr><td colspan='6'>" . "%d record(s)returned." . "<td></tr>", $result->num_rows);
                }
                //step 4
                $result->free();
                $con->close();
                ?>
            </table>
            <br/>
            <input type="submit" value="Delete Checked" name="btnDelete" id="deleteCheck" onclick="return confirm('This will delete all feedback record selected. \nAre you sure?')" />
        </form>



    </body>

</html>
