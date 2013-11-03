<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php
  $getusers = $db->prepare("SELECT * FROM users");
       echo"<h2> Users </h2>";
      $getusers->execute();
      $permissionvalues = array(0 => "Student", 1 => "Faculty", 2 => "Admin");
      while($results = $getusers->fetch(PDO::FETCH_ASSOC)){
        echo "<ul><li>";
          echo "Name:           ".$results["Username"]."</br>";
          echo "E-mail:         ".$results["EmailAddress"]."</br>";
          echo "Permissions:    ";
          $permission = $results["Permissions"];
          echo $permissionvalues[$permission];
          echo "</br>";
          echo "</ul>";
         echo "</li></ul>";
      }
      
     /* $getusers = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID > 0");
      $getusers->execute();
            while($results = $getusers->fetch(PDO::FETCH_ASSOC)){
              echo "<ul><li>";
              echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
      echo "</li></ul>";
      }
      echo"<h2> Here are the assigned files awaiting review.</h2>";
      $getusers = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID = 0");
      $getusers->execute();
            while($results = $getusers->fetch(PDO::FETCH_ASSOC)){
              echo "<ul><li>";
              echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
      echo "</li></ul>";
      }*/
?>
</div>
</body>
</html>
