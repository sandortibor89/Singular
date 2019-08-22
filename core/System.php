<?php
namespace core;

abstract class System {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __get($property) {
        if ($this->container->has($property)) {
            return $this->container->get($property);
        } else {
            return null;
        }
    }

}
?>