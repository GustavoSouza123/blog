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
            for($i = 0; $i < 12; $i++)  {
        ?>
            <div class="post">
                <div class="category">HTML</div>
                <div class="image">
                    <img src="../admin/assets/uploads/repositorio local e remoto.png" alt="" />
                </div>
                <div class="creation-date">07/11/2023</div>
                <div class="title">My first blog post about HTML tips and tricks</div>
                <div class="subtitle">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem ipsum dolor sit amet.</div>
                <!-- <div class="author"> -->
                <!--     <div class="author-photo"> -->
                <!--         <img src="../admin/assets/uploads/profile photo.jpg" alt="Foto do autor da postagem" /> -->
                <!--     </div> -->
                <!--     <div class="info"> -->
                <!--         <div class="name">Gustavo Souza</div> -->
                <!--         <div class="creation-date">07/11/2023</div> -->
                <!--     </div> -->
                <!-- </div> -->
                <div class="read-more">Ler mais</div>
            </div>
        <?php
            }
        ?>


        </div>

    </section>
</main>
