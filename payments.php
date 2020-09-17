<?php
session_start();
require_once 'config.php';
require_once 'util.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

 $user_id = $_SESSION['user_id'];
 
 


 //All amounts billed to a user
 $sql = "SELECT p.payment_id, p.amount, p.due_date, p.payment_date, p.payment_status, m.withdrawal_type, m.priority
 FROM Payments p
 natural join Method_of_payment m 
 WHERE p.user_id = '$user_id';";
 //echo $sql;

 

 $result = $connection->query($sql);
 //var_dump($result);
 //ids of all unpaid payments
 $result2 = $connection->query("SELECT payment_id from Payments p where payment_date is NULL and user_id ='$user_id';");
//var_dump($result2);

?>

 <!DOCTYPE html>

 <html>
 <head>

<title> Payments </title>


 </head>
 <body>
 <h1> All payments billed </h1>




 <?php show_table($result); ?>

 <h2> Make a payment </h2>
 <br>
 
 <form action="" method="post">
 
 <p>
<label for="paymentid"> Select payment id: </label>
<select name="paymentid">
 <?php
 while ($row = $result2->fetch_assoc()){
    echo "<option value='" . $row['payment_id'] . "'>" . $row['payment_id'] . "</option>";
} ?>
</select>

<input type="submit" name="makepayment" value="Pay now" />


</p>
 </form>

 <?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["makepayment"])){
    $paymentid = $_POST['paymentid'];

    //var_dump($_POST);

    //update payments table
    $result3 = $connection->query("UPDATE Payments SET payment_date = curdate(), payment_status ='completed' WHERE payment_id = '$paymentid';");
    if(! $result3 )
            {die('Could not update data: ' . $connection->connect_error);}
           // echo "Payment made succesfully\n";
            echo "<meta http-equiv='refresh' content='0'>";
}
?>





<br><br>
 <?php
if ($_SESSION['user_type'] == "Employer"){
    $back="EmployersDashboard.php";
}
else {
    $back= "EmployeeDashboard.php";
}
?>
<a href="<?php echo $back ?>" class="tww120"> Back </a>

</body>
 </html>

