</main>
<footer class="site-footer">
    <div class="container footer-bottom">
        <p><strong><?= e(site_nome()) ?></strong> — treinamento para prova teórica DETRAN-MG. Plataforma independente, sem vínculo oficial.</p>
        <p>&copy; <?= date('Y') ?> · Questões de treinamento autoral</p>
    </div>
</footer>
<script src="<?= e(url('assets/js/app.js')) ?>" defer></script>
<?php if (!empty($extraJs)): ?>
<script src="<?= e(url($extraJs)) ?>" defer></script>
<?php endif; ?>
</body>
</html>
