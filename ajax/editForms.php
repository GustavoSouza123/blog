<?php
    require '../config/config.php';
    $data = [];
    $action_name = (isset($_POST['actionName'])) ? $_POST['actionName'] : '';
    $index = (isset($_POST['index'])) ? $_POST['index'] : '';

    if($action_name == 'edit') {
        $data['action'] = 'edit';
        $data['index'] = $index;
    } else if($action_name == 'delete') {
        $data['action'] = 'delete';
        $data['index'] = $index;
    } else {
        $data['error'] = "Erro no nome da ação";
    }

    die(json_encode($data));
?>