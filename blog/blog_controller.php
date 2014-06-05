<?php
require_once("../constant.php");
require_once(PATH_BLOG.DS."blog_repo.php");

if(!isset($_GET["id"])) exit;

$id = $_GET["id"];
$blog = BlogRepo::get_instance()->get_blog($id);
echo $blog->_content;
