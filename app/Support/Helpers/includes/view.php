<?php

if (! function_exists('include_template')) {
    function include_template($template, $data = []) {
        $template = VIEW_DIR . DS . $template . '.php';

        if (! file_exists($template)) {
            return;
        }

        if (! empty($data)) {
            extract($data);
        }

        require $template;
    }
}
