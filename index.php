<?php require 'config/config.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descrição do meu website"> <!-- seo -->
    <meta name="keywords" content="palavras,chave,do,meu,website"> <!-- seo -->
    <link rel="icon" type="image/x-icon" href=""> <!-- website icon -->
    <link href="<?php echo INCLUDE_PATH; ?>assets/css/style.css" rel="stylesheet"> <!-- css file -->
    <title>Meu blog</title> <!-- title -->
</head>
<body>
    <!-- include path --> 
    <input type="hidden" name="include_path" value="<?php echo INCLUDE_PATH; ?>" />
    
    <?php
        // friendly url
        $url = isset($_GET['url']) ? $_GET['url'] : 'blog';
        if(file_exists('pages/'.$url.'.php')) {
            include 'pages/'.$url.'.php';
        } else {
            include 'pages/404.php';
        }
    ?>


    <script src="<?php echo INCLUDE_PATH;?>assets/js/jquery.js"></script> <!-- jquery file -->
    <script src="<?php echo INCLUDE_PATH;?>assets/js/script.js"></script> <!-- main javascript file -->
</body>
</html>
