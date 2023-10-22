<?php
    require '../config/config.php';
    $data = array();

    $sql = $pdo->prepare("SELECT * FROM `tb_categories`");
    $sql->execute();
    if($sql->rowCount() > 0) {
        $data['categories'] = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $data['error'] = "Nenhuma categoria cadastrada";
    }
    die(json_encode($data));
?>
