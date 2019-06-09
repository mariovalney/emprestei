<?php

namespace App\Support;

class FacadeLoader
{
    /** @var FacadeLoader */
    private static $instance;

    /** @var boolean */
    private $registered = false;

    /** @var array */
    private $facades = [];

    /**
     * Avoid Cloning
     */
    private function __clone() {}

    /**
     * Avoid Unserialize
     */
    private function __wakeup() {}

    /**
     * Get all Facades
     */
    private function __construct() {
        $directory = ROOT . 'app' . DS . 'Support' . DS . 'Facades';


        foreach(scandir($directory) as $file) {
            $file = $directory . DS . $file;
            if (! is_file($file)) {
                continue;
            }

            $info = pathinfo($file);

            if ($info['filename'] === 'Facade' || $info['extension'] !== 'php') {
                continue;
            }

            $this->facades[ $info['filename'] ] = 'App\\Support\\Facades\\' . $info['filename'];
        }
    }

    /**
     * Register autoload
     *
     * @return void
     */
    public static function init()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }

        self::$instance->register();
    }

    public function load($class)
    {
        if (! empty($this->facades[ $class ])) {
            return class_alias($this->facades[ $class ], $class);
        }
    }

    /**
     * Retrieve a instance
     *
     * @return
     */
    public function register()
    {
        if ($this->registered) {
            return;
        }

        spl_autoload_register([$this, 'load'], true, true);
        $this->registered = true;
    }
}
