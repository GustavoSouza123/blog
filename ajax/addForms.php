<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['form_name'])) ? $_POST['form_name'] : '';
    $edit_form = (isset($_POST['edit_form'])) ? $_POST['edit_form'] : '';
    $upload_dir = 'assets/uploads/';

    $data['ajax'] = true;
    $data['post'] = $_POST;
    $data['files'] = $_FILES;

    // forms submition (add forms)
    if($form_name == 'category') {
        $data['isset'] = true;
        $name = $_POST['name'];

        $image = $upload_dir.$_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        if(move_uploaded_file($imageTmpName, '../admin/'.$image)) {
            $data['success'] = true;
        } else {
            $data['success'] = false;
            $data['error'] = "Erro ao enviar arquivo";
        }

        $creation_date = date("Y-m-d H:i:s");

        // adding data to database
        if($data['success']) {
            try {
                $sql = $pdo->prepare("INSERT INTO `tb_categories` VALUES (null, ?, ?, ?)");
                $sql->execute(array($name, $image, $creation_date));
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao adicionar categoria";
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
            $data['error'] = "Erro ao enviar arquivo";
        }

        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $post = $_POST['post'];
        $creation_date = date("Y-m-d H:i:s");
        $last_update = $creation_date;
        $read_time = ceil(str_word_count($post) / 250);

        $published = 1;
        if($_POST['draft']) {
            $published = 0;
            $data['draft'] = true;
        }
        
        $sql = $pdo->prepare("SELECT id FROM `tb_admin_users` WHERE name = ?");
        $sql->execute(array($_POST['author']));
        $author_id = $sql->fetchColumn();

        // adding data to database
        if($data['success']) {
            try {
                $sql = $pdo->prepare("INSERT INTO `tb_posts` VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $sql->execute(array($author_id, $category_id, $thumbnail, $title, $subtitle, $post, $read_time, $published, $creation_date, $last_update));
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao adicionar post";
                $data['error'] .= $e->getMessage();
            }
        }
    } else if($form_name == 'user') {
        $data['isset'] = true;
        $user = $_POST['user'];
        $email = $_POST['email'];

        $sql = $pdo->prepare("SELECT * FROM `tb_admin_users`");
        $sql->execute();
        $users = $sql->fetchAll(PDO::FETCH_ASSOC);
        $data['success'] = true;
        foreach($users as $key => $value) {
            if($value['user'] == $user) {
                $data['success'] = false;
                $data['error'] = "Nome de usuário inválido";
                break;
            }
            if($value['email'] == $email) {
                $data['success'] = false;
                $data['error'] = "Email inválido";
                break;
            }
        }

        if($data['success']) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // password hashing
            $name = $_POST['name'];

            $profile_photo = $upload_dir.$_FILES['profile_photo']['name'];
            $profilePhotoTmpName = $_FILES['profile_photo']['tmp_name'];
            if(move_uploaded_file($profilePhotoTmpName, '../admin/'.$profile_photo)) {
                $data['success'] = true;
            } else {
                $data['success'] = false;
                $data['error'] = "Erro ao enviar arquivo";
            }

            $role = (isset($_POST['role'])) ? $_POST['role'] : '1';
            $joined_in = date("Y-m-d H:i:s");

            // adding data to database
            if($data['success']) {
                try {
                    $sql = $pdo->prepare("INSERT INTO `tb_admin_users` VALUES (null, ?, ?, ?, ?, ?, ?, ?)");
                    $sql->execute(array($user, $email, $password, $name, $profile_photo, $role, $joined_in));
                    $data['success'] = true;
                } catch(PDOExcetion $e) {
                    $data['success'] = false;
                    $data['error'] = "Erro ao adicionar usuário";
                    $data['error'] .= $e->getMessage();
                }
            }
        }
    } else if($edit_form != '') {
        // updating tables
        $data['edit'] = true;
        $id = $_POST['index'];
        $hasImage = false;

        if((isset($_FILES['image']) && $_FILES['image']['name'] != '') || (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name'] != '') || (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['name'] != '')) {
            $hasImage = true;
        }

        $tableName = $_POST['table'];
        if($tableName == 'tb_categories') {
            try {
                $sql = $pdo->prepare("UPDATE `".$tableName."` SET name = ? WHERE id = ?");
                $sql->execute(array($_POST['name'], $id));
                // verify if a new image was uploaded
                if($hasImage) {
                    $image = $upload_dir.$_FILES['image']['name'];
                    $imageTmpName = $_FILES['image']['tmp_name'];
                    if(move_uploaded_file($imageTmpName, '../admin/'.$image)) {
                        $data['success'] = true;
                    } else {
                        $data['success'] = false;
                        $data['error'] = "Erro ao enviar arquivo";
                    }
                    $sql = $pdo->prepare("UPDATE `".$tableName."` SET image = ? WHERE id = ?");
                    $sql->execute(array($image, $id));
                }
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao atualizar tabela";
                $data['error'] .= $e->getMessage();
            }
        } else if($tableName == 'tb_posts') {
            try {
                $read_time = ceil(str_word_count($_POST['post']) / 250);
                $last_update = date("Y-m-d H:i:s");
                $published = 1;
                if($_POST['draft']) {
                    $published = 0;
                    $data['draft'] = true;
                }
                $sql = $pdo->prepare("UPDATE `".$tableName."` SET category_id = ?, title = ?, subtitle = ?, post = ?, read_time = ?, published = ?, last_update = ? WHERE id = ?");
                $sql->execute(array($_POST['category_id'], $_POST['title'], $_POST['subtitle'], $_POST['post'], $read_time, $published, $last_update, $id));
                // verify if a new image was uploaded
                if($hasImage) {
                    $thumbnail = $upload_dir.$_FILES['thumbnail']['name'];
                    $thumbnailTmpName = $_FILES['thumbnail']['tmp_name'];
                    if(move_uploaded_file($thumbnailTmpName, '../admin/'.$thumbnail)) {
                        $data['success'] = true;
                    } else {
                        $data['success'] = false;
                        $data['error'] = "Erro ao enviar arquivo";
                    }
                    $sql = $pdo->prepare("UPDATE `".$tableName."` SET thumbnail = ? WHERE id = ?");
                    $sql->execute(array($thumbnail, $id));
                }
                $data['success'] = true;
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao atualizar tabela";
                $data['error'] .= $e->getMessage();
            }
        } else if($tableName == 'tb_admin_users') {
            try {
                $sql = $pdo->prepare("SELECT * FROM `tb_admin_users` WHERE id <> ?");
                $sql->execute(array($id));
                $users = $sql->fetchAll(PDO::FETCH_ASSOC);
                $data['success'] = true;
                foreach($users as $key => $value) {
                    if($value['user'] == $_POST['user']) {
                        $data['success'] = false;
                        $data['error'] = "Nome de usuário inválido";
                        break;
                    }
                    if($value['email'] == $_POST['email']) {
                        $data['success'] = false;
                        $data['error'] = "Email inválido";
                        break;
                    }
                }
                
                if($data['success']) { 
                    $sql = $pdo->prepare("UPDATE `".$tableName."` SET user = ?, email = ?, password = ?, name = ?, role = ? WHERE id = ?");
                    $sql->execute(array($_POST['user'], $_POST['email'], $_POST['password'], $_POST['name'], $_POST['role'], $id));
                    // verify if a new image was uploaded
                    if($hasImage) {
                        $profile_photo = $upload_dir.$_FILES['profile_photo']['name'];
                        $profilePhotoTmpName = $_FILES['profile_photo']['tmp_name'];
                        if(move_uploaded_file($profilePhotoTmpName, '../admin/'.$profile_photo)) {
                            $data['success'] = true;
                        } else {
                            $data['success'] = false;
                            $data['error'] = "Erro ao enviar arquivo";
                        }
                        $sql = $pdo->prepare("UPDATE `".$tableName."` SET profile_photo = ? WHERE id = ?");
                        $sql->execute(array($profile_photo, $id));
                    }
                    $data['success'] = true;
                }
            } catch(PDOExcetion $e) {
                $data['success'] = false;
                $data['error'] = "Erro ao atualizar tabela";
                $data['error'] .= $e->getMessage();
            }
        }
    } else {
        $data['success'] = false;
        $data['error'] = "Erro no nome do formulário";
    }

    die(json_encode($data));
?>
