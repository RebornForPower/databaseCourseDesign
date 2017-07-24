<?php
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();

//check to see if we're showing the form or adding the post
if (!$_POST) {
    // showing the form; check for required item in query string
    if (!isset($_GET['post_id'])) {
        header("Location: topiclist.php");
        exit;
    }

    //create safe values for use
    $safe_post_id = mysqli_real_escape_string($mysqli, $_GET['post_id']);

    //still have to verify topic and post
    $verify_sql = "SELECT ft.topic_id, ft.topic_title FROM forum_posts
                  AS fp LEFT JOIN forum_topics AS ft ON fp.topic_id =
                  ft.topic_id WHERE fp.post_id = '".$safe_post_id."'";

    $verify_res = mysqli_query($mysqli, $verify_sql)
    or die(mysqli_error($mysqli));

    if (mysqli_num_rows($verify_res) < 1) {
        //this post or topic does not exist
        header("Location: topiclist.php");
        exit;
    } else {
        //get the topic id and title
        while($topic_info = mysqli_fetch_array($verify_res)) {
            $topic_id = $topic_info['topic_id'];
            $topic_title = stripslashes($topic_info['topic_title']);
        }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPLY TO ALL</title>
    <meta name="description" content="" />
    <meta name="author" content="templatemo">

    <link rel="shortcut icon" href="./favicon.png" />		
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/camera.css" rel="stylesheet">
    <link href="css/templatemo_style.css" rel="stylesheet">

</head>

    <div id="templatemo_contact" class="container_wapper">
        <div class="container">
            <div class="row">  
                <div id="templatemo_contact_map_wapper">
                    <div id="templatemo_contact_map"><img src="images/PT.png" alt="logo" width="300PX"/></div>
                </div>
                <div class="col-xs-12 section_header">
                    <h1>Reply</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                   <h1>Post Your Reply in <?php echo $topic_title; ?></h1>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="col-md-12">
                        <p>Your Email Address</p>
                         <input type="email" id="post_owner" name="post_owner" size="40"
                       maxlength="150" required="required"style="width:500px;height:50px"></p>
                    </div>
                 
                    <div class="col-xs-12">
                        <p>Post Text</p>
			<textarea id="post_text" name="post_text" rows="8" cols="40"
                          required="required"></textarea></p>
                    </div>

      		    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
 		    <div class="col-md-4">
		    </div>
                    <div class="col-md-4 col-xs-8">
                        <button type="submit" name="submit" value="submit">Add Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.mobile.customized.min.js"></script>
    <script src="js/camera.min.js"></script>
    <script src="js/jquery.singlePageNav.min.js"></script>
    <script src="js/templatemo_script.js"></script>
</form>

</body>
</html>

        <?php
        //free result
        mysqli_free_result($verify_res);

        //close connection to MySQL
        mysqli_close($mysqli);
    }

} else if ($_POST) {
    //check for required items from form
    if ((!$_POST['topic_id']) || (!$_POST['post_text']) ||
        (!$_POST['post_owner'])) {
        header("Location: topiclist.php");
        exit;
    }

    //create safe values for use
    $safe_username = mysqli_real_escape_string($mysqli,$_SESSION['username']);
    $safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['topic_id']);
    $safe_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);
    $safe_post_owner = mysqli_real_escape_string($mysqli, $_POST['post_owner']);

    //$safe_post_text = "To ".$safe_post_owner." :<br/><br/>".$safe_post_text;

    //add the post
    $add_post_sql = "INSERT INTO forum_posts (topic_id,post_text,
                       post_create_time,post_owner,username) VALUES
                       ('".$safe_topic_id."', '".$safe_post_text."',
                       now(),'".$safe_post_owner."','".$safe_username."')";
    $add_post_res = mysqli_query($mysqli, $add_post_sql)
    or die(mysqli_error($mysqli));

    //close connection to MySQL
    mysqli_close($mysqli);

    //redirect user to topic
    header("Location: showtopic.php?topic_id=".$_POST['topic_id']);
    exit;
}
?>

