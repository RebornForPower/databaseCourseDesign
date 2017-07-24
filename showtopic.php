<?php
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();

//check for required info from the query string
if (!isset($_GET['topic_id'])) {
	header("Location: topiclist.php");
	exit;
}

//create safe values for use
$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);

//verify the topic exists
$verify_topic_sql = "SELECT topic_title FROM forum_topics WHERE topic_id = '".$safe_topic_id."'";
$verify_topic_res =  mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_topic_res) < 1) {
	//this topic does not exist
	$display_block = "<p><em>You have selected an invalid topic.<br/>
	Please <a href=\"topiclist.php\">try again</a>.</em></p>";
} else {
	//get the topic title
	while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
		$topic_title = stripslashes($topic_info['topic_title']);
	}

	//gather the posts
	$get_posts_sql = "SELECT post_id, post_text, DATE_FORMAT(post_create_time, '%b %e %Y<br/>%r') AS fmt_post_create_time, post_owner,username FROM forum_posts WHERE topic_id = '".$safe_topic_id."' ORDER BY post_create_time ASC";
	$get_posts_res = mysqli_query($mysqli, $get_posts_sql) or die(mysqli_error($mysqli));

	//create the display string
	$display_block = <<<END_OF_TEXT
	<p>Showing posts for the <strong>$topic_title</strong> topic:</p>
	<table>
	<tr>
	<th>AUTHOR</th>
	<th>POST</th>
	</tr>
END_OF_TEXT;

	while ($posts_info = mysqli_fetch_array($get_posts_res)) {
		$post_id = $posts_info['post_id'];
		$post_text = nl2br(stripslashes($posts_info['post_text']));
		$post_create_time = $posts_info['fmt_post_create_time'];
		$post_owner = stripslashes($posts_info['post_owner']);
		$post_user = $posts_info['username'];

		//add to display
	 	$display_block .= <<<END_OF_TEXT
		<tr>
		<td>$post_user created on:<br/>$post_create_time<br>Email:$post_owner</td>
		<td>$post_text<br/><br/>
		<a href="replytopost.php?post_id=$post_id"><strong>REPLY TO THIS USER</strong></a></td>
		</tr>
END_OF_TEXT;
	}

	//free results
	mysqli_free_result($get_posts_res);
	mysqli_free_result($verify_topic_res);

	//close connection to MySQL
	mysqli_close($mysqli);

	//close up the table
	$display_block .= "</table>";
}
?>
<?php
$display_block2=<<<END_OF_TEXT
<p><a href="replytothewholepost.php?post_id=$post_id">Reply To Topic</a></p>
END_OF_TEXT;
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


<title>Posts in Topic</title>
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
                   <h1>Posts</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                   
                </div>



		<p><a href="topiclist.php">back to topic list</a></p>
		
		<?php echo $display_block2; ?>
		<?php echo $display_block; ?>
		
		</div>
	</div>
</div>
</body>
</html>
