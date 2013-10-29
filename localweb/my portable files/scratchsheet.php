<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="main">
<?php
  $getproposals = $db->prepare("SELECT * FROM proposal");
       echo"<h2> Proposals </h2>";
      $getproposals->execute();
      while($results = $getproposals->fetch(PDO::FETCH_ASSOC)){
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
            echo "Submitted By:\t".$rowInStudentTable["Username"]."<br>";
            echo "Reviewers: <ul>";
            while($rowInReviewTable = $getreviewers->fetch(PDO::FETCH_ASSOC)) {
              $getReviewerAsUser = $db->prepare("SELECT * FROM users WHERE UserID = :uid");
              $getReviewerAsUser->execute(array(":uid"=>$rowInReviewTable["ReviewerID"]));
              $reviewerAsUser = $getReviewerAsUser->fetch(PDO::FETCH_ASSOC);
              echo "<li>".$reviewerAsUser["Username"]."</br></li>";
            }
            echo "</ul>";
           echo "</li></ul>";}
      echo"<h2> Proposals </h2>";
     /* $getproposals = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID > 0");
      $getproposals->execute();
            while($results = $getproposals->fetch(PDO::FETCH_ASSOC)){
              echo "<ul><li>";
              echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
      echo "</li></ul>";
      }
      echo"<h2> Here are the assigned files awaiting review.</h2>";
      $getproposals = $db->prepare("SELECT * FROM review WHERE ReviewerID > 0 AND FileReviewID = 0");
      $getproposals->execute();
            while($results = $getproposals->fetch(PDO::FETCH_ASSOC)){
              echo "<ul><li>";
              echo "File:\t"."<a href=download.php?id=".$results["FileProposalID"].">Download</a>"."<br>";
      echo "</li></ul>";
      }*/
?>
</div>
</body>
</html>
