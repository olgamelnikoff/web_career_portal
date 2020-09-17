<?php
ob_start();
session_start();
require_once 'config.php';
require_once 'util.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

$user_id = $_SESSION['user_id'];
//echo $_SESSION['user_id'];


    
    
    $query1 = 
    "SELECT job_id, employee_id, application_status, application_date FROM Applied_to WHERE employee_id = '{$user_id}' AND application_status = 'sent'";
    $result = $connection->query($query1);
    
    //var_dump($result);
    
    if (!$result) {
        die ($connection->error);
        /*echo "You have already submitted an application for this job." . '<br><br>';*/
    }
    ?>
        <span style="color:red;"><b>Sent Applications:</b></span><br><br>
    <?php

    show_table_application_sent($result);

    if (isset($_POST['withdraw_job_id'])) {
        //echo "Was here";
        $withdraw_job_id = $_POST['withdraw_job_id'];

        $query2 = "UPDATE `Applied_to` SET `application_status` = 'withdrawn' WHERE job_id = '{$withdraw_job_id}' AND employee_id = '{$user_id}'";

        $result2 = $connection->query($query2);
        //var_dump($result2);
        if (!$result2) {
            echo "Could not receive query result" . '<br><br>';
            die ($connection->error);
        }
    }

    $query3 = 
    "SELECT job_id, employee_id, application_status, application_date FROM Applied_to WHERE employee_id = '{$user_id}' AND application_status = 'withdrawn'";
    $result3 = $connection->query($query3);
    
    //var_dump($result);
    
    if (!$result3) {
        die ($connection->error);
        /*echo "You have already submitted an application for this job." . '<br><br>';*/
    }

    ?>
        <span style="color:red;"><b>Withdrawn Applications:</b></span><br><br>
    <?php
    show_table_application_withdrawn($result3, $connection);

 


    if (isset($_POST['send_again_job_id'])) {
        $send_again_job_id = $_POST['send_again_job_id'];

        $query4 = "DELETE FROM `Applied_to` WHERE (`job_id` = '{$send_again_job_id}') AND (`application_status` = 'withdrawn') AND (`employee_id` = '{$user_id}')";

        $result4 = $connection->query($query4);
        //var_dump($result4);
        if (!$result4) {
            echo "Could not receive query result" . '<br><br>';
            die ($connection->error);
        }
    }

 ob_end_flush();   
?>