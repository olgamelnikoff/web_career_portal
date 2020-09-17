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


    $query = "SELECT job_id, job_title FROM Jobs WHERE employer_id = '{$user_id}' AND job_status = 'open' ORDER BY date_posted DESC";

    $result = $connection->query($query);
    //var_dump($result);
    if (!$result) {
        echo "Could not receive query result" . '<br><br>';
        die ($connection->error);
    }

    $result_arr = $result->fetch_all();
    //var_dump($result_arr);
    ?>

    <form action="view_applications_employers.php" method="post">
        <span style="color:red;"><b> Select a Job from Open Jobs List to View Applications:</b><br><br></span><select name="job">
        <?php
        foreach ($result_arr as $row) {
             echo "<option value=\"$row[0]\">$row[0] $row[1]</option>";
         }
        ?>
    </select>
    <br><br>
    <input type="submit" value="Show Applications For This Job">
</form>

<?php
if (isset($_POST['job'])) {
    $job = $_POST['job'];
        /*echo "Was here";
        echo "<br>Table: <b>$table</b>";*/
    $query_02 = "SELECT a.job_id, j.job_title, e.f_name, e.l_name, e.contact_email, a.application_date, a.application_status FROM Jobs j, Employee e, Applied_to a WHERE a.employee_id = e.employee_id AND j.job_status = 'open' AND a.job_id = j.job_id AND j.job_id = '{$job}'ORDER BY date_posted DESC ";
    
    $result = $connection->query($query_02);
    if (!$result) {
        echo "Could not receive query result" . '<br><br>';
        die ($connection->error);
    }
    
    //util function, shows query result as a table
    show_table($result);
}
?>
</body>
</html>