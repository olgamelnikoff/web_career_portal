<?php
require_once 'config.php';
require_once 'util.php';

echo $_SESSION['user_id'];

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);


if (isset($_POST['job_id']) && isset($_POST['employee_id'])) {
    $job_id = $_POST['job_id'];
    $employee_id = $_POST['employee_id'];
    $query = 
    "INSERT INTO `Applied_to` (`job_id`, `employee_id`, `application_status`) VALUES ('{$job_id}', '{$employee_id}', 'sent')";
    //var_dump($result);
    $result = $connection->query($query);
    if (!$result) {
        //die ($connection->error);
        ?>
        <span style="color:red;"><b>You have already submitted an application for this job.</b></span><br><br>

       

        <!DOCTYPE html>
<html>
<!-- <meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" /> -->
<body>
<a href="EmployeeDashboard.php">Back to Dashboard</a><br><br>
</body>
</html>
 <?php
    }

    else {
    	?>
        <span style="color:red;"><b>Your application has been sent.</b></span><br><br>

       

        <!DOCTYPE html>
<html>
<!-- <meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" /> -->
<body>
<a href="EmployeeDashboard.php">Back to Dashboard</a><br><br>
</body>
</html>
 <?php
    }
}
?>

