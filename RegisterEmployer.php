<?php
session_start();
require_once 'util.php';
require_once 'config.php';

$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);

//echo "made it to registration page";

$username = "";
$email    = "";
$errors = array();


if (isset($_POST['register'])) {

    $username=clean_input($_POST['username']);
    $password=clean_input($_POST['password']);
    $fname =$connection -> real_escape_string(clean_input($_POST['fname']));
    $lname =$connection -> real_escape_string(clean_input($_POST['lname']));
    $email =clean_input($_POST['email']);
    $website =clean_input($_POST['url']);
    $address =$connection -> real_escape_string(clean_input($_POST['address']));
    $company =clean_input($_POST['company']);
    $category=$connection -> real_escape_string(clean_input($_POST['category']));

    //credit
    $namecard =$connection -> real_escape_string(clean_input($_POST['FullName']));
    $credit = clean_input($_POST['ccnumber']);
    $cvc = clean_input($_POST['CVC']);
    $expdate = $_POST['expY'];
    $expdate .= "-" .$_POST['expM']. "-01";
    $withdrawalcred = clean_input($_POST['wcredit']);
    $prioritycred = clean_input($_POST['pcredit']);

    //checking
    $accountn = clean_input($_POST['accountnumber']);
    $transitn = clean_input($_POST['transitnum']);
    $instn = clean_input($_POST['institutionnum']);
    $withdrawalche = clean_input($_POST['wchecking']);
    $priorityche = clean_input($_POST['pchecking']);

//do more verification
    // echo $username;
    // echo $password;
    // echo $fname;
    // echo $lname;
    // echo $email;
    // echo $website;
    // echo $company;
    // echo $category;

    // print_r($errors);
    // echo "CREDIT";
    // echo $namecard;
    // echo $credit;
    // echo $cvc;
    // echo $expdate;
    // echo $withdrawalcred;
    // echo $prioritycred;
    // echo "DEBIT";
    // echo $accountn;
    // echo $transitn;
    // echo $instn;
    // echo $withdrawalche;
    // echo $priorityche;

    //check username unique
    $sql = "SELECT username FROM Users WHERE username='$username';";
    $result = $connection->query($sql);

    if ($result->num_rows !=0) { //usrename already exists
        array_push($errors, "Username already exists");
    }
   
    //actual insert goes in here 
    if (count($errors) == 0) {
        //first insert into Users
       $sql="INSERT INTO `Users` (`username`, `password`, `is_active`) VALUES ('$username', '$password', '1');";
       $result = $connection->query($sql);
       if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
        //echo "Updated data successfully\n";

       //get user_id for session and for future queries
        $sql = "SELECT user_id FROM Users WHERE username = '$username';";
	    $result = $connection->query($sql);
	    $row = $result->fetch_array(MYSQLI_NUM);
        $_SESSION['user_id'] = $row[0];
        $user_id = $row[0];

        //insert into employers

        $sql="INSERT INTO Employer (employer_id,company_name, f_name, l_name, address, company_website, contact_email, category, account_status)
                VALUES  ('$user_id', '$company','$fname','$lname', '$address', '$website', '$email', '$category', 'active');";
        $result = $connection->query($sql);
        if(! $result )
    {die('Could not update data: ' . $connection->connect_error);}
        //echo "Updated data successfully\n";

        //Payments
        //if has filled credit card
        if (isset($namecard)) {
            //insert into method of payment
            $sql = "INSERT INTO Method_of_payment (method_id, user_id, withdrawal_type, priority) 
            values (1, '$user_id', '$withdrawalcred', '$prioritycred');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
           // echo "Updated data successfully\n";

            //insert into credit_info
            $sql = "INSERT INTO Credit_info (method_id, user_id, card_num, card_expiration, card_cvc, name_on_card) values (1, '$user_id', '$credit', '$expdate', '$cvc', '$namecard');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
           // echo "Updated data successfully\n";

            //check if debit is also set
            //yes, do the same
            if (isset($accountn)) {
                //insert into method of payment
                $sql = "INSERT INTO Method_of_payment (method_id, user_id, withdrawal_type, priority) 
            values (2, '$user_id', '$withdrawalche', '$priorityche');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
           // echo "Updated data successfully\n";

            //insert into checking
            $sql = "INSERT INTO Checking_info (method_id, user_id, account_num, transit_num, institution_num) values (2, '$user_id', '$accountn', '$transitn', '$instn');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
           // echo "Updated data successfully\n";

            }

        }
        else if (isset($accountn)){ 
            //only checking set
            //insert into method of payment
            //insert into checking_info
            //insert into method of payment
            $sql = "INSERT INTO Method_of_payment (method_id, user_id, withdrawal_type, priority) 
            values (1, '$user_id', '$withdrawalche', '$priorityche');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
          //  echo "Updated data successfully\n";

            //insert into checking
            $sql = "INSERT INTO Checking_info (method_id, user_id, account_num, transit_num, institution_num) values (1, '$user_id', '$accountn', '$transitn', '$instn');";
            $result= $connection->query($sql);
            if(! $result )
            {die('Could not update data: ' . $connection->connect_error);}
          //  echo "Updated data successfully\n";

        }



       //redirect to dashboard
      header( "Location: EmployersDashboard.php");
    }
}


?>