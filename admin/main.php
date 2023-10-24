<?php
    require_once '../config/config.php';

    // session verification
    if(Panel::isLogged()) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo INCLUDE_PATH_ADMIN; ?>assets/css/style.css" rel="stylesheet">
    <title>Painel de Controle | My Blog</title>
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
                        <li><a href="<?php echo INCLUDE_PATH; ?>">Blog</a></li>
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

<?php
    } else {
        echo '<title>Erro na sessão</title>';
        echo '<p style="font-size: 18px;">Erro ao iniciar sessão. <a href="login">Entre</a> ou <a href="signup">cadastre-se</a></p>';
    }    
?>
