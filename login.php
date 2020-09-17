<?php 
//to store user_id
//session_start();
ob_start();

require_once 'config.php';
require_once 'util.php';
?>

<?php
//util.php function
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<?php
//var_dump($_POST);
if (isset($_POST['id_uname'])) {
	$id_uname = $_POST['id_uname'];
	/*echo $id_uname;
	echo "<br>";*/
}
if (isset($_POST['pwd'])) {
	$pwd = $_POST['pwd'];
	/*echo $pwd;
	echo "<br>";*/
}
if (isset($_POST['forget'])) {
	$forget = $_POST['forget'];
	/*echo $forget;
	echo "<br>";*/
}



$sql = "SELECT username FROM Users WHERE username = '{$id_uname}'";

if (isset($id_uname)) {
	$result = $connection->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);
	//var_dump($row);
	if ($row) {
		//echo "User found" . "<br>";
	}
	else {
		echo "User not found. <br>";
	}
	
}



$sql = "SELECT password FROM Users 
		WHERE username = '{$id_uname}' 
		AND password = '{$pwd}'";

if (isset($pwd)) {
	$result = $connection->query($sql);
	//var_dump($result);
	$row = $result->fetch_array(MYSQLI_NUM);
	//var_dump($row);
	if ($row) {
		//echo "Password correct" . "<br>";
		if (employee_user_type($id_uname, $connection)) {
			save_user_id($connection, $id_uname);
			header("location: EmployeeDashboard.php");
			//echo "Employee correct";
		}

		else if (employer_user_type($id_uname, $connection)) {
			//echo "Employeer correct";
			save_user_id($connection, $id_uname);
			header("location: EmployersDashboard.php");
		}

		else {
			//echo "Admin correct";
			save_user_id($connection, $id_uname);
			header("location: AdminDashboard.php");
		}
		/*else{
			?>
			<a href="login.html">Back to Form Index</a>;
			<?php
		}*/
	}
	else {
		echo "Password not correct.<br>";
		?>
		<a href="login.html">Back to Form Index</a>;
		<?php
	}
}



ob_end_flush()
?>
