<?php
namespace core;

abstract class System extends Core {

    public static function require(string $filename, bool $return = false, bool $error = true) {
        if (file_exists($filename)) {
            if ($return) {
                return require_once($filename);
            } else {
                require_once($filename);
            }
        } else {
            if ($error) {
                throw new \Exception("The file does not exist: $filename");
            } else {
                return false;
            }
        }
    }

}
?>