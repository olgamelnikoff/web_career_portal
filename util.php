<?php
//connects to database via object-oriented sqli. Returns connection.
function connect_to_db($db_hostname, $db_username, $db_password, $db_database)
{
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	if (!$connection) {
		die($connection->error);
	}
	else {
		return $connection;
	}
}

//shows a query result as a table
function show_table ($result)
{
	if ($result->num_rows > 0) {
	    //table drawing starts here
	    echo '<br><table>';
	    //first, the headers
	    echo '<tr>';
	    while ($header = $result->fetch_field()){
	    	echo '<th>' . $header->name . '</th>';
	    }
	    echo '</tr>';
	    //second, the contents
	    while($row = $result->fetch_array(MYSQLI_NUM)) {
	        echo '<tr>';
	        foreach ($row as $value) {
	        	echo '<td>' . $value . '</td>';
	        }
	        echo '</tr>';
	    }
	    echo '</table>';
	} else {
	    echo "0 results";
	}
}

function mysqli_result($res,$row=0,$col=0){
    $numrows = mysqli_num_rows($res);
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

function show_table_job_search_result ($result, $user_id)
{

	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Job_title: </b>" . mysqli_result ($result, $j, 'job_title') . "<br>";
			echo "<b>Company_name: </b>" . mysqli_result ($result, $j, 'company_name') . "<br>";
			echo "<b>City: </b>" . mysqli_result ($result, $j, 'city') . "<br>";
			echo "<b>Job_description: </b>" . mysqli_result ($result, $j, 'job_description') . "<br>";
			echo "<b>Date_posted: </b>" . mysqli_result ($result, $j, 'date_posted') . "<br>";
			echo "<b>Job_status: </b>" . mysqli_result ($result, $j, 'job_status') . "<br>";
			echo "<b>Job_category: </b>" . mysqli_result ($result, $j, 'job_category') . "<br>";
			echo "<br>";

			$job_id = mysqli_result ($result, $j, 'job_id');
			$user_id = $user_id;
			employee_open_application_button($job_id, $user_id);
			//echo $job_id;
			echo "<br>";
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function show_table_application_sent ($result)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Application status: </b>" . mysqli_result ($result, $j, 'application_status') . "<br>";
			echo "<b>Application date: </b>" . mysqli_result ($result, $j, 'application_date') . "<br>";
			$job_id = mysqli_result ($result, $j, 'job_id');
			employee_withdraw_application_button($job_id);
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}


function employee_withdraw_application_button($job_id)
{
	?>
		<form action="list_of_applications_employee.php" method="post">
		<input type="hidden" name= "withdraw_job_id" value=<?php echo $job_id ?>>
		<input type="submit" value="Withdraw this application">
		</form>
		<?php
}

function show_table_application_withdrawn ($result, $connection)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Application status: </b>" . mysqli_result ($result, $j, 'application_status') . "<br>";
			echo "<b>Application date: </b>" . mysqli_result ($result, $j, 'application_date') . "<br>";
			$job_id = mysqli_result ($result, $j, 'job_id');
			$employee_id = mysqli_result ($result, $j, 'employee_id');

			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function employee_open_application_button($job_id, $user_id)
{
	?>
		<form action="applications_employee.php" method="post">
		<input type="hidden" name= "job_id" value=<?php echo $job_id ?>>
		<input type="hidden" name= "user" value=<?php echo $user_id ?>>
		<input type="submit" value="Apply for this job">
		</form>
		<?php
}

function show_table_open_jobs_employer ($result)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Job title: </b>" . mysqli_result ($result, $j, 'job_title') . "<br>";
			echo "<b>Job description: </b>" . mysqli_result ($result, $j, 'job_description') . "<br>";
			echo "<b>City: </b>" . mysqli_result ($result, $j, 'city') . "<br>";
			echo "<b>Date posted: </b>" . mysqli_result ($result, $j, 'date_posted') . "<br>";
			echo "<b>Number of positions: </b>" . mysqli_result ($result, $j, 'number_positions') . "<br>";
			echo "<b>Job status: </b>" . mysqli_result ($result, $j, 'job_status') . "<br>";
			echo "<b>Job category: </b>" . mysqli_result ($result, $j, 'job_category') . "<br>";
			$job_id = mysqli_result ($result, $j, 'job_id');
			employer_suspend_job_button($job_id);
			employer_close_job_button($job_id);
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function show_table_suspended_jobs_employer ($result)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Job title: </b>" . mysqli_result ($result, $j, 'job_title') . "<br>";
			echo "<b>Job description: </b>" . mysqli_result ($result, $j, 'job_description') . "<br>";
			echo "<b>City: </b>" . mysqli_result ($result, $j, 'city') . "<br>";
			echo "<b>Date posted: </b>" . mysqli_result ($result, $j, 'date_posted') . "<br>";
			echo "<b>Number of positions: </b>" . mysqli_result ($result, $j, 'number_positions') . "<br>";
			echo "<b>Job status: </b>" . mysqli_result ($result, $j, 'job_status') . "<br>";
			echo "<b>Job category: </b>" . mysqli_result ($result, $j, 'job_category') . "<br>";
			$job_id = mysqli_result ($result, $j, 'job_id');
			employer_open_job_button($job_id);
			employer_close_job_button($job_id);
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function show_table_closed_jobs_employer ($result)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Job title: </b>" . mysqli_result ($result, $j, 'job_title') . "<br>";
			echo "<b>Job description: </b>" . mysqli_result ($result, $j, 'job_description') . "<br>";
			echo "<b>City: </b>" . mysqli_result ($result, $j, 'city') . "<br>";
			echo "<b>Date posted: </b>" . mysqli_result ($result, $j, 'date_posted') . "<br>";
			echo "<b>Number of positions: </b>" . mysqli_result ($result, $j, 'number_positions') . "<br>";
			echo "<b>Job status: </b>" . mysqli_result ($result, $j, 'job_status') . "<br>";
			echo "<b>Job category: </b>" . mysqli_result ($result, $j, 'job_category') . "<br>";
			$job_id = mysqli_result ($result, $j, 'job_id');
			employer_open_job_button($job_id);
			employer_suspend_job_button($job_id);
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function employer_open_job_button($job_id)
{
	?>
		<form action="view_jobs_employers.php" method="post">
		<input type="hidden" name= "open_job_id" value=<?php echo $job_id ?>>
		<input type="submit" value="Open this job">
		</form>
		<?php
}

function employer_suspend_job_button($job_id)
{
	?>
		<form action="view_jobs_employers.php" method="post">
		<input type="hidden" name= "suspend_job_id" value=<?php echo $job_id ?>>
		<input type="submit" value="Suspend this job">
		</form>
		<?php
}

function employer_close_job_button($job_id)
{
	?>
		<form action="view_jobs_employers.php" method="post">
		<input type="hidden" name= "close_job_id" value=<?php echo $job_id ?>>
		<input type="submit" value="Close this job">
		</form>
		<?php
}

function show_table_applications_employer ($result)
{
	$rows = $result->num_rows;
	for ($j = 0; $j < $rows; ++$j)
	{
		if ($result->num_rows > 0) {
			echo "<b>Job_id: </b>" . mysqli_result ($result, $j, 'job_id') . "<br>";
			echo "<b>Job title: </b>" . mysqli_result ($result, $j, 'job_title') . "<br>";
			echo "<b>Applicant First Name: </b>" . mysqli_result ($result, $j, 'f_name') . "<br>";
			echo "<b>Applicant Last Name: </b>" . mysqli_result ($result, $j, 'l_name') . "<br>";
			echo "<b>Applicant Contact Email: </b>" . mysqli_result ($result, $j, 'contact_email') . "<br>";
			echo "<b>Application date: </b>" . mysqli_result ($result, $j, 'application_date') . "<br>";
			/*echo "<b>Number of positions: </b>" . mysqli_result ($result, $j, 'number_position') . "<br>";
			echo "<b>Job status: </b>" . mysqli_result ($result, $j, 'job_status') . "<br>";
			echo "<b>Job category: </b>" . mysqli_result ($result, $j, 'job_category') . "<br>";*/
			/*$job_id = mysqli_result ($result, $j, 'job_id');
			employer_open_job_button($job_id);
			employer_suspend_job_button($job_id);*/
			echo "<br>";
		}
		else {
		    echo "0 results";
		}
	}
}

function admin_user_type($id_uname, $connection) {
	$sql_admin =
	"SELECT user_id FROM Users, Admin
	WHERE username = '{$id_uname}'
	AND user_id = admin_id";
	if (isset($id_uname)) {
		$result = $connection->query($sql_admin);
		//var_dump($result);
		$row = $result->fetch_array(MYSQLI_NUM);
		//var_dump($row);
		if ($row) {
			return true;
		}
		else {;
			return false;
		}
	}

}

function employee_user_type($id_uname, $connection) {
	$sql_employee =
	"SELECT user_id FROM Users, Employee
	WHERE username = '{$id_uname}'
	AND user_id = employee_id";
	if (isset($id_uname)) {
		$result = $connection->query($sql_employee);
		//var_dump($result);
		$row = $result->fetch_array(MYSQLI_NUM);
		//var_dump($row);
		if ($row) {
			return true;
		}
		else {;
			return false;
		}
	}

}

function employer_user_type($id_uname, $connection) {
	$sql_employer =
	"SELECT user_id FROM Users, Employer
	WHERE username = '{$id_uname}'
	AND user_id = employer_id";
	if (isset($id_uname)) {
		$result = $connection->query($sql_employer);
		//var_dump($result);
		$row = $result->fetch_array(MYSQLI_NUM);
		//var_dump($row);
		if ($row) {
			return true;
		}
		else {;
			return false;
		}
	}

}


//save user_id to SESSION
function save_user_id($connection, $id_uname) {
	session_start();
	$sql = "SELECT user_id FROM Users WHERE username = '{$id_uname}';";
	$result = $connection->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);
	$_SESSION['user_id'] = $row[0];
	// echo $_SESSION['user_id'];
}

//sanitize input
function clean_input($in) {
	$data = trim($in);
	//$data = stripslashes($in);
	$data = htmlspecialchars($in);
	return $in;
  }
?>
