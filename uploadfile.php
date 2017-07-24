<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17-6-10
 * Time: 下午5:01
 */
require_once 'checkUsers.php';
include 'ConDB.php';
checkUsers();
doDB();
session_start();
if(!$_POST)
{
    if(!isset($_POST['post_text']))
    {
        header("Location:uploadfileform.php");
    }
}
else {
    $username = mysqli_real_escape_string($mysqli,$_SESSION['username']);
    $safe_text=mysqli_real_escape_string($mysqli,$_POST['post_text']);
    $filename=mysqli_real_escape_string($mysqli,$_FILES["file"]["name"]);
    $filetype=mysqli_real_escape_string($mysqli,$_FILES["file"]["type"]);
    $fileSize=mysqli_real_escape_string($mysqli,$_FILES["file"]["size"]);
    $allowedExts = array("gif", "jpeg", "jpg", "png", "mp4", "mp3", "torrent", "rmvb", "avi");//the extart file type
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);  //get the filename extension
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "video/mp4")
            || ($_FILES["file"]["type"] == "audio/mp3")
            || ($_FILES["file"]["type"] == "application/x-bittorrent")
            || ($_FILES["file"]["type"] == "application/vnd.rn-realmedia")
            || ($_FILES["file"]["type"] == "video/x-msvideo"))
        && ($_FILES["file"]["size"] < 204800 * 1024)   // less 200 MB
        && in_array($extension, $allowedExts)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error:" . $_FILES["file"]["error"] . "<br>";
        } else {
            echo "Upload File Name:" . $_FILES["file"]["name"] . "<br>";
            echo "File Type: " . $_FILES["file"]["type"] . "<br>";
            echo "File Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";

            //check the directories is exists
            if (file_exists("/home/wwwroot/default/index/outeruser_form/upload/" . $_FILES["file"]["name"])) {
                //echo $_FILES["file"]["name"] . " The File has been existed.<p><a href='uploadfileform.php'>Back!</a></p>";
                $welcome="The File has existed!";
                echo "<script language=
                \"JavaScript\">\r\n";
                echo " alert(\"$welcome\");\r\n";
                echo " location.replace
                (\"http://localhost/outeruser_form/uploadfileform.php\");\r\n"; // 自己修改网址
                echo "</script>";
                exit;
            } else {
                // the file does not exists in the directories
                $sql = "INSERT INTO uploadFile(username,fileName,fileType,fileSize,fileComment,upload_time) VALUES ('".$username ."', '".$filename."', '".$filetype."','".$fileSize."','".$safe_text."',now())";
                mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
                $sql="UPDATE outerusers SET  Point=Point+1 WHERE username = "."'".$username."'";
                mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
                move_uploaded_file($_FILES["file"]["tmp_name"], "/home/wwwroot/default/index/outeruser_form/upload/" . $_FILES["file"]["name"]);
                //echo "The file has been uploaded!<p><a href='uploadfileform.php'>Back!</a></p>";
                $welcome="Upload Successfully!";
                echo "<script language=
                \"JavaScript\">\r\n";
                echo " alert(\"$welcome\");\r\n";
                echo " location.replace
                (\"http://localhost/outeruser_form/uploadfileform.php\");\r\n"; // 自己修改网址
                echo "</script>";
                exit;
            }
        }
    } else {
        echo "illegal file name.";
    }
}
?>