<!DOCTYPE html>

<html>
<head>
	<title>Generic Form</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<a href=".">Back to Form Index</a>
<br>

<?php
require_once 'login.php';
require_once 'util.php';
$query_text = 'SELECT * FROM'
?>

<?php
//util.php function
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<?php
//fill the textarea with the file contents
if (isset($_POST['query_file'])){
	$query_text = file_get_contents($_POST['query_file']);
}
?>

<!--Open File Form-->
<form action="generic.php" method="post">
	Select a query file: <input type="file" name="query_file"><br>
	<input type="submit" value="Select File">
</form><br>

<!--Query Execution Form-->
<p>Your SQL here:</p>
<form action="generic.php" method="post" taget = "_blank">
<textarea name="generic_query" rows = 20 cols = 100><?php echo $query_text; ?>
</textarea>
<br><input type="submit">
<input type="reset">
</form><br>


<?php
//Input processing
if (isset($_POST['generic_query'])) {
	$query = $_POST['generic_query'];
	echo $query . ':<br><br>';
	
	$result = $connection->query($query);
	if (!$result) {
		echo "Could not receive query result<br><br>";
		die ($connection->error);
	}
	
	//util function - shows a query result as a table
	show_table($result);
}
?>

</body>
</html>
