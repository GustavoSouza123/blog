<header>
    <div class="content">
        <nav class="register">
        <?php if(Panel::isLogged()) { ?>
            <ul class="profile">
                <a href="<?php echo INCLUDE_PATH_ADMIN; ?>">
                    <div class="profile-photo">
                        <img src="<?php echo INCLUDE_PATH_ADMIN.$_SESSION['myblog-profile-photo']; ?>" alt="Foto de perfil" />
                    </div>
                    <div class="profile-name"><?php echo $_SESSION['myblog-name']; ?></div>
                </a>
            </ul>
        <?php } else { ?>
            <ul class="register">
                <li><a href="<?php echo INCLUDE_PATH_ADMIN; ?>login">Entrar</a></li>
                <li><a href="<?php echo INCLUDE_PATH_ADMIN; ?>signup">Cadastrar</a></li>
            </ul>
        <?php } ?>
        </nav>
    </div>
</header>

<main>
    <section class="posts">
        <h1 class="title">Meus últimos posts</h1>

        <div class="posts-content">
            <?php
                $sql = $pdo->prepare("SELECT * FROM `tb_posts` WHERE published = 1");
                $sql->execute();
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
                            <div class="category">'.$category.'</div>
                            <div class="title">'.$value['title'].'</div>
                            <div class="subtitle">'.$value['subtitle'].'</div>
                            <div class="read-more"><a href="article?id='.$value['id'].'">Ler mais</a></div>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>

    </section>
</main>
