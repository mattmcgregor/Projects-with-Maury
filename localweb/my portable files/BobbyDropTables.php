<!-- 
basically stolen from http://net.tutsplus.com/tutorials/php/user-membership-with-php/
credits to Tom Cameron for a great tutorial
-->
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
	$scrub = $db->prepare("DELETE FROM judgement WHERE 1");
	$scrub->execute();
	$scrub = $db->prepare("DELETE FROM proposal WHERE 1");
	$scrub->execute();
	$scrub = $db->prepare("DELETE FROM review WHERE 1");
	$scrub->execute();
	$scrub = $db->prepare("DELETE FROM users WHERE 1");
	$scrub->execute();
	$scrub = $db->prepare("DELETE FROM files WHERE 1");
	$scrub->execute();

?>
<h2>OH NO! BOBBY DROPPED THE TABLES!</h2>
</div>
</body>
</html>