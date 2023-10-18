<?php
    try {
        $pdo = new PDO('mysql:host='.HOST, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS `".DATABASE."`;
                USE `".DATABASE."`;
                CREATE TABLE IF NOT EXISTS `tb_admin_users` (
                    id INT NOT NULL AUTO_INCREMENT,
                    user VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id)
                );";
        $pdo->exec($sql);
    } catch(PDOException $e) {
        echo '<h2>Erro ao conectar no banco de dados.</h2>'.$e->getMessage();
    }
?>