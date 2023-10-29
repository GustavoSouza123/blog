<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['formName'])) ? $_POST['formName'] : '';
    $action_name = (isset($_POST['actionName'])) ? $_POST['actionName'] : '';
    $index = (isset($_POST['index'])) ? $_POST['index'] : '';

    $tableName = '';
    if($form_name == 'category') {
        $tableName = 'tb_categories';
    } else if($form_name == 'post') {
        $tableName = 'tb_posts';
    } else if($form_name == 'user') {
        $tableName = 'tb_admin_users';
    }

    if($action_name == 'edit') {
        $data['table'] = $tableName;
        $data['action'] = $action_name;
        $data['index'] = $index;
        try {
            $sql = $pdo->prepare("SELECT * FROM `".$tableName."` WHERE id = ?");     
            $sql->execute(array($index));
            $data['row'] = $sql->fetch(PDO::FETCH_ASSOC);
            $data['success'] = true;
        } catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao editar campo";
            $data['error'] .= $e->getMessage();
        }
    } else if($action_name == 'delete') {
        $data['table'] = $tableName;
        $data['action'] = $action_name;
        $data['index'] = $index;
        try {
            $sql = $pdo->prepare("DELETE FROM `".$tableName."` WHERE id = ?");
            $sql->execute(array($index));
            $data['success'] = true;
        } catch(PDOException $e) {
            $data['success'] = false;
            $data['error'] = "Erro ao excluir campo";
        }
    } else {
        $data['error'] = "Erro no nome da ação";
    }

    die(json_encode($data));
?>
