<!DOCTYPE html>
<html>
<head>
	<title>Database Viewer</title>
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

$sql = "SELECT * FROM Users";

$result = $connection->query($sql);
if (!$result) {
	echo "Could not receive query result" . '<br><br>';
	die ($connection->error);
}

	//show_table($result);
	//var_dump($result);
?>
<form action="activate_deactivate_user.php" method="post">
	Select the user: <select name="user_id">
		<?php
		
		while ($row = $result->fetch_array(MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\">$row[0] $row[1] | is_active: $row[3] </option>";
		}
		?>
	</select>
	<br><br>

	Select 1 to activate the user; 0 to deactivate the user selected above: <select name="value">
		<?php
		
			echo "<option value=\"0\">0</option>";
			echo "<option value=\"1\">1</option>";
		?>
	</select>
	<br><br>
	<input type="submit" value="Submit">
</form>

<?php
if (isset($_POST['user_id']) && isset($_POST['value'])) {
	$user_id = $_POST['user_id'];
	$value = $_POST['value'];
	$query_02 = "UPDATE `Users` SET `is_active` = '$value' WHERE (`user_id` = '$user_id')";
	
	$result = $connection->query($query_02);
	if (!$result) {
		echo "Could not receive query result" . '<br><br>';
		die ($connection->error);
	}
}

?>

</body>
</html>