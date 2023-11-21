<?php include 'header.php'; ?>

<main class="article">
    <div class="content">
    <?php
        if(isset($_GET['id'])) {
            $sql = $pdo->prepare("SELECT * FROM `tb_posts` WHERE id = ?");
            $sql->execute(array($_GET['id']));
            $post = $sql->fetch(PDO::FETCH_ASSOC);
            echo '<div class="thumbnail"><img src="'.INCLUDE_PATH_ADMIN.$post['thumbnail'].'" alt="Post thumbnail" /></div>';
            echo $post['post'];
        }
    ?>
    </div>
</main>