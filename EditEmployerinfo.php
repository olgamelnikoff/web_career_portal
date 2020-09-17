<?php
session_start();
require_once 'config.php';
require_once 'util.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
$user_id = $_SESSION['user_id'];


//echo "made it to this page with method id ".$_SESSION['methodid'];
//echo "methodid is ".$_POST['method_id'];

if (isset($_POST['personalinfo'])) {

       // echo "made it into personalinfo\n";
        $fname = $connection -> real_escape_string(clean_input($_POST["id_name"]));
        $lname = $connection -> real_escape_string(clean_input($_POST['id_lname']));
        $company = $connection -> real_escape_string(clean_input($_POST['id_cname']));
        $email = $connection -> real_escape_string(clean_input($_POST['txtEmail']));
        $website = $connection -> real_escape_string(clean_input($_POST['url']));
        $address = $connection -> real_escape_string(clean_input($_POST['address']));

        $sql = "UPDATE `Employer` SET `company_name` = '$company', `f_name` = '$fname', `l_name` = '$lname', `address` = '$address', `company_website` = '$website', `contact_email` = '$email' WHERE (`employer_id` = '$user_id');";
//var_dump($sql);
        $result = $connection->query($sql);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}

        header( "Location: EmployersDashboard.php");
}

        
if (isset($_POST['profileinfo'])) {
   // echo "made it into profile info";
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    $category = clean_input($_POST['category']);

    $result = $connection->query("SELECT user_id FROM USERS WHERE user_id='$username");
    if ($result->num_rows ==0){
        $sql1 ="UPDATE Users SET username='$username', `password` = '$password' WHERE (`user_id` = '$user_id');";
        $sql2 ="UPDATE Employer SET category='$category' WHERE (`employer_id` = '$user_id');";

        $result = $connection->query($sql1);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
      //  echo "Updated data successfully\n";
    
    $result = $connection->query($sql2);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
      //  echo "Updated data successfully\n";
        
}

else{ //do not update username (it already exists)
    $sql1 ="UPDATE Users SET `password` = '$password' WHERE (`user_id` = '$user_id');";
        $sql2 ="UPDATE Employer SET category='$category' WHERE (`employer_id` = '$user_id');";

        $result = $connection->query($sql1);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
      //  echo "Updated data successfully\n";
    
    $result = $connection->query($sql2);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
       // echo "Updated data successfully\n";
}  
header( "Location: EmployersDashboard.php");
}  




if (isset($_POST['creditinfo'.$_POST['method_id']])) {

    $cardname=$connection -> real_escape_string(clean_input($_POST['cardname']));
    $cardnum=clean_input($_POST['cardnumber']);
    $cvc =clean_input($_POST['cvc']);
    $expdate = $_POST['expY']."-" .$_POST['expM']. "-01";
    $wcredit =clean_input($_POST['creditw']);
    $pcredit=clean_input($_POST['creditp']);
    $methodid=clean_input($_POST['method_id']);
   // var_dump($_POST);
  //  echo $expdate;
  //  echo $_POST['expY'];

    //update method of payment and credit_info
    $sql1 = " UPDATE Method_of_payment SET withdrawal_type = '$wcredit', priority = '$pcredit' WHERE method_id = '$methodid' AND user_id='$user_id';";
    $sql2 = "UPDATE Credit_info SET card_num='$cardnum', card_expiration ='$expdate', card_cvc ='$cvc', name_on_card='$cardname' WHERE method_id = '$methodid' AND user_id='$user_id';";

    $result = $connection->query($sql1);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
       //   echo "Updated data successfully in method_of_payment\n";
    $result = $connection->query($sql2);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
       //   echo "Updated data successfully in credit_info\n";

       header( "Location: EmployersDashboard.php");
        } 

if (isset($_POST['checkinginfo'.$_POST['method_id']])) {

    $accountn=clean_input($_POST['accountn']);
     $transitn=clean_input($_POST['transitn']);
     $instn=clean_input($_POST['instn']);
     $wchecking=clean_input($_POST['checkingw']);
     $pchecking=clean_input($_POST['checkingp']);
     $methodidc=clean_input($_POST['method_id']);

    

     //var_dump($_POST);

      //update method of payment and credit_info
    $sql1 = " UPDATE Method_of_payment SET withdrawal_type = '$wchecking', priority = '$pchecking' WHERE method_id = '$methodidc' AND user_id='$user_id';";
    $sql2 = "UPDATE Checking_info SET account_num='$accountn', transit_num ='$transitn', institution_num ='$instn' WHERE method_id = '$methodidc' AND user_id='$user_id';";

    $result = $connection->query($sql1);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
         //echo "Updated data successfully in method_of_payment\n";
    $result = $connection->query($sql2);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
          //echo "Updated data successfully in credit_info\n";

       header( "Location: EmployersDashboard.php");

    } 

if (isset($_POST['deletecredit'.$_POST['method_id']])) {
  $methodid = $_POST['method_id'];


  $sql1 = "DELETE FROM Credit_info WHERE method_id='$methodid' AND user_id='$user_id';";
  $sql2 ="DELETE FROM Method_of_payment WHERE method_id='$methodid' AND user_id='$user_id';";

  $result = $connection->query($sql1);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
        // echo "data deleted in credit\n";
    $result = $connection->query($sql2);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
        //  echo "data deleted in method";
        header( "Location: EmployersDashboard.php");


}

if (isset($_POST['deletechecking'.$_POST['method_id']])) {
  //echo "delete checking";

  $methodid = $_POST['method_id'];
 // echo $methodid;


  $sql1 = "DELETE FROM Checking_info WHERE method_id='$methodid' AND user_id='$user_id';";
  $sql2 ="DELETE FROM Method_of_payment WHERE method_id='$methodid' AND user_id='$user_id';";

  $result = $connection->query($sql1);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
        // echo "data deleted in credit\n";
    $result = $connection->query($sql2);
        if(! $result )
        {die('Could not update data: ' . $connection->connect_error);}
        //  echo "data deleted in method";
        header( "Location: EmployersDashboard.php");

}

?>
