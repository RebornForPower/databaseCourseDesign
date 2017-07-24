<?php
require_once 'checkUsers.php';
checkUsers();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Upload a file</title>
    <meta name="description" content="" />
    <meta name="author" content="templatemo">

    <link rel="shortcut icon" href="./favicon.png" />		
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/camera.css" rel="stylesheet">
    <link href="css/templatemo_style.css" rel="stylesheet">

</head>
<body>
<div id="templatemo_contact" class="container_wapper">
        <div class="container">
            <div class="row">  
                <div id="templatemo_contact_map_wapper">
                    <div id="templatemo_contact_map"><img src="images/PT.png" alt="logo" width="300PX"/></div>
                </div>
                <div class="col-xs-12 section_header">
                    <h1>Upload</h1>
                </div>
<form action="uploadfile.php" method="post" enctype="multipart/form-data">
		<div class="col-md-4">
              
                        <label for="file">Filename：</label>
  			<input type="file" name="file" id="file"><br>	
               </div>
		<div class="col-xs-12">
			<label for="post_text">File Comment:</label>
			<textarea id="post_text" name="post_text" rows="8" cols="40"
                  	required="required"style="height:300px"></textarea>

               </div>
   
 		<div class="col-md-4"></div>
                    <div class="col-md-4 col-xs-8">
                        <button type="submit" name="submit" value="submit">submit</button>
                    </div>

</form>
<br/><a href="topiclist.php">Back to topic list</a>
<br/><a href="showfile.php">Back to file list</a>
</body>
</html>
