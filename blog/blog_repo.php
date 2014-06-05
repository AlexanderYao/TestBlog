<?php
require_once(PATH_BASE.DS."db.php");
require_once(PATH_BLOG.DS."blog.php");

class BlogRepo
{
    private static $_instance;

    public static function get_instance(){
        if(!self::$_instance instanceof self){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
    }

    function get_blogs()
    {
        $sql = "select id, title, created from blogs order by created desc";
        $result = DB::get_instance()->query($sql);
        $blogs = array();
        while($b = $result->fetch_object()){
            $blog = new Blog();
            $blog->_id = $b->id;
            $blog->_title = $b->title;
            $blog->_created = $b->created;
            $blogs[] = $blog;
        }
        return $blogs;
    }

    function get_blog($id){
        $sql = sprintf("select id, title, content, created from blogs where id = %s",$id);
        $result = DB::get_instance()->query($sql);
        if($result->num_rows == 0) return null;

        $blog = new Blog();
        $blog->_id = $id;
        $b = $result->fetch_object();
        $blog->_title = $b->title;
        $blog->_content = $b->content;
        $blog->_created = $b->created;
        return $blog;
    }
}
