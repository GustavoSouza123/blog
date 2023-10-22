<!DOCTYPE html>
<html lang="en">
<head>
    <title>Painel de Controle | Code Universe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo INCLUDE_PATH_ADMIN; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        // logout
        if(isset($_GET['logout'])) {
            Panel::logout();
        }
    ?>

    <!-- include path -->
    <input type="hidden" name="include_path" value="<?php echo INCLUDE_PATH; ?>" />

    <!-- admin panel container -->
    <div class="panel-container">
        <header>
            <h3><?php echo 'Olá, '.$_SESSION['codeuniverse-name'].'!'; ?></h3>
            <div class="menu">
                <ul>
                    <li class="action">
                        <a href="">Categorias</a>
                        <span></span>
                        <ul class="dropdown">
                            <li><a href="" index="0">Adicionar categoria</a></li>
                            <li><a href="" index="1">Gerenciar categorias</a></li>
                        </ul>
                    </li>
                    <li class="action">
                        <a href="">Posts</a>
                        <span></span>
                        <ul class="dropdown">
                            <li><a href="" index="2">Adicionar postagem</a></li>
                            <li><a href="" index="3">Gerenciar postagens</a></li>
                        </ul>
                    </li>
                    <li class="action">
                        <a href="">Painel</a>
                        <span></span>
                        <ul class="dropdown">
                            <li><a href="" index="4">Adicionar usuário</a></li>
                            <li><a href="" index="5">Gerenciar usuários</a></li>
                        </ul>
                    </li>
                    <li><a href="blog.php" target="_blank">Blog</a></li>
                    <li><a href="?logout">Sair</a></li>
                </ul>
            </div>
        </header>

        <div class="main">
            <div class="action-window">
                <div class="title"></div>
                <form action="" method="post" enctype="multipart/form-data"></form>
            </div>
        </div>
    </div>

    <script src="<?php echo INCLUDE_PATH; ?>assets/js/jquery.js"></script>
    <script src="<?php echo INCLUDE_PATH_ADMIN; ?>assets/js/script.js"></script>
</body>
</html>
