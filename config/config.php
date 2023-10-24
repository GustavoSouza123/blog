<?php
    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    /* autoload classes */
    $autoload = function($class) {
        $path = 'classes/'.$class.'.php';
        if(file_exists($path)) {
            require_once $path;
        } else if(file_exists('../'.$path)) {
            require_once '../'.$path;
        }
    };
    spl_autoload_register($autoload);

    /* website path */
    define('INCLUDE_PATH', 'http://localhost/blog/');
    define('INCLUDE_PATH_ADMIN', 'http://localhost/blog/admin/');

    /* database connection */
    define('HOST', 'localhost');
    define('USERNAME', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'my-blog');

    require 'connection.php';
?>