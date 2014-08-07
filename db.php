<?php
require_once(PATH_BASE.DS."util.php");

class DB
{
    private static $_instance;
    private $_db;
    private $_host;
    private $_user;
    private $_password;
    private $_db_name;

    public static function get_instance(){
        if(!self::$_instance instanceof self){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){
        $this->_host = "localhost";
        $this->_user = "root";
        $this->_password = "sjtu";
        $this->_db_name = "test";
        $this->_db = new mysqli($this->_host,$this->_user,$this->_password,$this->_db_name);
        if($this->_db->connect_errno){
            Util::get_instance()->log_format("连接mysql出错，错误代码为：%s",$this->_db->connect_errno);
        }
        if(!$this->_db->set_charset("utf8")){
            Util::get_instance()->log_format("utf8设置出错，当前字符集为：%s",$this->_db->character_set_name());
        }
    }

    function query($sql)
    {
        return $this->_db->query($sql);
    }
    
    function escape($sql){
        return $this->_db->real_escape_string($sql);
    }

    function __destruct(){
        $this->_db->close();
    }
}
