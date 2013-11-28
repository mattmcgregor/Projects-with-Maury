<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Management System (Tom Cameron for NetTuts)</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript">
var results = true;

function checkForm(f)
{
    checkEmailAndPassword();
    if(results){
        f.submit();
    }else{
        results = true;
    }
    return false;
}

function checkEmailAndPassword() {
    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(email.value)) {
        alert('Please provide a valid email address');
        email.focus();
        results = false;
    }

    var password = document.getElementById('password');
    filter = /^.{6,}$/;

    if (!filter.test(password.value)) {
        alert('Please provide a password at least 6 characters in length.');
        password.focus();
        results = false;
    }
}
</script>
</head>
<body>
<div id="main">
<?php
if(!empty($_POST['email']) && !empty($_POST['password']))
{
	$username = ($_POST['email']);
    $password = md5(($_POST['password']));
    $email = ($_POST['email']);
    $firstName = ($_POST['firstName']);
    $lastName = ($_POST['lastName']);
    $studentID = ($_POST['studentID']);

	 $checkusername = $db->prepare("SELECT * FROM users WHERE Username =?");
     $checkusername->execute(array($username));

     if($checkusername->rowCount() > 0)
     {
     	echo "<h1>Error</h1>";
        echo "<p>Sorry, that username is taken. Please <a href='register.php'>click here</a> and try again.</p>";
     }
     else
     {
     	$registerquery = $db->prepare("INSERT INTO users (Username, Password, EmailAddress, firstName, lastName, studentID) VALUES(:user,:pass,:email,:firstName,:lastName,:studentID)");
        $registerquery->execute(array(':user' => $username, ':pass' => $password, ':email' => $email, ':lastName' => $lastName, ':firstName' => $firstName, ':studentID' => $studentID));
        if($registerquery->rowCount() == 1)
        {
        	echo "<h1>Success</h1>";
        	echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
            echo "<p>We are now redirecting you to the member area.</p>";
        }
        else
        {
     		echo "<h1>Error</h1>";
        	echo "<p>Sorry, your registration failed. Please go back and try again.</p>";
        }
     }
}
else
{
	?>

   <h1>Register</h1>

   <p>Please enter your details below to register.</p>

	<form method="post" action="register.php" name="registerform" id="registerform" onsubmit="return checkForm(this); return false;">
	<fieldset>
		<label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <label for="firstName">First Name:</label><input type="text" name="firstName" id="firstName" /><br />
        <label for="lastName">Last Name:</label><input type="text" name="lastName" id="lastName" /><br />
        <label for="studentID">studentID:</label><input type="text" name="studentID" id="studentID" placeholder="Not Required" /><br />
        <input type="submit" name="register" id="register" value="Register" />
        <input type="button" name="cancel" id="cancel" value="Cancel" onclick="location.href='index.php';"/>

	</fieldset>
	</form>

   <?php
}
?>
</div>
</body>
</html>