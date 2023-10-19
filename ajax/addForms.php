<?php
    require '../config/config.php';
    $data = [];

    $data['ajax'] = true;
    $data['post'] = $_POST;

    // forms submition
    if(isset($_POST['category'])) {
        $data['isset'] = true;
        $name = $_POST['name'];
        $image = $_POST['image'];
        try {
            $sql = $pdo->prepare("INSERT INTO `tb_categories` VALUES (null, ?, ?)");
            $sql->execute(array($name, $image));
            $data['success'] = true;
        } catch(PDOExcetion $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao adicionar categoria<br>";
            $data['error'] .= $e->getMessage();
        }
    }
        
    if(isset($_POST['post'])) {
        $data['isset'] = true;
        $category_id = $_POST['category_id'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $post = $_POST['post'];
        try {
            $sql = $pdo->prepare("INSERT INTO `tb_posts` VALUES (null, ?, ?, ?, ?)");
            $sql->execute(array($category_id, $title, $subtitle, $post));
            $data['success'] = true;
        } catch(PDOExcetion $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao adicionar post<br>";
            $data['error'] .= $e->getMessage();
        }
    }

    if(isset($_POST['user'])) {
        $data['isset'] = true;
        $user = $_POST['user'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        try {
            $sql = $pdo->prepare("INSERT INTO `tb_admin_users` VALUES (null, ?, ?, ?)");
            $sql->execute(array($user, $password, $name));
            $data['success'] = true;
        } catch(PDOExcetion $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao adicionar usuário<br>";
            $data['error'] .= $e->getMessage();               
        }
    }

    die(json_encode($data)); 
?>
