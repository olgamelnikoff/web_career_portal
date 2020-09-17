
<?php 
require_once 'config.php';
require_once 'util.php';
?>

<?php
//util.php function
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<?php

if (isset($_POST['passing_user_id_from_interface'])) {

    $user_id= ($_POST['user_id']);
 }


if (isset($_POST['job_title'])) {
	$job_title = $_POST['job_title'];
}

if (isset($_POST['job_location'])) {
	$job_location = $_POST['job_location'];
}

if (isset($_POST['job_categ'])) {
	$job_categ = $_POST['job_categ'];
}

?>

<a href="EmployeeDashboard.php">Back to Dashboard</a><br><br>
<span style="color:red;"><b> Search Results:</span></b><br><br>

<?php
//Only job_title is entered
$query1 = 
"SELECT job_id, job_title, company_name, job_description, city, date_posted, job_status, job_category FROM Jobs j, Employer e WHERE job_title LIKE '%{$job_title}%' AND e.employer_id = j.employer_id AND job_status = 'open' ORDER BY date_posted DESC";

//Only job title and city are entered
$query2 = 
"SELECT job_id, job_title, company_name, job_description, city, date_posted, job_status, job_category FROM Jobs j, Employer e WHERE job_title LIKE '%{$job_title}%' AND e.employer_id = j.employer_id AND job_status = 'open' AND city = '{$job_location}' ORDER BY date_posted DESC";

//Only job title and category are entered
$query3 = 
"SELECT job_id, job_title, company_name, job_description, city, date_posted, job_status, job_category FROM Jobs j, Employer e WHERE job_title LIKE '%{$job_title}%' AND e.employer_id = j.employer_id AND job_status = 'open' AND job_category = '{$job_categ}' ORDER BY date_posted DESC";

//All the three parameters are entered
$query4 = "SELECT job_id, job_title, company_name, job_description, city, date_posted, job_status, job_category FROM Jobs j, Employer e WHERE job_title LIKE '%{$job_title}%' AND e.employer_id = j.employer_id AND job_status = 'open' AND city = '{$job_location}' AND job_category = '{$job_categ}' ORDER BY date_posted DESC";

if (isset($job_title)) {

	if (($job_location == "") && ($job_categ == "")) {
		$result1 = $connection->query($query1);
		//var_dump($result1);
		if ($result1) {

			show_table_job_search_result($result1, $user_id);
			echo "Was here1";

		}
			if ($result1->num_rows == 0)
			{
				echo "You search does not match any results.";
				echo "Was here2";
			}
		}
		else {
			echo "You search does not match any results.";
			echo "Was here3";
		}
	}

	else if ($job_categ == "") {
		$result2 = $connection->query($query2);
		if ($result2) {
			show_table_job_search_result($result2, $user_id);
			if ($result2->num_rows == 0)
			{
				echo "You search does not match any results.";
				echo "Was here4";
			}
		}
		else {
			echo "You search does not match any results.";
			echo "Was here5";
		}
	}

	else if ($job_location == "") {
		$result3 = $connection->query($query3);
		//var_dump($result3);
		if ($result3) {
			show_table_job_search_result($result3, $user_id);
			if ($result3->num_rows == 0)
			{
				echo "You search does not match any results.";
				echo "Was here6";
			}
		}
		else {
			echo "You search does not match any results.";
			echo "Was here5";echo "Was here7";
		}
	}

	else {
		$result4 = $connection->query($query4);
		//var_dump($result4);
		if ($result4) {
			show_table_job_search_result($result4, $user_id);
			if ($result4->num_rows == 0)
			{
				echo "You search does not match any results.";
				echo "Was here8";
			}
		}
		else {
			echo "You search does not match any results.";
			echo "Was here9";
		}
	} 
?>