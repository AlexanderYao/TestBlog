<?php
require_once("constant.php");
require_once(PATH_BASE.DS."util.php");

$name = $_FILES["file"]["name"];
$type = $_FILES["file"]["type"];
$size = $_FILES["file"]["size"]/1024;
$tmp = $_FILES["file"]["tmp_name"];
$path = "/var/tmp/AlexanderYao/pic/".$name;

move_uploaded_file($tmp,$path);
Util::get_instance()->log_format("已上传文件：%s",$path);
echo "已上传文件：".$path;
?>
