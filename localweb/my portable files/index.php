<!-- basically stolen from http://net.tutsplus.com/tutorials/php/user-membership-with-php/
credits to Tom Cameron for a great tutorial-->
<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>OURS Grant Management System</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
	?><h1>Member Area</h1>
  	 <p>Thanks for logging in! You are <b><?=$_SESSION['Username']?><b> and your email address is <b><?=$_SESSION['EmailAddress']?></b>.</p><br />
    <?php
	$checkuserid = $db->prepare("SELECT UserID, Permissions FROM users WHERE Username =?");
		$username = ($_SESSION['Username']);
		$checkuserid->execute(array($username));

		$results = $checkuserid->fetch(PDO::FETCH_NUM);
		$uid = $results[0];
		$permissions = $results[1];

		if($permissions == 0) {
		 ?>

    <ul>
        <li><a href="submit_file.html">Submit proposal.</a></li>
    </ul>
    <?php
			echo "<h2>Your proposals</h2>";
			$getassociatedfiles = $db->prepare("SELECT * FROM files WHERE UserID=?");
			$getassociatedfiles->execute(array($uid));
			while($results = $getassociatedfiles->fetch(PDO::FETCH_ASSOC)){
			echo "<ul><li>";
				echo "Name:\t".$results["Name"]."<br>";
				echo "File:\t"."<a href=download.php?id=".$results["ID"].">Download</a>"."<br>";
				echo "Submitted:\t".$results["Uploaded"]."<br>";

			echo "</li></ul>";
			}
		}elseif($permissions == 1) {
				echo "<h2>Your proposals to review</h2>";
			$getassociatedfiles = $db->prepare("SELECT * FROM review WHERE ReviewerID=?");
			$getassociatedfiles->execute(array($uid));
			while($results = $getassociatedfiles->fetch(PDO::FETCH_ASSOC)){
			echo "<ul><li>";
				echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
			echo "</li></ul>";
			}
		}elseif($permissions == 2) {
				echo "<h2>OH GOD ITS THE USER.  Here are the unassigned files.</h2>";
			$getassociatedfiles = $db->prepare("SELECT * FROM review WHERE ReviewerID=0");
			$getassociatedfiles->execute();
			while($results = $getassociatedfiles->fetch(PDO::FETCH_ASSOC)){
					echo "<ul><li>";
						echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
			echo "</li></ul>";}
			echo"<h2> Submissions requiring approval </h2>";
			$getassociatedfiles = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID > 0");
			$getassociatedfiles->execute();
						while($results = $getassociatedfiles->fetch(PDO::FETCH_ASSOC)){
							echo "<ul><li>";
							echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
			echo "</li></ul>";
			}
			echo"<h2> Here are the assigned files awaiting review.</h2>";
			$getassociatedfiles = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID = 0");
			$getassociatedfiles->execute();
						while($results = $getassociatedfiles->fetch(PDO::FETCH_ASSOC)){
							echo "<ul><li>";
							echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
			echo "</li></ul>";
			}
		}
		?>
       <br />
    <ul>
        <li><a href="logout.php">Logout.</a></li>
    </ul><?php
}
elseif(!empty($_POST['username']) && !empty($_POST['password']))
{
	 $username = ($_POST['username']);
    $password = md5(($_POST['password']));

	 $checklogin = $db->prepare("SELECT * FROM users WHERE Username =? AND Password =?");
    $checklogin->execute(array($username,$password));
    if($checklogin->rowCount() == 1)
    {
    	 $row = $checklogin->fetch(PDO::FETCH_ASSOC);
        $email = $row['EmailAddress'];

        $_SESSION['Username'] = $username;
        $_SESSION['EmailAddress'] = $email;
        $_SESSION['LoggedIn'] = 1;

    	 echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='=2;index.php' />";

        header('Refresh: 3; URL=index.php');
    }
    else
    {
    	 echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
    }
}
else
{
	?>

   <h1>Member Login</h1>

   <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>

	<form method="post" action="index.php" name="loginform" id="loginform">
	<fieldset>
		<label for="username">Username:</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="login" id="login" value="Login" />
	</fieldset>
	</form>

   <?php
}
?>
</div>
</body>
</html>