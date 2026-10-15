<?php
declare(strict_types=1);
$pagina = pagina_atual();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Simulados para a prova teórica do DETRAN-MG.">
    <title><?= e($pageTitle ?? site_nome()) ?></title>
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
</head>
<body>
<a class="skip-link" href="#conteudo">Ir para o conteúdo</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="logo" href="<?= e(url('estudo.php')) ?>">
            <span class="logo-mark" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"><circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2"/><path d="M10 17h12M16 11v12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <span class="logo-text"><?= e(site_nome()) ?></span>
        </a>
        <button type="button" class="nav-toggle" aria-expanded="false" aria-controls="menu-principal" data-nav-toggle>
            <span class="nav-toggle-bar"></span>
            <span class="sr-only">Menu</span>
        </button>
        <nav id="menu-principal" class="nav-main" data-nav>
            <a href="<?= e(url('estudo.php')) ?>" class="<?= $pagina === 'estudo.php' ? 'active' : '' ?>">Treinar</a>
            <a href="<?= e(url('simulados.php')) ?>" class="<?= in_array($pagina, ['simulados.php', 'simulado.php', 'resultado.php'], true) ? 'active' : '' ?>">Simulado</a>
            <a href="<?= e(url('historico.php')) ?>" class="<?= $pagina === 'historico.php' ? 'active' : '' ?>">Progresso</a>
        </nav>
    </div>
</header>
<main id="conteudo" class="site-main">
