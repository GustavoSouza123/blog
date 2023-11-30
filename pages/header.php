<header>
    <div class="content">
        <div class="social">
            <a href="https://github.com/GustavoSouza123" target="_blank"><img src="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/images/github.svg" alt="Github logo" /></a>
            <a href="https://www.linkedin.com/in/gustavo-souza-316003272/" target="_blank"><img src="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/images/linkedin.svg" alt="LinkedIn logo" /></a>
            <a href="https://twitter.com/gustavosouza456" target="_blank"><img src="<?= INCLUDE_PATH_PORTFOLIO; ?>assets/images/twitter.svg" alt="Twitter logo" /></a>
        </div>
        <nav class="blog">
            <div class="languages">
                <div language="en" <?php if($_COOKIE['activeLanguage'] == 'en') echo 'class="active"'; ?>>EN</div>
                <div language="pt-br" <?php if($_COOKIE['activeLanguage'] == 'pt-br') echo 'class="active"'; ?>>PT-BR</div>
            </div>
            <ul>
                <li><a href="<?= INCLUDE_PATH_PORTFOLIO ?>"><?= $content->nav1 ?></a></li>
                <li><a href="<?= INCLUDE_PATH ?>" class="active" ><?= $content->nav4 ?></a></li>
            </ul>
        </nav> 
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>
