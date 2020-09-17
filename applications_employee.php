<?php
session_start();
require_once 'config.php';
require_once 'util.php';

//echo $_SESSION['user_id'];

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

 //$user_id = $_SESSION['user_id'];

 if (isset($_POST['user'])) {

    $user_id= ($_POST['user']);
    //echo $user_id;

    $query_employee_category = "SELECT category FROM Employee WHERE employee_id='{$user_id}'";  
    $result_category = $connection->query($query_employee_category);
    

    $result_arr = $result_category->fetch_all();

    $current_category = $result_arr[0][0];

    //echo $current_category;

    if ($current_category == "Basic")
    {
    	?>
        <span style="color:red;"><b> Your account type is Basic so you cannot apply for jobs.</span><br><br>Please upgrade your account to Prime or Gold in your Dashboard to be able to apply for Jobs.</b><br><br>
		<a href="EmployeeDashboard.php">Back to Dashboard</a><br><br>
		 <?php
        
    }

    else
    {
    	$query_applications_number = "SELECT COUNT(a.job_id) FROM Applied_to a, Jobs j WHERE a.employee_id ='{$user_id}' AND j.job_id = a.job_id AND (j.job_status = 'open' OR j.job_status = 'suspended') AND application_status = 'sent'";

	    $result_applications_number = $connection->query($query_applications_number);

	    $result_arr2 = $result_applications_number->fetch_all();
	    $current_applications_number = (int) $result_arr2[0][0];
	    //echo $current_applications_number;

	    if ($current_category == "Prime" && $current_applications_number == 5) {
		        ?>
		        <span style="color:red;"><b> You have exceeded the limit of applications for your account.</span><br><br>The limit for Prime is 5 sent applications in total. To be able to maintain an unlimited number of sent applications, please upgrade your account to Gold in your Dashboard</b><br><br>

		        <a href="EmployeeDashboard.php">Back to Dashboard</a><br><br>
		
		        
		        <?php


    	}

    	else {

    		//personal info section. 
$query1 = "SELECT f_name, l_name, contact_email FROM Employee WHERE employee_id = '{$user_id}' ;";
$result1 = $connection->query($query1);
$row1 = $result1->fetch_array(MYSQLI_NUM);

if (isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle2.css" />
<script>
function closeWin() {
close();
}
</script>
<title>Application Page</title>
</head>
<body>
<h1> Apply for job id number <?php echo $job_id; ?></h1>

<!-- Start of the big F -->
<form action="upload_application.php" method="post">

<!-- Start of the big FS -->
<fieldset>
<p class="lp">To edit the information, re-enter it and then click the Edit button</p>


<!-- Start of the internal F1 -->
<form action= "EditEmployeeinfo.php" method="post">

<!-- Start of the internal FS1 -->    
<fieldset>
<legend > Personal Information </legend>

<div>
<p></p>

<label for="id_name">First Name:<span style="color:red;">*</span></label>
<input type="text" class="tn"id="id_name" name="id_name" value= "<?php echo $row1[0]?>"required/>

<!-- <input type="text" class="tn"id="id_name" name="id_name" value= "<?php ?>" required/> -->

<label class="lable1" for="id_lname">Last Name:<span style="color:red;">*</span> </label>
<input type="text"  id="id_lname" name="id_lname" class="tn" value= "<?php echo $row1[1]?>"required/>

<!-- <input type="text"  id="id_lname" name="id_lname" class="tn" value= "<?php ?>"required/> -->

<label for="txtEmail">Email Address:<span style="color:red;">*</span></label>
<input type="email"class="tww2"id = "txtEmail" name= "txtEmail" value= "<?php echo $row1[2]?>"required/>

</div>


<div>
<p></p>
 <input type="submit" class="tww120"id="id_empedit" name="personalinfo"
value="Edit" /><div></div>

<!-- End of the internal FS1 -->
</fieldset>
</div>
    
<p></p>
<!-- End of the internal F1 -->
</form>

<fieldset>
<legend > Resume<span style="color:red;">*</span> </legend>

<!--Open File Form-->

Select your resume file: <input type="file" name="resume_file" required><br>
<!-- Select your resume file: <input type="file" name="resume_file" required><br> -->


<!--button onclick="closeWin()" class="tww121">Edit Information</button><br-->
<p></p>
</fieldset>

</div>
<p></p>
<fieldset>
<legend > Cover Letter </legend>

<!--Open File Form-->

Select your cover letter file: <input type="file" name="cover_letter_file"><br><br>


<!--button onclick="closeWin()" class="tww121">Edit Information</button><br-->
<p></p>
</fieldset>

</div>
<p></p>

<input type="hidden" name= "job_id" value=<?php echo $job_id ?>>
<input type="hidden" name= "employee_id" value=<?php echo $user_id ?>>
<div class="submit">
    
<input type="submit" id="id_emp" name="emp"
value="Submit" />

</fieldset>
</div>
<!-- End of the big F -->
</form>
</body>
</html>

<?php

    	}
    	//html ends here
	}	
	///last bracket in code    
}
?>