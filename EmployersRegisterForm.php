<?php
require_once 'config.php';
require_once 'util.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css"
href = "myStyle.css" />
<script>
function closeWin() {
close();
}
</script>

<title>Employer Register Form</title>
</head>
<body>

<h1> Employers Register Form</h1>
<form action="RegisterEmployer.php" method="post" id="registration">  <!--  PUT RIGHT LINK!! -->
<fieldset>
<legend > Personal & Corporation Information </legend>
<div>
<p></p>
<label for="id_name">First Name:</label>
<input type="text" class="tn"id="id_name" name="fname" placeholder="First Name" autofocus required>
<label class="lable1" for="id_lname">Last Name: </label>
<input type="text"  id="id_lname" name="lname" class="tn"placeholder="Last Name" required><br>
<P></p>
<label class="lable1" for="id_cname">Corporation Name: </label>
<input type="text"  id="id_cname" name= "company" class="tc"placeholder="Corporation Name" required><br>
<p></p>
<label for="txtEmail">Email Address:</label>
<input type="email"class="te"id = "txtEmail" name="email" placeholder="email@cor.com" required/>
<p></p>
<label for="url">Website:</label>
<input type = "url"class="tw"id = "url" name= "url" placeholder="www.cor.com" pattern="https?://.+" title="Include http://" />
</div>
<div>
<label for="address">Address</label><br>
<input type="text" class="textboxAddress" name="address" placeholder="Street
Address"><br>
</fieldset>
</div>
<div>
<p></p>
<fieldset>

<legend > Profile </legend>
<p></p>
<label for="id_uname">Username:</label>
<input type="text" class="tww"id="id_uname"  placeholder="User Name" name="username" required>
<p></p>
<label for="id =pwd">Password : </label>
<input type = "password" class="tww"id = "pwd" placeholder="Enter your Password" name= "password" required/>
<p></p>
<label for="id_gategory">Category:</label>
<select class="selectOption" name="category">
<optgroup label="Select category">
<option value="Gold">Gold ($100/per month)</option>
<option value="Prime">Prime ($50/per month)</option>
</select>
</fieldset>
</div>
<p></p>
<fieldset>
<legend > Payment </legend>
<p></p>

<br>
<button onClick="addFieldsCredit()" name= "addcredit" type="button"> Add Credit Card </button> 

<div id="container" > </div> 
<script src="Scripts.js"></script>
<br>
<button onClick="addFieldsChecking()" name= "addchecking" type="button"> Add Checking Account </button>
<script src="Scripts.js"></script>
        <div id="container2" > </div> 
</fieldset>
</div>
<p></p>


<fieldset>
<div class="submit">
<input type="submit" id="id_emp" name="register"
value="submit" />
<input type = "reset" />
<button onclick="closeWin()">Cancel</button>
</fieldset>
</div>
</form>


</body>
</html>