<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<link rel="stylesheet" href="style.css" type="text/css" />
<script type="text/javascript">
var file_selected = false;

function checkForm(f)
{
    if (file_selected == false)
    {
        alert("Please select a file.");
        return false;
    }
    else
    {
        f.submit();
        return false;
    }
}

</script>  
</head>
<body>
<div id="main">
<form method="post" action="upload_file.php"
enctype="multipart/form-data" onsubmit="return checkForm(this); return false;">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" onchange="file_selected = true;"><br>
<input type="submit" name="submit" value="Submit" onclick="showNoFile();">
<input type="button" name="cancel" value="Cancel" onclick="location.href='index.php';">
</form>
</div>
</body>
</html>