<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div class="register-form">
<form action="upload.php" method="post" enctype="multipart/form-data">
<h1> Select farm: </h1><br/><br/>
<input type=text name="farmName"/><br/>
   <h1> Select file to upload: </h1><br/><br/>
    <input type="file" name="fileToUpload"  id="fileToUpload"  accept=".csv,.xls,.txt" pattern=".{6,}"> 
    <input type="submit" value="Upload file" name="submit"><br/><br/>
   </div>
</form>
</body>
</html>