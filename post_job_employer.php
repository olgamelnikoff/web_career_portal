<?php
session_start();
require_once 'util.php';
require_once 'config.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);


if (isset($_POST['posting_job']) && isset($_POST['user_id'])) {
    $user_id= ($_POST['user_id']);
    $job_title= $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_category= $_POST['job_category'];
    $number_of_positions= $_POST['number_of_positions'];
    $city= $_POST['city'];

    $query_employer_category = "SELECT category FROM Employer WHERE employer_id='{$user_id}'"; 
    $result_category = $connection->query($query_employer_category);
    

    $result_arr = $result_category->fetch_all();

    $current_category = $result_arr[0][0];


    $query_deactivated_account = "SELECT is_active FROM Users WHERE user_id ='{$user_id}'";

    $result_is_active = $connection->query($query_deactivated_account);
    

    $result_arr = $result_is_active->fetch_all();
    $is_active = (int) $result_arr[0][0];

    if ($is_active == 0)
    {
        ?>
        <span style="color:red;"><b>Your account is deactivated so you cannot post jobs. Please make a payment to re-activate your account.</b></span><br><br>
    <?php

    }

    else

    {

    $query_posted_jobs_number = "SELECT COUNT(job_id) FROM Jobs WHERE employer_id ='{$user_id}' AND (job_status = 'open' OR job_status = 'suspended')";

    $result_jobs_number = $connection->query($query_posted_jobs_number);

    $result_arr2 = $result_jobs_number->fetch_all();
    $current_jobs_number = (int) $result_arr2[0][0];
    //echo $current_jobs_number;


    if ($current_category == 'Prime' && $current_jobs_number == 5)
    {
        ?>
        <span style="color:red;"><b> You have exceeded the limit of job postings for your account.</span> The limit for Prime is 5 open and suspended jobs in total. To be able to maintain an unlimited number of open and suspended jobs, please upgrade your account to Gold in your Dashboard</b><br><br>
        
        <?php
    }

    else {
    
        $query = "INSERT INTO `Jobs` (employer_id, job_title, job_description, number_positions, job_status, job_category, city) VALUES ('{$user_id}', '{$job_title}', '{$job_description}', '{$number_of_positions}', 'open', '{$job_category}', '{$city}')";


       $result = $connection->query($query);
        if (!$result) {
            echo "Could not update data. Please contact Helpdesk." . '<br><br>';
            die ($connection->error);
        }

        else {

            ?>
        <span style="color:red;"><b> Your job has been posted.</b></span><br><br>
        
        <?php
            if ($current_category == 'Prime')
            {
                echo "You now have " . $current_jobs_number . " jobs posted. You can post " . (5 - $current_jobs_number) . " more job(s) under your Prime account, or upgrade to unlimited Gold account. <br><br>";
            }
        }
    }
}
}
?>

<!DOCTYPE html>
<html>
<!-- <meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" /> -->
<body>
<a href="EmployersDashboard.php">Back to Dashboard</a><br><br>
</body>
</html>