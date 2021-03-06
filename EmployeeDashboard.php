<?php
ob_start();
session_start();
require_once 'config.php';
require_once 'util.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

 $user_id = $_SESSION['user_id'];
 $_SESSION['user_type'] = "Employee";


//personal info section. 
$query1 = "SELECT f_name, l_name, contact_email, address FROM Employee WHERE employee_id = '{$user_id}' ;";
$result1 = $connection->query($query1);
$row1 = $result1->fetch_array(MYSQLI_NUM);

//profile section. 
$query2 = "SELECT u.username, u.password, e.category FROM Users u, Employee e WHERE u.user_id = e.employee_id and u.user_id = '{$user_id}';";
$result2 = $connection->query($query2);
$row2 = $result2->fetch_array(MYSQLI_NUM);

//credit section. 
$query3 = "SELECT c.name_on_card, c.card_num, c.card_cvc, DATE_FORMAT(c.card_expiration, '%m') as expMonth, DATE_FORMAT(c.card_expiration, '%Y') as expYear,
m.withdrawal_type, m.priority
FROM Credit_info c, Method_of_payment m
WHERE c.user_id = '{$user_id}' AND m.method_id = c.method_id AND m.user_id = c.user_id;";
$result3 = $connection->query($query3);
//$row3 = $result3->fetch_array(MYSQLI_NUM);


//checking section. 
$query4 = "SELECT c.account_num, c.transit_num, c.institution_num,
m.withdrawal_type, m.priority
FROM Checking_info c, Method_of_payment m
WHERE c.user_id = '{$user_id}' AND m.method_id = c.method_id AND m.user_id = c.user_id;";
$result4 = $connection->query($query4);
//$row4 = $result4->fetch_array(MYSQLI_NUM);
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
<title>Employee Dashboard</title>
</head>
<body>
<h1> Employee Dashboard</h1>


<form action="job_search_employee_interface.php" method="post">
<input type="hidden" name= "user_id" value=<?php echo $user_id ?>>
<input type="submit" class="tww300"id="id_empedit" name="passing_user_id_from_dashboard" value="Search for a Job" /><div></div>
</form>
<br>
<br>


<fieldset>
<p class="lp">To edit the information, re-enter it and then click the Edit button</p>


<form action="EditEmployeeinfo.php" method="post">
<fieldset>
<legend > Personal Information </legend>

<div>
<p></p>
<label for="id_name">First Name:</label>
<input type="text" class="tn"id="id_name" name="id_name" value= "<?php echo $row1[0]?>"  autofocus>
<label class="lable1" for="id_lname">Last Name: </label>
<input type="text"  id="id_lname" class="tn" name="id_lname" value= "<?php echo $row1[1]?>" >

<p></p>
<label for="txtEmail">Email Address:</label>
<input type="email"class="te"id = "txtEmail" name="txtEmail" value= "<?php echo $row1[2]?>"/><br>
</div>
<div>
<label for="address">Address: </label>
<input type="text" id="address" class="textboxAddress" name="address" value= "<?php echo $row1[3]?>">

<p></p>
 <input type="submit" class="tww120"id="id_empedit" name="personalinfo"
value="Edit" /><div></div>

</fieldset>
</div>
<div>
<p></p>
</form>

<form action="EditEmployeeinfo.php" method="post">
<fieldset>
<legend > Profile </legend>
<label for="id_uname">Username:</label>
<input type="text" class="tww101"id="id_uname" name="username" value= "<?php echo $row2[0]?>">
<label for="id =pwd"class="pwd123">Password : </label>
<input type = "password" class="tww101"id = "pwd" name="password" value= <?php echo $row2[1]?> /><p></p>

<label >Current category: </label> <?php echo $row2[2]?>
<label for="id_gategory">Choose new Category:</label>
<select class="selectOption" name = "category">
<optgroup label="Select category">
<option value="Gold">Basic (No Charge)</option>
<option value="Prime">Prime ($50/per month)</option>
<option value="Gold">Gold ($100/per month)</option>
</select><p></p>

