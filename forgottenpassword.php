<?php
require_once 'config.php';
require_once 'util.php';

//util.php function
$connection = connect_to_db($db_hostname, $db_username, $db_password, $db_database);
?>

<!DOCTYPE html>

<html>
<head>
    <title>Forgotten Passord</title>
    <h1> Enter your username and email </h1>

</head>
<body>

    <br>
    <form action="forgottenpassword.php" method="post">
    <input type="text" name = "username" placeholder="User Name" required>
    <br>
    <input type="email" name = "email" placeholder="email" required>
    <br>
    <input type="submit" name="reset" value="send me my password" />
</form>
<br>

<?php

if (isset($_POST['reset'])){

$username =$_POST['username'];
$email=$_POST['email'];

$result= $connection->query("SELECT user_id from Users where username='$username';");

if ($result->num_rows == 0){ //case non existant user
    echo "username does not exist<br>";
    echo '<a href="chooses.html">Click here to register</a>';
}
else {
    //username exists check if username  matches a valid email
    $userid = $result->fetch_row()[0];
    //echo $userid;
    $sql = "(Select contact_email from Employee where employee_id='$userid') 
    UNION (SELECT contact_email from Employer where employer_id='$userid');";
    $result = $connection->query($sql);
    $subemail = $result->fetch_row()[0];

        if ($subemail == $email){
       // echo "an email has been sent with your password";
        //get password
        $sql="SELECT `password` from Users where user_id='$userid';";
        $result=$connection->query($sql);
        $password = $result->fetch_row()[0];
       // echo $password;

        $subject = "You password to career portal";
        $txt="Here is your forgotten login info\nusername: ".$username." password: ".$password;
        $headers="From: exc55311@encs.concordia.ca";
       // echo $headers;
       // echo $subject;
        echo $txt;
        mail($email, $subject, $txt, $headers);
        echo '<br>';
        echo '<a href="index.html">Back to homepage</a>';
    
        }
        else {
            echo "email does not match username";
        }

    }



}





?>


</body>
</html>


