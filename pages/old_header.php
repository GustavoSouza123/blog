<header>
    <div class="content">
        <nav class="register">
        <?php if(Panel::isLogged()) { ?>
            <ul class="profile">
                <a href="<?= INCLUDE_PATH_ADMIN; ?>">
                    <div class="profile-photo">
                        <img src="<?= INCLUDE_PATH_ADMIN.$_SESSION['myblog-profile-photo']; ?>" alt="Foto de perfil" />
                    </div>
                    <div class="profile-name"><?= $_SESSION['myblog-name']; ?></div>
                </a>
            </ul>
        <?php } else { ?>
            <ul class="register">
                <li><a href="<?php //echo INCLUDE_PATH_ADMIN; ?>login">Entrar</a></li>
                <li><a href="<?php //echo INCLUDE_PATH_ADMIN; ?>signup">Cadastrar</a></li>
            </ul>
        <?php } ?>
        </nav>
    </div>
</header>
