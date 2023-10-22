<?php
    try {
        $pdo = new PDO('mysql:host='.HOST, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS `".DATABASE."`;
                USE `".DATABASE."`;
                CREATE TABLE IF NOT EXISTS `tb_admin_users` (
                    id INT NOT NULL AUTO_INCREMENT,
                    user VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id)
                );
                CREATE TABLE IF NOT EXISTS `tb_categories` (
                    id INT NOT NULL AUTO_INCREMENT,
                    name VARCHAR(255) NOT NULL,
                    image VARCHAR(255) NOT NULL,
                    PRIMARY KEY (id)
                );
                CREATE TABLE IF NOT EXISTS `tb_posts` (
                    id INT NOT NULL AUTO_INCREMENT,
                    category_id INT NOT NULL,
                    thumbnail VARCHAR(255) NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    subtitle VARCHAR(255) NOT NULL,
                    post LONGTEXT NOT NULL,
                    creation_date DATETIME NOT NULL,
                    last_update DATETIME NOT NULL,
                    read_time VARCHAR(10) NOT NULL,
                    PRIMARY KEY (id),
                    FOREIGN KEY (category_id) REFERENCES tb_categories(id)
                );";
                // INSERT INTO `tb_admin_users` VALUES (null, 'admin', '1234', 'Gustavo Souza')
        $pdo->exec($sql);
    } catch(PDOException $e) {
        echo '<h2>Erro ao conectar no banco de dados.</h2>'.$e->getMessage();
    }
?>
