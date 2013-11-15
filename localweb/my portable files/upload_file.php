<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
	  $checkuserid = $db->prepare("SELECT UserID, Permissions FROM users WHERE Username =?");
		$username = ($_SESSION['Username']);
		$checkuserid->execute(array($username));
		
		$results = $checkuserid->fetch(PDO::FETCH_NUM);
		$uid = $results[0];
		$permissions = $results[1];
		echo "UID\t" . $uid . "\tPermissions\t". $permissions . "<br>";
	if($permissions != 0)
	{
		echo "We're sorry, but only students can submit proposals.<br>";
		echo "<a href=\"index.php\">Click here to return to member's area.</a>." . "<br>";
	}else
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {		
      echo $_FILES["file"]["name"] . " already exists. " . "<br>";
	  echo "<a href=\"submit_file.php\">Click here to return to try again.</a>." . "<br>";
	  echo "<a href=\"index.php\">Click here to return to member's area.</a>." . "<br>";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);


      	  $path = ("upload/" . $_FILES["file"]["name"]);
	  $file = $_FILES["file"]["name"];
	  
	  $addfiletotable = $db->prepare("INSERT INTO files(Name, Path, UserID) VALUES (:file,:path,:uid);");
      $addfiletotable->execute(array(':file' => $file, ':path' => $path, ':uid' => $uid));
	  $results = $addfiletotable->fetch(PDO::FETCH_NUM);
	  
	  /*$getfileid = $db->prepare("SELECT ID from files WHERE Name = :file AND Path = :path AND UserID = :uid");
	  $addfiletotable->execute(array(':file' => $file, ':path' => $path, ':uid' => $uid));
	  $results = $addfiletotable->fetch(PDO::FETCH_ASSOC);  
	  echo $results["ID"] . "<br>";*/

	        $fileid = $db->prepare("SELECT * FROM files WHERE :name = Name");
      $fileid->execute(array(':name' => $_FILES["file"]["name"]));
      $results2 = $fileid->fetch(PDO::FETCH_ASSOC);
      $fid = $results2["ID"];
   	 echo $fid;
      $newtry = $db->prepare("INSERT INTO proposal (StudentID, FileID) VALUES (?, ?)");
      $newtry->bindParam(1, $uid);
      $newtry->bindParam(2, $fid);
      $newtry->execute();
      $hold = "SELECT * FROM files WHERE $file = Name";
      $newtry->bindParam(2, $hold);
      /*$addfiletotable = $db->prepare("INSERT INTO review(StudentID, FileProposalID) SELECT files.UserID, files.ID FROM files WHERE Path = $Path");
      $addfiletotable->execute()*/


      echo $results[0] . "<br>";

	  

      echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br>";
	  echo "<a href=\"index.php\">Click here to return to member's area.</a>." . "<br>";
	  

	  }
   	}
}else {
	echo "Unauthorized access. You must be logged in to view this page. Please <a href=\"index.php\">click here to login</a>.";
	
}
?>
</div>
</body>
</html>