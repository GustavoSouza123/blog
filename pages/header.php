<!-- <header>
    <div class="content">
        <nav class="register">
        <?php //if(Panel::isLogged()) { ?>
            <ul class="profile">
                <a href="<?php //echo INCLUDE_PATH_ADMIN; ?>">
                    <div class="profile-photo">
                        <img src="<?php //echo INCLUDE_PATH_ADMIN.$_SESSION['myblog-profile-photo']; ?>" alt="Foto de perfil" />
                    </div>
                    <div class="profile-name"><?php //echo $_SESSION['myblog-name']; ?></div>
                </a>
            </ul>
        <?php //} else { ?>
            <ul class="register">
                <li><a href="<?php //echo INCLUDE_PATH_ADMIN; ?>login">Entrar</a></li>
                <li><a href="<?php //echo INCLUDE_PATH_ADMIN; ?>signup">Cadastrar</a></li>
            </ul>
        <?php //} ?>
        </nav>
    </div>
</header> -->

<header>
    <div class="social">
        <a href="https://github.com/GustavoSouza123" target="_blank"><img src="<?php echo INCLUDE_PATH_PORTFOLIO; ?>assets/images/github.svg" alt="Github logo" /></a>
        <a href="https://www.linkedin.com/in/gustavo-souza-316003272/" target="_blank"><img src="<?php echo INCLUDE_PATH_PORTFOLIO; ?>assets/images/linkedin.svg" alt="LinkedIn logo" /></a>
        <a href="https://twitter.com/gustavosouza456" target="_blank"><img src="<?php echo INCLUDE_PATH_PORTFOLIO; ?>assets/images/twitter.svg" alt="Twitter logo" /></a>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo INCLUDE_PATH_PORTFOLIO; ?>">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Projects</a></li>
            <li><a class="active" href="">Blog</a></li>
            <li><a href="">Contact</a></li>
        </ul>
    </nav> 
    <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>