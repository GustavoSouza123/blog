<!DOCTYPE html>
<html lang="en">
<head>
    <title>Painel de Controle | Code Universe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="panel-container">
        <header>
            <h1>Olá, <?php echo $_SESSION['codeuniverse-name']; ?>!</h1>
            <div class="logout">Sair</div>
        </header>
        
        <div class="actions">
            <h3>Ações</h3>
            <div class="title">Categorias</div>
            <div class="action">Adicionar categoria</div>
            <div class="action">Editar categorias</div>
            <div class="title">Artigos</div>
            <div class="action">Adicionar artigo</div>
            <div class="action">Editar artigos</div>
            <div class="title">Painel</div>
            <div class="action">Adicionar usuário</div>
            <div class="action">Editar usuários</div>
        </div>

        <div class="main">
            <div class="action-window">
                <div class="title"></div>
                <form action="" method="post">
                    <input type="submit" value="Enviar" />
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
</body>
</html>