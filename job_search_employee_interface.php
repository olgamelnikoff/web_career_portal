<?php
require_once 'config.php';
require_once 'util.php';
?>

<?php
//util.php function
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);


if (isset($_POST['passing_user_id_from_dashboard'])) {

    $user_id= ($_POST['user_id']);
    //echo $user_id;
}

$query_deactivated_account = "SELECT is_active FROM Users WHERE user_id ='{$user_id}'";

    $result_is_active = $connection->query($query_deactivated_account);
    

    $result_arr = $result_is_active->fetch_all();
    $is_active = (int) $result_arr[0][0];

    if ($is_active == 0)
    {
    	?>
        <span style="color:red;"><b>Your account is deactivated so you cannot search for jobs. Please make a payment to re-activate your account.</b></span><br><br>
      



       

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
    	<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" />
<script>
function closeWin() {
close();
}
</script>
<title>SEARCH FOR A JOB</title>
</head>
<body>
<!-- <?php echo "Hello " . $user_id; ?> -->
<h1> SEARCH FOR A JOB</h1>
<form action="job_search_employee.php" method="post">

<fieldset class="fieldset1">
<legend class="legend1" > Enter Job Parameters</legend>
<p></p>

<label for="job_title">Job Title: <span style="color:red;">*</span></label>
<input type="text" class="tww" id="job_title" name = "job_title" required placeholder="Job Title">
<p></p>

<label for="job_location">Job Location (city):</label>
<input type="text" class="tww2" id="job_location" name = "job_location" placeholder="Job Location (city)">
<p></p>
<p></p>
<label for="job_categ">Job Category: </label>
<input type = "text" class="tww3" id = "job_categ" name = "job_categ" placeholder="Job Category"/>

</fieldset>
<p></p>
<p></p>
<p></p>

<form action="job_search_employee.php" method="post" name = "passing_user_id_from_interface">
<input type="hidden" name= "user_id" value=<?php echo $user_id ?>>
<input type="submit" class="tww300"id="id_empedit" name="passing_user_id_from_interface" value="Submit" /><div></div>
</form>


</form>
    	<?php
    }
 ?>

 