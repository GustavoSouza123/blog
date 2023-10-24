<?php
    require '../config/config.php';
    $data = [];
    $form_name = (isset($_POST['formName'])) ? $_POST['formName'] : '';

    $data['formName'] = $form_name;
    die(json_encode($data));
?>