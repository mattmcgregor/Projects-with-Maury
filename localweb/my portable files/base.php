<?php
session_start();

$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "user"; // the name of the database that you are going to use for this project
$dbuser = "root"; // the username that you created, or were given, to access your database
$dbpass = ""; // the password that you created, or were given, to access your database
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8', $dbuser, $dbpass);

$propStatus = array();
$propQuerry = $db->prepare("SELECT * FROM propStatus");
$propQuerry->execute();
while($result = $propQuerry->fetch(PDO::FETCH_ASSOC)){
	$propStatus[$result["ID"]] = $result["StatusText"];
}
?>
