<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['form_name'])) ? $_POST['form_name'] : '';

    $data['ajax'] = true;
    $data['post'] = $_POST;
    print_r($_FILES);

    // forms submition
    if($form_name == 'category') {
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
    } else if($form_name == 'post') {
        $data['isset'] = true;
        $category_id = $_POST['category_id'];
        $upload_dir = 'uploads/';
        $thumbnail = $upload_dir.basename($_FILES['thumbnail']['name']); /* PAREI AQUI */
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $post = $_POST['post'];
        $creation_date = date("Y-m-d h:i:s");
        $last_update = $creation_date;
        $read_time = ceil(str_word_count($post) / 250);
        try {
            $sql = $pdo->prepare("INSERT INTO `tb_posts` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->execute(array($category_id, $thumbnail, $title, $subtitle, $post, $creation_date, $last_update, $read_time));
            $data['success'] = true;
        } catch(PDOExcetion $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao adicionar post<br>";
            $data['error'] .= $e->getMessage();
        }
    } else if($form_name == 'user') {
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
    } else {
        $data['success'] = false;
        $data['error'] = "Erro no nome do formulário";
    }

    die(json_encode($data)); 
?>
