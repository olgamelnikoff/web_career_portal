<!DOCTYPE html>
<html>
<head>
	<title>See All Activities</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<a href="AdminDashboard.php">Back to Dashboard</a><br><br>

<?php
require_once 'config.php';
require_once 'util.php';
?>

<?php
//FUNCTION connect($db_hostname, $db_username, $db_password, $db_database)
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<!-- tables -->
<?php
$sql = "SHOW TABLES
FROM exc55311
WHERE `Tables_in_exc55311` LIKE 'Admin'
OR `Tables_in_exc55311` LIKE 'Applied_to'
OR `Tables_in_exc55311` LIKE 'Checking_info'
OR `Tables_in_exc55311` LIKE 'Credit_info'
OR `Tables_in_exc55311` LIKE 'Employee'
OR `Tables_in_exc55311` LIKE 'Employer'
OR `Tables_in_exc55311` LIKE 'Jobs'
OR `Tables_in_exc55311` LIKE 'Method_of_payment'
OR `Tables_in_exc55311` LIKE 'Offered_to'
OR `Tables_in_exc55311` LIKE 'Payments'
OR `Tables_in_exc55311` LIKE 'Users'";
$result_tables = $connection->query($sql);
if (!$result_tables) {
	echo "Could not receive query result" . '<br><br>';
	die ($connection->error);
}
?>

<form action="see_all_activities.php" method="post">
	Select a table to view: <select name="table">
		<?php
		while ($row = $result_tables->fetch_array(MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\">$row[0]</option>";
		}
		?>
	</select>
	<br><br>
	<input type="submit" value="Show Table">
</form>

<?php
if (isset($_POST['table'])) {
	$table = $_POST['table'];
	echo "<br>Table: <b>$table</b>";
	$query_02 = "SELECT * FROM " . $table;
	
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