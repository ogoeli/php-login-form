<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db ="form";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("connect failed: %s\n".
    $conn -> error);
    echo "chair";
    return $conn;
}
function CloseConn ($conn)
{
    $conn -> close();
}
?>