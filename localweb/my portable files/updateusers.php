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
  $resultname = ($_SESSION['Username']);
  $checkuserid->execute(array($resultname));
  
  $results = $checkuserid->fetch(PDO::FETCH_NUM);
  $uid = $results[0];
  $permissions = $results[1];
  //echo "UID\t" . $uid . "\tPermissions\t". $permissions . "<br>";
  if($permissions != 2)
  {
    echo "We're sorry, but you do not have permission to access this page.<br>";
    echo "<a href=\"index.php\">Click here to return to member's area.</a>" . "<br>";
  }else
  {
    echo"</br><h2> Users </h2></br>";
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

    ?><form method="post" action="updateusers.php" name="userform" id="userform" onsubmit="return checkForm(this); return false;">
    <fieldset>
    <script type="text/javascript" src="jquery-latest.js"></script> 
    <script type="text/javascript" src="jquery.tablesorter.js"></script>
    <table id="myTable" class="tablesorter" style = "width: 800px"> 
    <thead> 
    <tr> 
        <th>Last Name    </th> 
        <th>First Name   </th> 
        <th>Email        </th> 
        <th>University ID</th> 
        <th>Permissions  </th>
    </tr>
    </thead>
    <tbody>
    <?php
    $getusers = $db->prepare("SELECT * FROM users");
    $getusers->execute();

      while($results = $getusers->fetch(PDO::FETCH_ASSOC))
      {
        $permission = $results["Permissions"];
        $permissionvalue = $permissionvalues[$permission];
        $uid = $results["UserID"];
        echo'
        <tr>
          <td>'.$results["lastName"].'</td>
          <td>'.$results["firstName"].'</td>
          <td>'.$results["EmailAddress"].'</td>
          <td>'.$results["studentID"].'</td>
          <td>';
          echo "<select id='permissions$uid' name='permissions".$uid."'>";
            foreach(array("Student","Faculty","Admin") as $e){
              if($e == $permissionvalue){
                echo "<option value='$e' SELECTED>$e</option>";
              }else{
                echo "<option value='$e'>$e</option>";
              }
            }
          echo "</select></td>";
        echo '</tr>';
          
      }
      echo "</tbody>";
      $_POST['update'] = "true";
      ?>
      <input type="submit" name="Update" value="Update" id="Update" onclick="updatePermissions();">
      <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php';">
      </fieldset>
      </form>
            <script type="text/javascript">
      $(document).ready(function() 
          { 
              $("#myTable").tablesorter(); 
          } 
      );
      </script> 
      <?php
    }
  }
  else 
  {
  echo "Unauthorized access. You must be logged in to view this page. Please <a href=\"index.php\">click here to login</a>.";
  }
?>
</div>
</body>
</html>
