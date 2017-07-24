<?php
/**
 * Created by PhpStorm.
 * User: KaiGod
 * Date: 17-6-11
 * Time: 下午5:08
 */
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();
session_start();
$username=$_SESSION['username'];
$sql="SELECT Point FROM outerusers WHERE username = "."'".$username."'";
$point_res=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$point_info=mysqli_fetch_array($point_res);
$point=$point_info['Point'];
$sql="SELECT * FROM uploadFile ORDER BY upload_time	 DESC";
$file_res=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));//get all the file information
if(mysqli_num_rows($file_res)<1)
{
    $display_block = "<p><em>No files exist.</em></p>";
}
else
{
    //create the display string
    $display_block = <<<END_OF_TEXT
    <table style="border: 1px solid black; border-collapse: collapse;">
    <tr>
    <th>FILE NAME</th>
    <th>File Description</th>
    </tr>
END_OF_TEXT;
    while($file_info=mysqli_fetch_array($file_res))
    {
        $file_id=$file_info['id'];
        $file_username=$file_info['username'];
        $file_name=$file_info['fileName'];
        $file_type=$file_info['fileType'];
        $file_size=$file_info['fileSize'];
        $file_comment=$file_info['fileComment'];
        $upload_time=$file_info['upload_time'];
        $display_block .= <<<END_OF_TEXT
		<tr>
		<td><a href="downloadfile.php?id=$file_id" target='blank'><strong>$file_name</strong></a><br/>
		Created on $upload_time by <b><em>$file_username</em></b><br>Size:$file_size B <br> Type:$file_type</td>
		<td class="num_posts_col">$file_comment</td>
		</tr>
END_OF_TEXT;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <meta name="description" content="" />
    <meta name="author" content="templatemo">

    <link rel="shortcut icon" href="./favicon.png" />		
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/camera.css" rel="stylesheet">
    <link href="css/templatemo_style.css" rel="stylesheet">


<title>Files in My Forum</title>
<style type="text/css">
	table {
		border: 2px solid black;
		border-collapse: collapse;
	}
	th {
		border: 2px solid black;
		padding: 8px;
		font-weight: bold;
		background: #b3e9ff;
	}
	td {
		border: 2px solid black;
		padding: 8px;
		height:300px;
		width:100%;
	}
	.num_posts_col { text-align: center; }
</style>
</head>
<body>
<div id="templatemo_contact" class="container_wapper">
        <div class="container">
            <div class="row">  
                <div id="templatemo_contact_map_wapper">
                    <div id="templatemo_contact_map"><img src="images/PT.png" alt="logo" width="300PX"/></div>
                </div>
                <div class="col-xs-12 section_header">
                   <h1>Files</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                   <p>Welcome, <?php echo $_SESSION['username'];?></p>
                </div>



		<p><a href="loginout.php"><em>click here</em></a> to login out!</p>
		<p>Would you like to <a href="addtopic.php">add a topic</a>     or <a href="uploadfileform.php">upload a file</a>?</p>
		<p>You can also see all the <a href="topiclist.php">topics here.</a></p>
<p>Now Your point is <?php echo $point;?></p>
		<form method="get" action="search.php">
		    <input type="text" name="search" placeholder="Search here..." required>
		    <button type="submit"style="width:150px;height:80px">Search</button>
		</form>
		</div>
		<div class="col-md-12" >
		<?php echo $display_block; ?>
		</div>
	    </div>
	</div>
</div>
</body>
</html>


