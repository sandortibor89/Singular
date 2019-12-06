<?php
namespace core;

abstract class Core {
    private static $map = [];

    private static function getInstance():self {
        $class = get_called_class();
        $args = func_get_args();
        if (!isset(self::$map[$class])) {
            if(count($args) === 0) {
                self::$map[$class] = new $class();
            }
            else {
                $rc = new \ReflectionClass($class);
                self::$map[$class] = $rc->newInstanceArgs($args);
            }
        }
        return self::$map[$class];
    }

    public static function __callStatic($name, $arguments = []):self {
        //echo get_called_class();
        return call_user_func_array(['\system\core\\'.ucfirst($name), 'getInstance'], $arguments);
    }
}
?>