<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo INCLUDE_PATH_ADMIN; ?>assets/css/style.css" rel="stylesheet">
    <title>Cadastre-se | My Blog</title>
</head>
<body>
    <?php
        // login verification
        $error = false;
        if(isset($_POST['register'])) {
            if($_POST['user'] == '' || $_POST['password'] == '') {
                $error = true;
            } else {
                // PAREI AQUI!
                $sql = $pdo->prepare("SELECT * FROM `tb_admin_users` WHERE user = ? AND password = ?");
                $sql->execute(array($_POST['user'], $_POST['password']));
                if($sql->rowCount() == 1) {
                    $info = $sql->fetch();
                    $_SESSION['codeuniverse-login'] = true;
                    $_SESSION['codeuniverse-user'] = $info['user'];
                    $_SESSION['codeuniverse-password'] = $info['password'];
                    $_SESSION['codeuniverse-name'] = $info['name'];
                    header('Location: '.INCLUDE_PATH_ADMIN);
                    die();
                } else {
                    $error = true;
                }
            }
        }
    ?>

    <!-- include path --> 
    <input type="hidden" name="include_path" value="<?php echo INCLUDE_PATH; ?>" />

    <!-- login container -->
    <div class="register-container">
        <div class="register-box">
            <?php if($error) echo '<p class="error">Erro ao enviar o formulário</p>'; ?> <!-- maybe temporary -->
            <div class="title">
                <h3>Cadastre-se</h3>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <label for="user">Usuário</label>
                <input type="text" name="user" id="user" required />
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required />
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" required />
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" required /> 
                <label for="profile-photo">Foto</label>
                <input type="file" name="profile-photo" id="profile-photo" required /> 
<div class="change-register">Já tem uma conta? <a href="<?php echo INCLUDE_PATH_ADMIN; ?>login">Entre</a></div>
                <input type="submit" name="register" value="Login" />
            </form>
        </div>
    </div>
</body>
</html>
