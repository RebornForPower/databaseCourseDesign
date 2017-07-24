<?php
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();

//start session
session_start();
//gather the topics
//$get_topics_sql = "SELECT topic_id, topic_title, DATE_FORMAT(topic_create_time,  '%b %e %Y at %r') as fmt_topic_create_time, topic_owner FROM forum_topics ORDER BY topic_create_time DESC";
$get_topics_sql = "SELECT topic_id, topic_title, DATE_FORMAT(topic_create_time,  '%b %e %Y at %r') as fmt_topic_create_time, topic_owner,username FROM forum_topics ORDER BY topic_create_time DESC";
$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_topics_res) < 1) {
	//there are no topics, so say so
	$display_block = "<p><em>No topics exist.</em></p>";
} else {
	//create the display string
    $display_block = <<<END_OF_TEXT
    <table style="border: 1px solid black; border-collapse: collapse;">
    <tr>
    <th>TOPIC TITLE</th>
    <th># of POSTS</th>
    </tr>
END_OF_TEXT;

	while ($topic_info = mysqli_fetch_array($get_topics_res)) {
		$topic_id = $topic_info['topic_id'];
		$topic_title = stripslashes($topic_info['topic_title']);
		$topic_create_time = $topic_info['fmt_topic_create_time'];
		$topic_owner = stripslashes($topic_info['topic_owner']);
		$topic_user= $topic_info['username'];

		//get number of posts
		$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM forum_posts WHERE topic_id = '".$topic_id."'";
		$get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

		while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
			$num_posts = $posts_info['post_count'];
		}

		//add to display
		$display_block .= <<<END_OF_TEXT
		<tr>
		<td><a href="showtopic.php?topic_id=$topic_id"><strong>$topic_title</strong></a><br/>
		Created on $topic_create_time by <b><em>$topic_user</em></b><br>Email:$topic_owner</td>
		<td class="num_posts_col">$num_posts</td>
		</tr>
END_OF_TEXT;
	}
	//free results
	mysqli_free_result($get_topics_res);
	mysqli_free_result($get_num_posts_res);

	//close connection to MySQL
	mysqli_close($mysqli);

	//close up the table
	$display_block .= "</table>";
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
	


<title>Topics in My Forum</title>
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
<div class="index-tab">
        <div class="container">
            <div class="row">  
                <div id="templatemo_contact_map_wapper">
                    <div id="templatemo_contact_map"><img src="images/PT.png" alt="logo" width="300PX"/></div>
                </div>
                <div class="col-xs-12 section_header">
                   <h1>Topics</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                   <p>Welcome, <?php echo $_SESSION['username'];?></p>
                </div>



		<p><a href="loginout.php"><em>click here</em></a> to login out!</p>
		<p>Would you like to <a href="addtopic.php">add a topic</a>     or <a href="uploadfileform.php">upload a file</a>?</p>
		<p>You can also see all the <a href="showfile.php">uploaded files.</a></p>
		
		<?php echo $display_block; ?>
		
		</div>
	</div>
</div>
</div>
</body>
</html>
