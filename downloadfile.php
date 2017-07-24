<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17-6-11
 * Time: 下午8:55
 */
include 'ConDB.php';
require_once 'checkUsers.php';
checkUsers();
doDB();
session_start();
$username=mysqli_real_escape_string($mysqli,$_SESSION['username']);
if($_GET['id']) {
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    $sql = "SELECT fileName,username FROM uploadFile where id=" . $id;
    $down_res = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($down_res) < 1)
    {
        $welcome = "No that file";
        echo "<script language=
                \"JavaScript\">\r\n";
        echo " alert(\"$welcome\");\r\n";
        echo " location.replace
                (\"http://localhost/outeruser_form/showfile.php\");\r\n"; // 自己修改网址
        echo "</script>";
        exit;
    }
    else
    {
        $sql="SELECT Point FROM outerusers WHERE username = "."'".$username."'";
        $res=mysqli_query($mysqli,$sql);
        $user_info=mysqli_fetch_array($res);
        $down_res=mysqli_fetch_array($down_res);
        $point=$user_info['Point'];
        $res_username=$down_res['username'];
        if ($point >0 or !strcmp($res_username,$username))//大于0分或本人上传
        {
            if(strcmp($res_username,$username))//非本人上传
            {
                $sql="UPDATE outerusers SET  Point=Point-1 WHERE username = "."'".$username."'";
                mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
            }
            $filename = $down_res['fileName'];
            $welcome="Press to download.";
            echo "<script language=
                \"JavaScript\">\r\n";
            echo " alert(\"$welcome\");\r\n";
            echo " location.replace
                (\"http://localhost/outeruser_form/upload/".$filename."\");\r\n"; // 自己修改网址
            echo "</script>";
            exit;
            //header("Location:upload/" . $filename);
            //exit;
        }
        else
        {
            $welcome="Your Point is not enough!";
            echo "<script language=
                \"JavaScript\">\r\n";
            echo " alert(\"$welcome\");\r\n";
            echo " location.replace
                (\"http://localhost/outeruser_form/showfile.php\");\r\n"; // 自己修改网址
            echo "</script>";
            exit;
        }
    }
}
else
    {
        header("Location:showfile.php");
        exit;
    }
?>