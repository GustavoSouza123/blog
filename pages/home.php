<?php include 'header.php'; ?>

<?php
    $currentCategory = isset($_GET['category']) ? $_GET['category'] : '%%';
?>

<main class="blog">
    <div class="content">
        <section class="posts">
            <h1 class="title"><?= $content->blogTitle ?></h1>
            <div class="categories">
                <div class="category <?php if(!isset($_GET['category'])) echo 'active'; ?>"><a href="<?= INCLUDE_PATH ?>"><?= $content->allPosts ?></a></div>
                <?php
                    $sql = $pdo->prepare("SELECT * FROM `tb_categories`");
                    $sql->execute();
                    $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
                    foreach($categories as $key => $value) {
                        $active = $currentCategory == $value['name'] ? 'active' : '';
                        echo '
                        <div class="category '.$active.'"><a href="'.INCLUDE_PATH.'?category='.$value['name'].'">'.$value['name'].'</a></div>
                        ';
                    }
                ?>
            </div>
            <div class="posts-content">
            <?php
                $sql = $pdo->prepare("SELECT p.*, c.name FROM `tb_posts` AS `p` INNER JOIN `tb_categories` AS `c` ON p.category_id = c.id WHERE c.name LIKE ? AND p.published = 1");
                $sql->execute(array($currentCategory));
                if($sql->rowCount() == 0) {
                    echo 'Nenhum post encontrado';
                } else {
                    $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                    foreach($posts as $key => $value) {
                        $sql = $pdo->prepare("SELECT `name` FROM `tb_categories` WHERE id = ?");
                        $sql->execute(array($value['category_id']));
                        $category = $sql->fetchColumn();
                        echo '
                        <div class="post">
                            <div class="image">
                                <img src="'.INCLUDE_PATH_ADMIN.$value['thumbnail'].'" alt="" />
                            </div>
                            <div class="content">
                                <div class="title">'.$value['title'].'</div>
                                <div class="subtitle">'.$value['subtitle'].'</div>
                                <div class="read-more"><a href="article?id='.$value['id'].'">Ler mais</a></div>
                                <div class="category"><a href="'.INCLUDE_PATH.'?category='.$category.'">'.$category.'</a></div>
                            </div>
                        </div>
                        ';
                    }
                }
            ?>
            </div>
        </section>
    </div>
</main>

<?php include 'footer.php'; ?>
