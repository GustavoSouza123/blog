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
        <h1><?= $post['title']; ?></h1>
        <div class="thumbnail"><img src="<?= INCLUDE_PATH_ADMIN.$post['thumbnail']; ?>" alt="Post thumbnail" /></div>
        <div class="post-info">
            <div class="post-info-content">
                <div class="info"><img src="<?= INCLUDE_PATH_ADMIN.$author['profile_photo']; ?>" alt="Foto de perfil do autor" /><?= $author['name']; ?></div>
                <span></span>
                <div class="creation">Publicado em: <span><?= $post['creation_date']; ?></span></div>
            </div>
        </div>
        <div class="post">
            <div class="post-content">
                <?= $post['post']; ?>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
