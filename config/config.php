<?php
    session_start();

    /* autoload classes */
    $autoload = function($class) {
        require_once 'classes/'.$class.'.php';
    };
    spl_autoload_register($autoload);

    /* constants variables */
    define('INCLUDE_PATH', 'http://localhost/code-universe');
?>
