<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php
echo"<h2> Users </h2>";
header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
header( 'Cache-Control: post-check=0, pre-check=0', false ); 
header( 'Pragma: no-cache' ); 
  $permissionvalues = array(0 => "Student", 1 => "Faculty", 2 => "Admin");
  $permissionints   = array("Student" => 0, "Faculty" => 1, "Admin" => 2);
  if(!empty($_POST["Update"])){
     $getusers = $db->prepare("SELECT * FROM users");
      $getusers->execute();
      while($results = $getusers->fetch(PDO::FETCH_ASSOC)){
          $uid = $results["UserID"];
          $permission = $_POST['permissions'.$uid];
          $permission = $permissionints[$permission];
          $updateuser = $db->prepare("UPDATE users SET Permissions=:pid WHERE UserID = :uid");
          $updateuser->execute(array(":pid"=>$permission,":uid"=>$uid));
      }
      echo "Update successful.</br>";
  }
  $uids = array();
  function getDropdownFor ($uid,$permission){ 
      echo "<select id='permissions$uid' name='permissions".$uid."'>";
      foreach(array("Student","Faculty","Admin") as $e){
        if($e == $permission){
          echo "<option value='$e' SELECTED>$e</option>";
        }else{
          echo "<option value='$e'>$e</option>";
        }
      }
      echo "</select>";
  } 

  ?><form method="post" action="updateusers.php" name="userform" id="userform" onsubmit="return checkForm(this); return false;">
  <fieldset><?php
  $getusers = $db->prepare("SELECT * FROM users");
      $getusers->execute();
      while($results = $getusers->fetch(PDO::FETCH_ASSOC)){
        echo "<ul><li>";
          echo "Name:           ".$results["Username"]."</br>";
          echo "E-mail:         ".$results["EmailAddress"]."</br>";
          echo "Permissions:    ";
          $permission = $results["Permissions"];
          getDropdownFor($results["UserID"],$permissionvalues[$permission]);
          //echo "</br><a href='update.php?id=".$results["UserID"]."'>update</a>";
          echo "</br>";
          echo "</ul>";
         echo "</li></ul>";
      }
      $_POST['update'] = "true";
      ?><input type="submit" name="Update" value="Update" id="Update" onclick="updatePermissions();">
      <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php';">
      </fieldset>
      </form><?php


      //echo '<input type="button" name="Update" value="Update" onclick="updatePermissions();">';
      
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
