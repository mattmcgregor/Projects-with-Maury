<a href="index.php">The Way Home</a>
<p>Lost your password? Lets see if we can't get it reset.</p>
<?php include "base.php"; ?>
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

<?php 
if(empty($_POST["firstName"])){
	?><form method="post" action="reset_password.php" name="loginform" id="loginform">
		<fieldset>
			<label for="username">First Name:</label><input type="firstName" name="firstName" id="firstName" /><br />
			<label for="password">Last Name:</label><input type="lastName" name="lastName" id="lastName" /><br />
			<label for="StudentID">Student ID:</label><input type="StudentID" name="StudentID" id="StudentID" /><br />
			<input type="submit" name="login" id="login" value="Login" />
		</fieldset>
	</form>
	<?php
}
else if((empty($_POST["newPassword"]))&&(!empty($_POST["firstName"])) && (!empty($_POST["lastName"])) && (!empty($_POST["StudentID"])))
{
		
		$hold = $db->prepare("SELECT * FROM users WHERE :studentID = studentID AND :lastName = lastName AND :firstName = firstName");
		$hold->execute(array(':studentID' => $_POST["StudentID"], ':lastName' => $_POST["lastName"], ':firstName' => $_POST["firstName"]));
		$hold = $hold->fetch(PDO::FETCH_ASSOC);
		if(!empty($hold["Password"])){
			?>
				<form method="post" action="reset_password.php" name="form" id="form">
					<fieldset>
						<input type="hidden" name="firstName" id="firstName" value=<?php echo $_POST["firstName"]?>>
						<input type="hidden" name="lastName" id="lastName" value=<?php echo $_POST["lastName"]?>>
						<input type="hidden" name="StudentID" id="StudentID" value=<?php echo $_POST["StudentID"]?>>
						<label for="NewPassword">New Password:</label><input type="password" name="newPassword" id="newPassword" /><br />
						<input type="submit" name="login" id="login" value="Login" />
					</fieldset>
				</form>
			<?php
		}
		else{

			Echo "I'm sorry, we don't have any users with that name and student ID";
			Echo "<br>"."<a href=index.php>The Way Home</a>"."<br>"."<a href=reset_password.php>Try Again</a>";
		}
		
}
else{
	$newPassword = md5(($_POST["newPassword"]));

	$newtry = $db->prepare("UPDATE `users` SET `Password`= :pass WHERE StudentID = :sid AND firstName = :fname AND lastName = :lname");
	$newtry ->execute(array(':sid' => $_POST["StudentID"], ':pass' => $newPassword, ':fname' => $_POST["firstName"], ':lname' => $_POST["lastName"]));

	Echo "Password Reset<br><br><br>"."<a href=index.php>Login</a>";
}
?>