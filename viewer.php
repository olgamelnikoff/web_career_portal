<!DOCTYPE html>
<html>
<head>
	<title>Database Viewer</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<a href=".">Back to Index</a><br><br>

<?php
require_once 'login.php';
require_once 'util.php';
?>

<?php
//FUNCTION connect($db_hostname, $db_username, $db_password, $db_database)
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<!-- tables -->
<?php
$result_tables = $connection->query("SHOW TABLES");
if (!$result_tables) {
	echo "Could not receive query result" . '<br><br>';
	die ($connection->error);
}
?>

<form action="viewer.php" method="post">
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
