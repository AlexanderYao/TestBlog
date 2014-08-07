<?php
class Util
{
    private static $_instance;

    public static function get_instance(){
        if(!self::$_instance instanceof self){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct(){}

    function log($string)
    {
        $s = sprintf("%s\n",$string);
        return error_log($s,3,"/var/tmp/AlexanderYao/error.log");
    }

    function log_format(/*format[,$arg1...$argN]*/)
    {
        $args = func_get_args();
        if(count($args) == 1){
            return $this->log($args[0]);
        }
        $format = array_shift($args);
        $s = vsprintf($format, $args);
        return $this->log($s);
    }
}
