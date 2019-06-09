<?php

foreach(\App\Support\Facades\Response::messages() as $type => $messages) {
    foreach($messages as $message) {
        $class = $type === 'error' ? 'danger' : $type;

        echo '<div class="alert alert-' . $class . '" alert-dismissible">';
        echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        echo $message;
        echo '</div>';
    }
}

