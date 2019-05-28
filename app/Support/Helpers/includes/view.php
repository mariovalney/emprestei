<?php

if (! function_exists('include_template')) {
    function include_template($template) {
        $template = VIEW_DIR . DS . $template . '.php';

        if (! file_exists($template)) {
            return;
        }

        require $template;
    }
}
