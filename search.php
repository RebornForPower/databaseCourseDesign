<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17-6-13
 * Time: 下午5:17
 */
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();
if(isset($_GET['search']))
{
    $search=mysqli_real_escape_string($mysqli,$_GET['search']);
    $sql="SELECT * FROM uploadFile WHERE fileName LIKE "."'"."%".$search."%"."'"." OR"." fileComment LIKE "."'"."%".$search."%"."'"." ORDER BY upload_time DESC";
    $file_res=mysqli_query($mysqli,$sql) OR die(mysqli_error($mysqli));
    if(mysqli_num_rows($file_res)<1)
    {
        $display_block = "<p><em>No such files.</em></p>";
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
}
else
{
    header("Location:showfile.php");
}
?>
<!DOCTYPE html>
<html>
<head>

 <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="" />
    <meta name="author" content="templatemo">

    <link rel="shortcut icon" href="./favicon.png" />		
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/camera.css" rel="stylesheet">
    <link href="css/templatemo_style.css" rel="stylesheet">

 <title>Search Files in My Forum</title>

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
		vertical-align: top;
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
                    <div id="templatemo_contact_map">
			<img src="images/PT.png" alt="logo" width="300PX"/>
			</div>
                </div>
                <div class="col-xs-12 section_header">
                   <h1>Search</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                   <p>These are all the results.</p>
                </div>



		<p><a href="topiclist.php">back to topic list</a></p>
		
		<?php echo $display_block; ?>
		
		</div>
	</div>
</div>
</body>
</html>

