<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<form method="post" action="updatereviewers.php" name="userform" id="userform" onsubmit="return checkForm(this); return false;">
  <fieldset>
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
  }else{

  echo "<h2> Modify Proposal Reviewers </h2>";

  $reviewers = array();
  $getReviewers = $db->prepare("SELECT * FROM users WHERE permissions = :p");
  $getReviewers->execute(array(":p" => "1"));
  while($result = $getReviewers->fetch(PDO::FETCH_ASSOC)){
    $reviewers[] = $result;
    //echo $result["UserID"]." ".$result["firstName"]." ".$result["lastName"]."</br>";
  }

  if(!empty($_POST["Update"])){
    $getProposals = $db->prepare("SELECT * FROM proposal");
    $getProposals->execute();
    while($results = $getProposals->fetch(PDO::FETCH_ASSOC)){

        $i = 1;
        $submittedReviewers = array();
        $studentID = $results["StudentID"];
        $proposalFileID = $results["FileID"];

        while($i < 4){
          $dropdownName = "sid".$studentID."fid".$proposalFileID."rindex".$i;
          $ruid = $_POST[$dropdownName];
          //echo $dropdownName." ".$ruid."</br>";
          if($ruid != "NONE")
            $submittedReviewers[] = $ruid;
          $i++;
        }

        $getCurrentsubmittedReviewers = $db->prepare("SELECT * FROM review WHERE StudentID = :uid AND FileProposalID = :fid;");
        $getCurrentsubmittedReviewers->execute(array(":uid" => $studentID, ":fid" => $proposalFileID));
        while($result = $getCurrentsubmittedReviewers->fetch(PDO::FETCH_ASSOC)){
          $cruid = $result["ReviewerID"];
          if(!in_array($cruid, $submittedReviewers)){
            $removeOldReviewer = $db->prepare("DELETE FROM review WHERE StudentID = :uid AND FileProposalID = :fid AND ReviewerID = :ruid");
            $removeOldReviewer->execute(array(":uid" => $studentID, ":fid" => $proposalFileID, "ruid" => $cruid));
          }
        }


        foreach($submittedReviewers as $e){
          $seeIfReviewerExists = $db->prepare("SELECT * FROM review WHERE StudentID = :uid AND FileProposalID = :fid AND ReviewerID = :ruid");
          $seeIfReviewerExists->execute(array(":uid" => $studentID, ":fid" => $proposalFileID, "ruid" => $e));
          $existsResult = $seeIfReviewerExists->fetch(PDO::FETCH_ASSOC);
          if(!$existsResult){
            $insertNewReviewer = $db->prepare("INSERT INTO review (StudentID, FileProposalID, ReviewerID) VALUES (:uid, :fid, :ruid)");
            $insertNewReviewer->execute(array(":uid" => $studentID, ":fid" => $proposalFileID, "ruid" => $e));
          }
        }
    }
    echo "Update successful.</br>";
  }

  function getDropdownFor ($row, $revArray, $name){
    //echo $name;
    echo "<select id='".$name."' name='".$name."'>";
    if(is_null($row["ReviewerID"]))
      echo "<option value='NONE' SELECTED>NONE</option>";
    else
      echo "<option value='NONE'>NONE</option>";
    foreach($revArray as $e){
        if($row["ReviewerID"] == $e["UserID"])
          echo "<option value='".$e["UserID"]."' SELECTED>".$e["firstName"]." ".$e["lastName"]."</option>";
        else
          echo "<option value='".$e["UserID"]."'>".$e["firstName"]." ".$e["lastName"]."</option>";
          
    }
    echo "</select>";
  }

  $getproposals = $db->prepare("SELECT * FROM proposal");
  $getproposals->execute();
    while($results = $getproposals->fetch(PDO::FETCH_ASSOC)){
          $proposalFileID = $results["FileID"];
          $studentID = $results["StudentID"];

          $rowInStudentTable = $db->prepare("SELECT firstName, lastName FROM users WHERE UserID = :uid");
          $rowInStudentTable->execute(array(":uid" => $studentID));
          $rowInStudentTable = $rowInStudentTable->fetch(PDO::FETCH_ASSOC);

          $rowInFileTable = $db->prepare("SELECT * FROM files WHERE ID = :fid");
          $rowInFileTable->execute(array(":fid" => $proposalFileID));
          $rowInFileTable = $rowInFileTable->fetch(PDO::FETCH_ASSOC);

          $getreviewers = $db->prepare("SELECT * FROM review WHERE FileProposalID = :fid AND StudentID = :uid");
          $getreviewers->execute(array(":fid" => $proposalFileID, ":uid" => $studentID));
            echo "<ul><li>";
              echo "Proposal:\t"."<a href=download.php?id=".$proposalFileID.">".$rowInFileTable["Name"]."</a><br>";
              echo "Submitted By:\t".$rowInStudentTable["firstName"]." ".$rowInStudentTable["lastName"]."<br>";
              echo "Reviewers: <ul>";
              $i = 1;
              while($rowInReviewTable = $getreviewers->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>";
                if($i > 3)
                  echo "THIS REVIEWER EXCEEDS THE THREE REVIEWER RULE AND SHOULD NOT EXIST";
                $dropdownName = "sid".$studentID."fid".$proposalFileID."rindex".$i;
                getDropdownFor($rowInReviewTable, $reviewers, $dropdownName);
                echo "</br></li>";
                $i++;
              }
              while($i<4){
                echo "<li>";
                $dropdownName = "sid".$studentID."fid".$proposalFileID."rindex".$i;
                getDropdownFor(array(),$reviewers,$dropdownName);
                echo "</br></li>";
                $i++;
              }
              echo "</ul>";
              echo "</ul>";

/*                $getReviewerAsUser = $db->prepare("SELECT * FROM users WHERE UserID = :uid");
                $getReviewerAsUser->execute(array(":uid"=>$rowInReviewTable["ReviewerID"]));
                $reviewerAsUser = $getReviewerAsUser->fetch(PDO::FETCH_ASSOC);
                echo "<li>".$reviewerAsUser["firstName"]." ".$reviewerAsUser["lastName"]."</br></li>";*/
          }
              echo "</ul>";
            echo "</li></ul>";
          

/*


  
  
  */    
$_POST['update'] = "true";

      ?><input type="submit" name="Update" value="Update" id="Update" onclick="updatePermissions();">
      <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php';">
      </fieldset>
      </form> <?php
    } }else {
  echo "Unauthorized access. You must be logged in to view this page. Please <a href=\"index.php\">click here to login</a>.";
  
}?>
</div>
</body>
</html>