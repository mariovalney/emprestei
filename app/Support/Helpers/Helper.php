<?php

namespace App\Support\Helpers;

class Helper
{
    /** @var array */
    private $helpers = [];

    /**
     * Look for helper files
     */
    public function __construct()
    {
        $directory = ROOT . 'app' . DS . 'Support' . DS . 'Helpers' . DS . 'includes';

        foreach(scandir($directory) as $file) {
            $file = $directory . DS . $file;

            if (! is_file($file)) {
                continue;
            }

            $this->helpers[] = $file;
        }
    }

    /**
     * Retrieve a instance
     *
     * @return
     */
    public function includeAll()
    {
        foreach($this->helpers as $helper) {
            include_once($helper);
        }
    }
}
