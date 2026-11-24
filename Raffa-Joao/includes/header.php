<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);
$nomeBase = pathinfo($paginaAtual, PATHINFO_FILENAME);
$cssEspecifico = "css/{$nomeBase}.css";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffa &amp; João | Presente de Casamento</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Fontes Elegantes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Base (cores, fontes, navbar, botões e footer) -->
    <link rel="stylesheet" href="css/index.css?v=<?= filemtime('css/index.css') ?>">

    <!-- CSS Específico da Página (carrega css/casamento.css quando estiver em casamento.php) -->
    <?php if ($nomeBase !== 'index' && file_exists($cssEspecifico)): ?>
        <link rel="stylesheet" href="<?= $cssEspecifico ?>?v=<?= filemtime($cssEspecifico) ?>">
    <?php endif; ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-casamento sticky-top">
        <div class="container">
            <!-- Espaço da Logo -->
            <a class="navbar-brand" href="index.php">
                <div class="logo-box" title="Salve sua logo em img/logo.png">
                    <?php if (file_exists('img/logo.png')): ?>
                        <img src="img/logo.png" alt="Logo Raffa & João">
                    <?php else: ?>
                        <span class="fonte-serif fs-4 fw-bold" style="color: var(--verde-oliva-escuro);">
                            <i class="bi bi-flower1 me-2"></i>R &amp; J
                        </span>
                    <?php endif; ?>
                </div>
            </a>

            <!-- Botão Responsivo Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuCasamento" aria-controls="menuCasamento" aria-expanded="false" aria-label="Abrir menu">
                <i class="bi bi-list fs-1" style="color: var(--verde-oliva-escuro);"></i>
            </button>

            <!-- Links de Navegação -->
            <div class="collapse navbar-collapse justify-content-end" id="menuCasamento">
                <ul class="navbar-nav align-items-center gap-1 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'index.php' ? 'active' : '' ?>" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'pre-wedding.php' ? 'active' : '' ?>" href="wedding.php">Pré-Wedding</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'padrinhos.php' ? 'active' : '' ?>" href="padrinhos.php">Vídeos dos Padrinhos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $paginaAtual === 'casamento.php' ? 'active' : '' ?>" href="casamento.php">Casamento</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>