<input type="submit" class="tww120"id="id_empedit" name="profileinfo"
value="Edit" /><div></div>

</fieldset>
<form>
</div>
<p></p>
<fieldset>

<!-- add all credit cards -->
<legend > Credit Card Payment </legend>
<p></p>
<?php

$methodid="";


while ($row = $result3->fetch_assoc()){
    $cardname=$row['name_on_card'];
    $cardnum=$row['card_num'];
    $cvc =$row['card_cvc'];
    $expM =$row['expMonth'];
    $expY =$row['expYear'];
    $wcredit =$row['withdrawal_type'];
    $pcredit=$row['priority'];
    $methodid=$row['method_id'];

   echo '<form action= "EditEmployeeinfo.php" method="post">';
   //echo "form with method_id ".$methodid;
   // var_dump($row);
    echo '<label for="id_cardname">Name on Card: </label>';
    echo'<input type="text" class="tww101"id="id_cardname" name="cardname" value= "'.$cardname.'" >';
    echo'<label for="id =id_cnamber"class="pwd123"> Card Number: </label>';
    echo '<input type="text" class="tww108"id="id_cnamber" name="cardnumber" value= "'.$cardnum.'" >';

    echo'<p></p>';
    echo'<p></p>';
    echo'<label for="id =id_cvv" class="tww12" >CVV : </label>';
    echo'<input type="text" class="tww11"id="id_cvv" name="cvc" value= "'.$cvc.'" >';

    echo'<label for="id =withdrawltype">Withdrawal type: </label>';
    echo'<select name="creditw>';
    echo'<option value="'.$wcredit.'">'.$wcredit.'</option>';
    echo'<option value="automatic">automatic</option>';
    echo'<option value="manual">manual</option>';
echo'</select>';

echo'<label for="id =priority">method priority: </label>';
echo'<select name="creditp>';
echo'<option value="'.$pcredit.'">'.$pcredit.'</option>';
echo'<option value="main">main</option>';
echo' <option value="secondary">secondary</option>';
echo' </select>';
echo '<br>';

echo'<label for="id_gategory">expiration date: </label>';
echo'<select class="selectOption1" name="expM">';
echo'<option value="'.$expM.'">'.$expM.' </option>';
echo'<option value="01">01</option>';
echo'<option value="02">02</option>';
echo'<option value="03">03</option>';
echo'<option value="04">04</option>';
echo'<option value="05">05</option>';
echo'<option value="06">06</option>';
echo'<option value="07">07</option>';
echo'<option value="08">08</option>';
echo'<option value="09">09</option>';
echo'<option value="10">10</option>';
echo'<option value="01">11</option>';
echo'<option value="02">12</option>';
echo'</select>';
echo'<select class="selectOption1" name= "expY">';
echo'<option value="'.$expY.'">'.$expY.' </option>';
echo'<option value="2020">2020</option>';
echo'<option value="2021">2021</option>';
echo'<option value="2022">2022</option>';
echo'<option value="2023">2023</option>';
echo'<option value="2024">2024</option>';
echo'<option value="2025">2025</option>';
echo'<option value="2026">2026</option>';
echo'<option value="2027">2027</option>';
echo'<option value="2028">2028</option>';
echo'<option value="2029">2029</option>';
echo'<option value="2030">2030</option>';

echo'</select>';
echo' <p></p>';

echo'<input type="hidden" name="method_id" value="'.$methodid.'">';

echo'<p></p>';
echo'<input type="submit" class="tww120"id="id_empedit" name="creditinfo'.$methodid.'"value="Edit" /><div></div>';
echo'<input type="submit" class="tww120"id="id_empedit" name="deletecredit'.$methodid.'"value="Delete" /><div></div>';
//echo "submit creditinfo".$methodid;

echo '<br>';
echo'</form>';


}
?>
</fieldset>
<p></p>
<div></div>


<!-- adding option for checking account -->
<fieldset>
    <legend>Checking Account Payment</legend>
    <p></p>

