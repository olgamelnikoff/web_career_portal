<?php
ob_start();
session_start();
require_once 'config.php';
require_once 'util.php';

//echo $_SESSION['user_id'];

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

 $user_id = $_SESSION['user_id'];
 $_SESSION['user_type'] = "Admin";

 //profile section. 
$query1 = "SELECT u.username, u.password FROM Users u WHERE user_id = '{$user_id}';";
$result1 = $connection->query($query1);
$row1 = $result1->fetch_array(MYSQLI_NUM);

if (isset($_POST['profileinfo'])) {
	//echo "made it into profile info";
	 $username = clean_input($_POST['username']);
	 $password = clean_input($_POST['password']);

	 $result = $connection->query("SELECT user_id FROM USERS WHERE user_id='$username");
    if ($result->num_rows ==0){
        $sql1 ="UPDATE Users SET username='$username', `password` = '$password' WHERE (`user_id` = '$user_id');";

        $result = $connection->query($sql1);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
      //  echo "Updated data successfully\n";
	}
	else {
		$sql1 ="UPDATE Users SET `password` = '$password' WHERE (`user_id` = '$user_id');";

        $result = $connection->query($sql1);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
	}
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
<title>Admin's Dashboard</title>
</head>
<body>
<h1> Admin's Dashboard</h1>
<fieldset>
<p class="lp">To edit the information, re-enter it and then click the Edit button</p>

<form action="AdminDashboard.php" method="post">
<fieldset>
<legend > Profile </legend>
<!-- <p class="lp">To add a new admin,the checkbox button must be selected</p> -->
<label for="id_uname">User Name:</label>
<input type="text" class="tww101"id="id_uname" name="username" value= "<?php echo $row1[0]?>" >
<label for="id =pwd"class="pwd123">Password : </label>
<input type = "password" class="tww101"id = "pwd" name="password" value= <?php echo $row1[1]?> /><p></p>
<!-- <input type = "checkbox" class="bo"id = "newadmin"value = "newadmin" />ADD New Admin<br> -->
<!--button onclick="closeWin()" class="tww121">Edit Information</button><br-->
<p></p>
 <input type="submit" class="tww120"id="id_empedit" name="profileinfo" value="Edit" /><div></div>
</fieldset>
</form>

</div>
<p></p>
</form>
<br>
<form action="deleteprofile.php">
<input type="submit" class="tww300"id="id_empedit" name="deleteprofile" value="Delete your account" /><div></div>
</form>

<section>
<legend>Links</legend>
<ul>
	<li><a href="see_all_activities.php">See All Users and Activities</a></li>
	<li><a href="activate_deactivate_user.php">Activate or Deactivate a User</a></li>
	<li><a href="generic.php">Generic Form for Database Queries</a></li>
</ul>
</section>
</form>
<br>
<form action="logout.php" method="post">
<input type="submit" class="tww300"id="id_empedit" name="logout" value="logout" /><div></div>
</form>

</body>
</html>
<?php ob_end_flush(); ?>