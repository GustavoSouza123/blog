<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Descrição do meu website"> <!-- seo -->
    <meta name="keywords" content="palavras,chave,do,meu,website"> <!-- seo -->
    <link rel="icon" type="image/x-icon" href=""> <!-- website icon -->
    <link href="<?= INCLUDE_PATH; ?>assets/css/standard.css" rel="stylesheet"> <!-- standard css file --> 
    <link href="<?= INCLUDE_PATH; ?>assets/css/404.css" rel="stylesheet"> <!-- 404 css file -->
    <title>Erro 404</title> <!-- title -->
</head>
<body>
    <h1>Erro 404</h1>
    <h3>Página não encontrada</h2>
    <a href="<?= INCLUDE_PATH_ADMIN; ?>">Ir para a página principal</a>
</body>
</html>
