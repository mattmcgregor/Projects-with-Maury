<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php
  header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
  header( 'Cache-Control: post-check=0, pre-check=0', false ); 
  header( 'Pragma: no-cache' ); 

  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
  {
    $checkuserid = $db->prepare("SELECT UserID, Permissions FROM users WHERE Username =?");
    $username = ($_SESSION['Username']);
    $checkuserid->execute(array($username));
    
    $results = $checkuserid->fetch(PDO::FETCH_NUM);
    $uid = $results[0];
    $permissions = $results[1];
    if($permissions != 2)
    {
      echo "We're sorry, but you do not have permission to access this page.<br>";
      echo "<a href=\"index.php\">Click here to return to member's area.</a>" . "<br>";
    }
    else
    {

      if(isset($_GET["fileid"]) && isset($_GET["studentid"])){
        $fileid = $_GET["fileid"];
        $studentid = $_GET["studentid"];

        $getproposals = $db->prepare("SELECT * FROM proposal WHERE FileID = :fid AND StudentID = :sid");
        $getproposals->execute(array(":fid" => $fileid, ":sid" => $studentid));
        $results = $getproposals->fetch(PDO::FETCH_ASSOC);
        $getrespectivefile = $db->prepare("SELECT * FROM files WHERE ID = :fid");
        $getrespectivefile->execute(array(":fid"=>$results["FileID"]));
        $rowInFileTable = $getrespectivefile->fetch(PDO::FETCH_ASSOC);
        $getstudentwhosubmitted = $db->prepare("SELECT * FROM users WHERE UserID = :uid");
        $getstudentwhosubmitted->execute(array(":uid"=>$rowInFileTable["UserID"]));
        $rowInStudentTable = $getstudentwhosubmitted->fetch(PDO::FETCH_ASSOC);
        $getreviewers = $db->prepare("SELECT * FROM review WHERE FileProposalID = :fid AND StudentID = :uid");
        $getreviewers->execute(array(":fid"=>$results["FileID"], ":uid"=>$rowInFileTable["UserID"]));
          echo "<ul><li>";
            echo "Proposal:\t"."<a href=download.php?id=".$results["FileID"].">".$rowInFileTable["Name"]."</a><br>";
            echo "Submitted By:\t".$rowInStudentTable["firstName"]." ".$rowInStudentTable["lastName"]."<br>";
            echo "Status:\t".$propStatus[$results["Status"]]."</br>";
            echo "Reviewers: <ul>";
            while($rowInReviewTable = $getreviewers->fetch(PDO::FETCH_ASSOC)) {
              $getReviewerAsUser = $db->prepare("SELECT * FROM users WHERE UserID = :uid");
              $getReviewerAsUser->execute(array(":uid"=>$rowInReviewTable["ReviewerID"]));
              $reviewerAsUser = $getReviewerAsUser->fetch(PDO::FETCH_ASSOC);
              echo "<li>".$reviewerAsUser["firstName"]." ".$reviewerAsUser["lastName"]."</br></li>";
        }
            echo "</ul>";
        ?>
        </br>
        <form method="post" action="reject.php" name="rejectform" id="rejectform" onsubmit="return checkForm(this); return false;">
        <fieldset>
        <textarea rows="4" cols="50">Insert comment here.</textarea></br>
        <input type="submit" name="Submit" value="Submit" id="Submit" onclick="">
        <input type="button" name="cancel" value="Cancel" onclick="location.href='viewproposals.php';"></fieldset></form><?php
      }
      else 
      {
        echo "Error, could not determine selected proposal. Try clicking Reject on the <a href=\"viewproposals.php\">View Proposals</a> page.</br>"; 
      }
    } 
  }
  else 
  {
    echo "Unauthorized access. You must be logged in to view this page. Please <a href=\"index.php\">click here to login</a>.";

  }
?>