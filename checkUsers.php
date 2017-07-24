<?php
/**
 * Created by PhpStorm.
 * User: KaiGod
 * Date: 17-6-10
 * Time: 上午3:33
 */
function checkUsers()
{
    session_start();
    if (!(isset($_SESSION['username']) && isset($_SESSION['passhash']))) {
        echo "<script language=
                \"JavaScript\">\r\n";
        echo " alert(\"You are not logining in or logining is expired,please login in again\");\r\n";
        echo " location.replace
                (\"http://localhost/outeruser_login.php\");\r\n"; // 自己修改网址
        echo "</script>";
        exit;
    }
}
function destorySession()
{
    session_start();
    $olduser=$_SESSION['username'];
    unset($_SESSION['username']);
    unset($_SESSION['passhash']);
    session_destroy();
    if(!empty($olduser)) {
        echo "<script language=
                \"JavaScript\">\r\n";
        echo " alert(\"You are logining out!\");\r\n";
        echo " location.replace
                (\"http://localhost/outeruser_login.php\");\r\n"; // 自己修改网址
        echo "</script>";
        exit;
    }
    else{
        echo "<script language=
                \"JavaScript\">\r\n";
        echo " alert(\"You are not login in!\");\r\n";
        echo " location.replace
                (\"http://localhost/outeruser_login.php\");\r\n"; // 自己修改网址
        echo "</script>";
        exit;
    }
}
?>
