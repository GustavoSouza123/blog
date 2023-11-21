<?php require 'config/config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descrição do meu website"> <!-- seo -->
    <meta name="keywords" content="palavras,chave,do,meu,website"> <!-- seo -->
    <link rel="icon" type="image/x-icon" href=""> <!-- website icon -->

    <!-- css files -->
    <?php
        $url = (isset($_GET['url'])) ? $_GET['url'] : 'home';
        $cssName = ($url == 'article') ? 'article' : 'blog';
    ?>
    <link href="<?php echo INCLUDE_PATH; ?>assets/css/standard.css" rel="stylesheet"> 
    <link href="<?php echo INCLUDE_PATH_PORTFOLIO; ?>assets/css/header.css" rel="stylesheet">
    <link href="<?php echo INCLUDE_PATH.'assets/css/'.$cssName.'.css'; ?>" rel="stylesheet"> 

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> <!-- jQuery API -->
    <script src="https://kit.fontawesome.com/52201d9086.js" crossorigin="anonymous"></script> <!-- font awesome icons -->

    <title>My Blog</title> <!-- title -->
</head>
<body>
    <!-- include path --> 
    <input type="hidden" name="include_path" value="<?php echo INCLUDE_PATH; ?>" />

    <!-- background -->
    <div class="background"></div>
    
    <?php
        // friendly url
        if(file_exists('pages/'.$url.'.php')) {
            include 'pages/'.$url.'.php';
        } else {
            include 'pages/404.php';
        }
    ?>

    <script src="<?php echo INCLUDE_PATH;?>assets/js/script.js"></script> <!-- main javascript file -->
    <script src="<?php echo INCLUDE_PATH_PORTFOLIO;?>assets/js/script.js"></script> <!-- main javascript file -->
</body>
</html>
