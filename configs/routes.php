<?php

return [
    '/' => 'Controller',
    'adicionar' => 'Controller@add',
    'emprestimo/{id}' => 'Controller@show',
    'emprestimo/{id}/remover' => 'Controller@delete',
    'salvar' => 'Controller@updatePost',
    'salvar/{id}' => 'Controller@updatePost',
];
