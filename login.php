<!DOCTYPE html>
<html lang="en">
<head>
    <title>Painel de Controle | Code Universe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        $error = false;
        if(isset($_POST['login'])) {
            if($_POST['user'] == '' || $_POST['password'] == '') {
                $error = true;
            } else {
                $sql = $pdo->prepare("SELECT * FROM `tb_admin_users` WHERE user = ? AND password = ?");
                $sql->execute(array($_POST['user'], $_POST['password']));
                if($sql->rowCount() == 1) {
                    $info = $sql->fetch();
                    $_SESSION['codeuniverse-login'] = true;
                    $_SESSION['codeuniverse-user'] = $info['user'];
                    $_SESSION['codeuniverse-password'] = $info['password'];
                    $_SESSION['codeuniverse-name'] = $info['name'];
                    header('Location: '.INCLUDE_PATH);
                    die();
                } else {
                    $error = true;
                }
            }
        }
    ?>

    <div class="login-container">
        <div class="login-box">
            <div class="title">
                <h3>Login</h3>
            </div>
            <form action="" method="post">
                <label for="user">Usuário ou email</label>
                <input type="text" name="user" id="user" required />
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" required />
                <div class="remember">
                    <input type="checkbox" name="remember" />
                    <label for="remember">Lembrar Senha</label>
                </div>
                <input type="submit" name="login" value="Login" />
                <?php if($error) echo "Erro ao enviar o formulário"; ?>
            </form>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
