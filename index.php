<?php
    require 'config/config.php';

    // get website content
    $activeLanguage = (isset($_COOKIE['activeLanguage'])) ? $_COOKIE['activeLanguage'] : 'en';
    $json = file_get_contents(INCLUDE_PATH_PORTFOLIO.'json/'.$activeLanguage.'.json');
    $content = json_decode($json);
    setcookie('portfolioContent', $json, time()+60*60*24, '/');

    // strip accents from a string
    function stripAccents($str){
        $newStr = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        return strtolower($newStr);
    }

    // website theme
    $theme = (isset($_COOKIE['portfolioTheme'])) ? $_COOKIE['portfolioTheme'] : 'dark';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My tech blog | Gustavo Souza"> <!-- seo -->
    <meta name="keywords" content="my,tech,blog,web,programming,coding"> <!-- seo -->
    <meta name="google-adsense-account" content="ca-pub-7508322719547433"> <!-- google ads -->
    <link rel="icon" type="image/x-icon" href=""> <!-- website icon -->
    <!-- css -->
    <style>
        .hidden {
            visibility: hidden;
            background: <?php if($theme == 'dark') echo '#222'; else echo '#fff'; ?>;
        }
        </style>
    <?php
        $url = (isset($_GET['url'])) ? $_GET['url'] : 'home';
        $cssName = ($url == 'article') ? 'article' : 'blog';
        ?>
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- google fonts api -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- google fonts api -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet"> <!-- Open Sans from google fonts api -->
    <link href="<?= INCLUDE_PATH; ?>assets/css/standard.css" rel="stylesheet"> <!-- standard css file --> 
    <link href="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/css/header.css" rel="stylesheet"> <!-- header css file -->
    <link href="<?= INCLUDE_PATH.'assets/css/'.$cssName.'.css'; ?>" rel="stylesheet"> <!-- main css file -->
    <link href="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/css/footer.css" rel="stylesheet"> <!-- footer css file -->
    <link href="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/css/animations.css" rel="stylesheet" /> <!-- animations css file -->
    <!-- javascript -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> <!-- jQuery API -->
    <script src="https://kit.fontawesome.com/52201d9086.js" crossorigin="anonymous"></script> <!-- font awesome icons -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7508322719547433" crossorigin="anonymous"></script> <!-- google ads -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q52S4D7J32"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-Q52S4D7J32');
    </script>
    <script>
        // page loading
        /*$(window).on('load', function() {
            $('.loading').fadeOut(200);
        })*/

        $('html').addClass('hidden')
        $(window).on('load', function() {
            $('html').removeClass('hidden');
            setTimeout(function() {
                $('header nav .languages div').css('transition', '.2s');
                $('header nav ul li a').css('transition', '.2s');
            }, 100)
        })
    </script> 
    <title><?= $content->blogTitle ?> | Gustavo Souza</title> 
</head>
<body>
    <!-- include path --> 
    <input type="hidden" name="include_path" value="<?= INCLUDE_PATH; ?>" />
    <input type="hidden" name="include_path_portfolio" value="<?= INCLUDE_PATH_PORTFOLIO; ?>" />
    
    <!-- website theme -->
    <input type="hidden" name="theme" value="<?= $theme ?>" />

    <!-- loading container -->
    <div class="loading">
        <img src="<?= INCLUDE_PATH_PORTFOLIO ?>assets/images/loading-<?= $theme ?>.svg" alt="loading spinner" />
    </div>

    <!-- content -->
    <?php
        // friendly url
        if(file_exists('pages/'.$url.'.php')) {
            include 'pages/'.$url.'.php';
        } else {
            include 'pages/404.php';
        }
    ?>

    <script src="<?= INCLUDE_PATH_PORTFOLIO;?>assets/js/script.js"></script> <!-- main javascript file -->
    <script src="<?= INCLUDE_PATH;?>assets/js/script.js"></script> <!-- main javascript file -->
    <script src="<?= INCLUDE_PATH_PORTFOLIO;?>assets/js/animations.js"></script> <!-- animations javascript file -->
</body>
</html>
