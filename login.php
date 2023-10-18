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
            <h1>Login</h1>
            <form action="" method="post">
                <input type="text" name="user" placeholder="Usuário" required />
                <input type="password" name="password" placeholder="Senha" required />
                <input type="submit" name="login" value="Login" />
                <?php if($error) echo "Preencha todos os campos"; ?>
            </form>
        </div>
    </div>
    
    <script src="js/script.js"></script>
</body>
</html>
