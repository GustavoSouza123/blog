<?php include 'header.php'; ?>

<?php
    if(isset($_GET['id'])) {
        $sql = $pdo->prepare("SELECT * FROM `tb_posts` WHERE id = ?");
        $sql->execute(array($_GET['id']));
        $post = $sql->fetch(PDO::FETCH_ASSOC);

        $sql = $pdo->prepare("SELECT * FROM `tb_admin_users` WHERE id = ?");
        $sql->execute(array($post['author_id']));
        $author = $sql->fetch(PDO::FETCH_ASSOC);

        $sql = $pdo->prepare("SELECT * FROM `tb_categories` WHERE id = ?");
        $sql->execute(array($post['category_id']));
        $category = $sql->fetch(PDO::FETCH_ASSOC);

        $creation = strtotime($post['creation_date']);
        if($activeLanguage == 'en') {
            $post['creation_date'] = date('F j, Y', $creation);
        } else if($activeLanguage == 'pt-br') {
            $post['creation_date'] = date('d/m/Y', $creation);
        }
    }
?>

<main class="article">
    <div class="content">
        <h1 class="title"><?= $post['title']; ?></h1>
        <div class="thumbnail"><img src="<?= INCLUDE_PATH_ADMIN.$post['thumbnail']; ?>" alt="Post thumbnail" /></div>
        <div class="post-info">
            <div class="post-info-content">
                <div class="info"><img src="<?= INCLUDE_PATH_ADMIN.$author['profile_photo']; ?>" alt="Foto de perfil do autor" /><?= $author['name']; ?></div>
                <span></span>
                <div class="creation"><span><?= $post['creation_date']; ?></span></div>
                <span></span>
                <div class="read-time"><?= $post['read_time'].' '.$content->articleReadTime ?></div>
                <span></span>
                <div class="category"><a href="<?= INCLUDE_PATH ?>?category=<?= $category['name'] ?>"><?= $category['name'] ?></a></div>
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
