<?php
session_start();
require_once 'config.php';
require_once 'util.php'; ?>
<!DOCTYPE html>
<html>
<!-- <meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" /> -->
<body>
<a href="EmployersDashboard.php">Back to Dashboard</a><br><br>
</body>
</html>

<?php

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

$user_id = $_SESSION['user_id'];
//echo $_SESSION['user_id'];


    
    
    $query1 = 
    "SELECT job_id, job_title, job_description, city, date_posted, number_positions, job_status, job_category FROM Jobs WHERE employer_id = '{$user_id}' AND job_status = 'open' ORDER BY date_posted DESC";

    $result = $connection->query($query1);
    
    //var_dump($result);
    
    if (!$result) {
        die ($connection->error);
        /*echo "You have already submitted an application for this job." . '<br><br>';*/
    }



    ?>
    <span style="color:red;"><b>Open Jobs:</b><br><br></span>
     
    <?php

    show_table_open_jobs_employer($result);

    
	$query2 = 
    "SELECT job_id, job_title, job_description, city, date_posted, number_positions, job_status, job_category FROM Jobs WHERE employer_id = '{$user_id}' AND job_status = 'suspended' ORDER BY date_posted DESC";
    $result2 = $connection->query($query2);
    
    //var_dump($result);
    
    if (!$result2) {
        die ($connection->error);
        /*echo "You have already submitted an application for this job." . '<br><br>';*/
    }
   	?>
    <span style="color:red;"><b>Suspended Jobs:</b><br><br></span>
     
    <?php
    show_table_suspended_jobs_employer($result2);

    $query3 = 
    "SELECT job_id, job_title, job_description, city, date_posted, number_positions, job_status, job_category FROM Jobs WHERE employer_id = '{$user_id}' AND job_status = 'closed' ORDER BY date_posted DESC";
    $result3 = $connection->query($query3);
    
    //var_dump($result);
    
    if (!$result3) {
        die ($connection->error);
        /*echo "You have already submitted an application for this job." . '<br><br>';*/
    }

    ?>
    <span style="color:red;"><b>Closed Jobs:</b><br><br></span>
     
    <?php
    show_table_closed_jobs_employer($result3);

  

    if (isset($_POST['open_job_id'])) {
        //echo "Was here";
        $open_job_id = $_POST['open_job_id'];

        $query = "UPDATE `Jobs` SET `job_status` = 'open' WHERE job_id = '{$open_job_id}' AND employer_id = '{$user_id}'";

        $result = $connection->query($query);
        //var_dump($result2);
        if (!$result) {
            echo "Could not receive query result" . '<br><br>';
            die ($connection->error);
        }
    }

    if (isset($_POST['suspend_job_id'])) {
        //echo "Was here";
        $suspend_job_id = $_POST['suspend_job_id'];

        $query2 = "UPDATE `Jobs` SET `job_status` = 'suspended' WHERE job_id = '{$suspend_job_id}' AND employer_id = '{$user_id}'";

        $result2 = $connection->query($query2);
        //var_dump($result2);
        if (!$result2) {
            echo "Could not receive query result" . '<br><br>';
            die ($connection->error);
        }
    }

    if (isset($_POST['close_job_id'])) {
        //echo "Was here";
        $close_job_id = $_POST['close_job_id'];

        $query = "UPDATE `Jobs` SET `job_status` = 'closed' WHERE job_id = '{$close_job_id}' AND employer_id = '{$user_id}'";

        $result = $connection->query($query);
        //var_dump($result2);
        if (!$result) {
            echo "Could not receive query result" . '<br><br>';
            die ($connection->error);
        }
    }
?>