<?php
 
 $methodidc="";
 while ($row = $result4->fetch_assoc()){
     $accountn=$row['account_num'];
     $transitn=$row['transit_num'];
     $instn=$row['institution_num'];
     $wchecking=$row['withdrawal_type'];
     $pchecking=$row['priority'];
     $methodidc=$row['method_id'];

echo'<form action="EditEmployeeinfo.php" method="post">';

echo'<label for="accountnumber">Account number:</label>';
echo'<input type="number" max="9999999999" class="tww101"id="accountnumber" name="accountn" value= "'.$accountn.'" >';
echo'<label for="transitnumber"class="pwd123">Transit number : </label>';
echo'<input type="number" max= "99999" class="tww108"id="transitnumber" name="transitn"  value= "'.$transitn.'" >';
echo'<p></p>';
echo'<p></p>';
echo'<label for="institutionnumber" class="tww12" >Institution number : </label>';
echo'<input type="number" max="999" class="tww11"id="institutionnumber" name="instn" value= "'.$instn.'">';
echo'<label for="id =withdrawltype">Withdrawl type: </label>';
echo'<select name="checkingw">';
echo'<option value="'.$wchecking.'">'.$wchecking.'</option>';
echo'<option value="automatic">automatic</option>';
echo'<option value="manual">manual</option>';
echo'</select>';

echo'<label for="id =priority">method priority: </label>';
echo'<select name="checkingp">';
echo'<option value="'.$pchecking.'">'.$pchecking.'</option>';
echo'<option value="main">main</option>';
echo'<option value="secondary">secondary</option>';
echo'</select>';

echo'<p></p>';
echo'<input type="hidden" name="method_id" value="'.$methodidc.'">';

echo'<p></p>';
echo'<input type="submit" class="tww120"id="id_empedit" name="checkinginfo'.$methodidc.'" value="Edit" /><div></div>';
echo'<input type="submit" class="tww120"id="id_empedit" name="deletechecking'.$methodidc.'" value="Delete" /><div></div>';

echo'</form>';

 }
 ?>



</fieldset>
<p></p>

</fieldset>
<!-- </form> -->

<form action ="newPaymentMethod.php">
 <input type="submit" class="tww300"id="id_empedit" name="emp" value="Add new payment method" />
</form>

<p></p>
<!-- <form action="apply_job_employeeprg.php" method="post">
<fieldset>
<div>
<label for="postjob">job Application</label><br>
<input type="text"id="jobname" class="textboxAddress" placeholder="JobName
"><input type="text" id="education"class="textboxAddress" placeholder="Education
"><br>
<input type="text"id="skills" class="textboxAddressDetail"
placeholder="skills">
<input type="text" id="work_experience"class="textboxAddressDetail"
placeholder="Work Experience"><input type="text" id="location"class="textboxAddressDetail"
placeholder="location"><br>
<div class="submit">
<input type="submit" id="id_emp" name="emp"
value="submit" />
<input type = "reset" />
<button onclick="closeWin()">Close</button>
</fieldset>
</div>
</form> -->
<!-- <form action="list_of_applications.php" method="post"> -->
<!-- <input type="hidden" name= "job_id" value=<?php echo $job_id ?>> -->
<!-- <input type="hidden" name= "user_id" value=<?php echo $user_id ?>> -->
<!-- <input type="hidden" name= "application_status" value="sent"> -->
<!-- </form> -->
<!-- 
</form> -->
</form>
<br>
<form action="deleteprofile.php">
<input type="submit" class="tww300"id="id_empedit" name="deleteprofile" value="Delete your account" /><div></div>
</form>

<!-- Links to other actions -->
<section>
<legend>Links</legend>

<li><a href="list_of_applications_employee.php">View and manage my applications</a></p></li>
<li><a href="payments.php">View and make payments</a></p></li>
<li><a href="mailto:exc55311@encs.concordia.ca">Contact Career Portal Helpdesk</a></p></li>

</section>
<form action="logout.php" method="post">
<input type="submit" class="tww300"id="id_empedit" name="logout" value="logout" /><div></div>
</form>


</body>
</html>
<?php ob_end_flush(); ?>
