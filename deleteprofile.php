<?php
session_start();
require_once 'config.php';
require_once 'util.php';

//echo $_SESSION['user_id'];

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

 $user_id = $_SESSION['user_id'];

 if ($_SESSION['user_type'] == "Employee"){
     $url = "EmployeeDashboard.php";
 }
 else if ($_SESSION['user_type'] == "Employer"){
    $url = "EmployersDashboard.php";
 }
 else if ($_SESSION['user_type'] == "Admin"){
    $url = "AdminDashboard.php";
 }
    else {
        $url = "index.html";
    }
    
 ?>

 <!DOCTYPE html>

 <html>
<head>
<title>Delete your account</title>
<h1 style="color:Tomato;" > Delete your account </h1>
</head>
<body>
<b>Are you sure you want to delete your account?</b>
<br><br>

<form action="<?php echo $url?>">
<input type="submit"  name="goback" value="NO" /><div></div>
</form>
<br>

<form action="" method="post">
<input type="submit" name="delete" value="YES, delete my account" /><div></div>
</form>

<?php 
if (isset($_POST['delete'])) {
   // echo "ented delete section";
    
    $sql ="DELETE FROM Users WHERE user_id='$user_id';";

    $result = $connection->query($sql);
    if(! $result )
    {die('Could not delete account: ' . $connection->connect_error);}
    echo '<br>';
    echo "Account successfully deleted\n";
    echo '<br>';
    echo '<a href="index.html">back to homepage </a>';
}
 ?>

</body>
</html>