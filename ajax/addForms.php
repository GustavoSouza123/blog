<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['form_name'])) ? $_POST['form_name'] : '';
    $upload_dir = 'assets/uploads/';

    $data['ajax'] = true;
    print_r($_FILES);
    print_r($_POST);

    // forms submition
    if($form_name == 'category') {
        $data['isset'] = true;
        $name = $_POST['name'];

        $image = $upload_dir.$_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        if(move_uploaded_file($imageTmpName, '../admin/'.$image)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Erro ao enviar arquivo<br>";
        }

        // adding data to database
        if($data['success']) {
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
    } else if($form_name == 'post') {
        $data['isset'] = true;
        $category_id = $_POST['category_id'];

        $thumbnail = $upload_dir.$_FILES['thumbnail']['name'];
        $thumbnailTmpName = $_FILES['thumbnail']['tmp_name'];
        if(move_uploaded_file($thumbnailTmpName, '../admin/'.$thumbnail)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Erro ao enviar arquivo<br>";
        }

        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $post = $_POST['post'];
        $creation_date = date("Y-m-d H:i:s");
        $last_update = $creation_date;
        $read_time = ceil(str_word_count($post) / 250);

        // adding data to database
        if($data['success']) {
            try {
                $sql = $pdo->prepare("INSERT INTO `tb_posts` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sql->execute(array($category_id, $thumbnail, $title, $subtitle, $post, $creation_date, $last_update, $read_time));
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao adicionar post<br>";
                $data['error'] .= $e->getMessage();
            }
        }
    } else if($form_name == 'user') {
        $data['isset'] = true;
        $user = $_POST['user'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];

        $profile_photo = $upload_dir.$_FILES['profile_photo']['name'];
        $profilePhotoTmpName = $_FILES['profile_photo']['tmp_name'];
        if(move_uploaded_file($profilePhotoTmpName, '../admin/'.$profile_photo)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Erro ao enviar arquivo<br>";
        }

        // adding data to database
        if($data['success']) {
            try {
                $sql = $pdo->prepare("INSERT INTO `tb_admin_users` VALUES (null, ?, ?, ?, ?, ?)");
                $sql->execute(array($user, $email, $password, $name, $profile_photo));
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao adicionar usuário<br>";
                $data['error'] .= $e->getMessage();               
            }
        }
    } else {
        $data['success'] = false;
        $data['error'] = "Erro no nome do formulário";
    }

    die(json_encode($data));
?>