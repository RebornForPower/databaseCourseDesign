
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD A TOPIC</title>
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
                    <h1>Release</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-md-offset-3">
                    <p>ADD A TOPIC</p>
                </div>
                <form method="post" action="do_addtopic.php">
                    <div class="col-md-4">
                        <p>Your Email Address</p>
                        <input type="email" id="topic_owner" name="topic_owner" size="40"
       				 maxlength="150" required="required" style="height:50px"/></p>
                    </div>
                 
		    <div class="col-md-8">
                        <p>Topic Tittle</p>
                        <input type="text" id="topic_title" name="topic_title" size="40"
       			 	maxlength="150" required="required" /></p>
                    </div>
   		  
                    <div class="col-xs-12">
                        <p>Post Text</p>
                        <textarea id="post_text" name="post_text" rows="8"
         			 cols="40" ></textarea></p>

                    </div>
 		    <div class="col-md-4">
		    </div>
                    <div class="col-md-4 col-xs-8">
                        <button type="submit" name="submit" value="submit">Add Topic</button>
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
