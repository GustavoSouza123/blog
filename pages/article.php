<?php include 'header.php'; ?>

<?php
    if(isset($_GET['id'])) {
        $sql = $pdo->prepare("SELECT * FROM `tb_posts` WHERE id = ?");
        $sql->execute(array($_GET['id']));
        $post = $sql->fetch(PDO::FETCH_ASSOC);

        $sql = $pdo->prepare("SELECT * FROM `tb_admin_users` WHERE id = ?");
        $sql->execute(array($post['author_id']));
        $author = $sql->fetch(PDO::FETCH_ASSOC);

        $creation = strtotime($post['creation_date']);
        $post['creation_date'] = date('d/m/Y H:i a', $creation);
    }
?>

<main class="article">
    <div class="content">
        <h1><?php echo $post['title']; ?></h1>
        <div class="thumbnail"><img src="<?php echo INCLUDE_PATH_ADMIN.$post['thumbnail']; ?>" alt="Post thumbnail" /></div>
        <div class="post-info">
            <div class="info"><img src="<?php echo INCLUDE_PATH_ADMIN.$author['profile_photo']; ?>" alt="Foto de perfil do autor" /><?php echo $author['name']; ?></div>
            <span></span>
            <div class="creation">Publicado em: <span><?php echo $post['creation_date']; ?></span></div>
        </div>
        <div class="post">
            <?php echo $post['post']; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
