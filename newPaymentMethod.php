<?php
session_start();
require_once 'config.php';
require_once 'util.php';

?>

<?php 
//not sure where is best spot to put php
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
$user_id = $_SESSION['user_id'];

//get current method_id
$result = $connection->query("select max(method_id) from Method_of_payment WHERE user_id='$user_id';"); //switch back to 
$value = $result->fetch_row()[0]; 
//echo $value;
if (is_null($value)){
    $value =1;
}
else {
    ++$value;
}
//echo " new method_id". $value;

if (isset($_POST['creditinfo'])) {

    $namecard =$connection -> real_escape_string(clean_input($_POST['cardname']));
    $credit = clean_input($_POST['cardnumber']);
    $cvc = clean_input($_POST['cvc']);
    $expdate = $_POST['expY'];
    $expdate .= "-" .$_POST['expM']. "-01";
    $withdrawalcred = clean_input($_POST['creditw']);
    $prioritycred = clean_input($_POST['creditp']);

    $sql = "INSERT INTO Method_of_payment (method_id, user_id, withdrawal_type, priority) 
            values ('$value', '$user_id', '$withdrawalcred', '$prioritycred');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
            echo "Updated method data successfully\n";

            //insert into credit_info
            $sql = "INSERT INTO Credit_info (method_id, user_id, card_num, card_expiration, card_cvc, name_on_card) values ('$value', '$user_id', '$credit', '$expdate', '$cvc', '$namecard');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
            echo "Updated credit data successfully\n";
} 

if (isset($_POST['checkinginfo'])) {


    $accountn = clean_input($_POST['accountn']);
    $transitn = clean_input($_POST['transitn']);
    $instn = clean_input($_POST['instn']);
    $withdrawalche = clean_input($_POST['checkingw']);
    $priorityche = clean_input($_POST['checkingp']);

    //insert into method of payment
    $sql = "INSERT INTO Method_of_payment (method_id, user_id, withdrawal_type, priority) 
    values ('$value', '$user_id', '$withdrawalche', '$priorityche');";
    $result= $connection->query($sql);
    if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
    echo "Updated method data successfully\n";

    //insert into checking
    $sql = "INSERT INTO Checking_info (method_id, user_id, account_num, transit_num, institution_num) values ('$value', '$user_id', '$accountn', '$transitn', '$instn');";
    $result= $connection->query($sql);
    if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
    echo "Updated checking data successfully\n";

} 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href = "myStyle2.css" />
    <title>Add new method of payment</title>
    <h1> Add a new payment method</h1>

</head>
<body>

    <form action= "newPaymentMethod.php" method="post">
        <fieldset>
        <legend > Credit Card Payment </legend>
        <p></p>
        <label for="id_cardname">Name on Card:</label>
        <input type="text" class="tww101"id="id_cardname"  name="cardname" required>
        <label for="id =id_cnamber"class="pwd123">Card Number : </label>
        <input type="text" class="tww108"id="id_cnamber"  name="cardnumber" required>
        <p></p>
        <p></p>
        <label for="id =id_cvv" class="tww12" >CVV : </label>
        <input type="number" max="999" class="tww11"id="id_cvv"  name="cvc" required><b/>

        <label for="id =withdrawltype">Withdrawl type: </label>
        <select name="creditw">
            <option value="automatic">automatic</option>
            <option value="manual">manual</option>
        </select>

        <label for="id =priority">method priority: </label>
        <select name="creditp">
            <option value="main">main</option>
            <option value="manual">secondary</option>
        </select>

        <p></p>
        <label for="id_gategory">EXPIRATION:</label>
        <select class="selectOption1" name="expM">
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="01">11</option>
        <option value="02">12</option>
        </select>
        <select class="selectOption1" name="expY">
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
        <option value="2026">2026</option>
        <option value="2027">2027</option>
        <option value="2028">2028</option>
        <option value="2029">2029</option>
        <option value="2030">2030</option>
        <option value="2031">2031</option>
        <option value="2032">2032</option>
        <option value="2033">2033</option>
        <option value="2034">2034</option>
        </select>
        
        <p></p>
        <input type="submit" class="tww120"id="id_empedit" name="creditinfo"
        value="submit" /><div></div>
        </fieldset>
        </div>
        <p></p>
    </form>


    <form action="newPaymentMethod.php" method="post">
        <fieldset>
            <legend>Checking Account Payment</legend>
            <p></p>
        <label for="accountnumber">Account number:</label>
        <input type="number" max="9999999999" class="tww101"id="accountnumber" name="accountn" required" >
        <label for="transitnumber"class="pwd123">Transit number : </label>
        <input type="number" max= "99999" class="tww108"id="transitnumber"  name="transitn" required >
        <p></p>
        <p></p>
        <label for="institutionnumber" class="tww12" >Institution number : </label>
        <input type="number" max="999" class="tww11"id="institutionnumber"  name="instn" required>
        <label for="id =withdrawltype">Withdrawl type: </label>
        <select name="checkingw">
            <option value="automatic">automatic</option>
            <option value="manual">manual</option>
        </select>

        <label for="id =priority">method priority: </label>
        <select name="checkingp">
            <option value="automatic">main</option>
            <option value="manual">secondary</option>
        </select>

        <p></p>
        <p></p>
        <input type="submit" class="tww120"id="id_empedit" name="checkinginfo"
        value="submit" /><div></div>


        </fieldset>

        </fieldset>
        </form>


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