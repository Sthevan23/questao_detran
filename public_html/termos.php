<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Termos de uso — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container section">
    <h1>Termos de uso</h1>
    <p>A plataforma <?= e(site_nome()) ?> é independente do DETRAN. O conteúdo tem fins educacionais. Ao utilizar o site, você concorda em não reproduzir materiais sem autorização.</p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
