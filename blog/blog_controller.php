<?php
require_once("../constant.php");
require_once(PATH_BLOG.DS."blog_repo.php");

if(!isset($_POST["method"])) exit;
$method = $_POST["method"];

switch($method){
    case "get":
        $id = $_POST["id"];
        $blog = BlogRepo::get_instance()->get_blog($id);
        echo $blog->_content;
        break;
    case "insert":
        $blog = new Blog();
        $blog->_title = $_POST["title"];
        $blog->_content = $_POST["content"];
        $blog->_created = date("Y-m-d H:i:s");
        $result = BlogRepo::get_instance()->insert_blog($blog);
        echo $result;
        break;
    case "delete":
        $id = $_POST["id"];
        $result = BlogRepo::get_instance()->delete_blog($id);
        echo $result;
        break;
    case "update":
        //Util::get_instance()->log("begin update");
        $blog = new Blog();
        $blog->_id = $_POST["id"];
        $blog->_title = $_POST["title"];
        $blog->_content = $_POST["content"];
        $result = BlogRepo::get_instance()->update_blog($blog);
        //Util::get_instance()->log_format("end update".$result);
        echo $result;
        break;
}
