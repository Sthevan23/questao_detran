<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_login();

$uid = auth_id();
$stmt = db()->prepare('SELECT nome, email FROM usuarios WHERE id = ?');
$stmt->execute([$uid]);
$user = $stmt->fetch();
$erro = null;
$ok = null;

if (is_post()) {
    csrf_verify();
    $acao = $_POST['acao'] ?? 'perfil';
    if ($acao === 'perfil') {
        $nome = trim($_POST['nome'] ?? '');
        if ($nome === '') {
            $erro = 'Informe seu nome.';
        } else {
            db()->prepare('UPDATE usuarios SET nome = ? WHERE id = ?')->execute([$nome, $uid]);
            $_SESSION['user']['nome'] = $nome;
            $user['nome'] = $nome;
            $ok = 'Perfil atualizado.';
        }
    } elseif ($acao === 'senha') {
        $atual = $_POST['senha_atual'] ?? '';
        $nova = $_POST['senha_nova'] ?? '';
        $nova2 = $_POST['senha_nova2'] ?? '';
        $hash = db()->prepare('SELECT senha_hash FROM usuarios WHERE id = ?');
        $hash->execute([$uid]);
        $row = $hash->fetch();
        if (!$row || !password_verify($atual, $row['senha_hash'])) {
            $erro = 'Senha atual incorreta.';
        } elseif (strlen($nova) < 8) {
            $erro = 'Nova senha deve ter no mínimo 8 caracteres.';
        } elseif ($nova !== $nova2) {
            $erro = 'Confirmação não confere.';
        } else {
            db()->prepare('UPDATE usuarios SET senha_hash = ? WHERE id = ?')->execute([password_hash($nova, PASSWORD_DEFAULT), $uid]);
            $ok = 'Senha alterada.';
        }
    }
}

$painelCss = true;
$pageTitle = 'Perfil — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php aluno_sidebar('perfil'); ?>
    <div class="painel-content">
        <h1>Meu perfil</h1>
        <?php if ($erro): ?><div class="alert alert-error"><?= e($erro) ?></div><?php endif; ?>
        <?php if ($ok): ?><div class="alert alert-success"><?= e($ok) ?></div><?php endif; ?>

        <div class="card" style="margin-bottom:1.5rem;">
            <h2>Dados pessoais</h2>
            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="acao" value="perfil">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required value="<?= e($user['nome']) ?>">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" value="<?= e($user['email']) ?>" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>

        <div class="card">
            <h2>Alterar senha</h2>
            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="acao" value="senha">
                <div class="form-group">
                    <label for="senha_atual">Senha atual</label>
                    <input type="password" id="senha_atual" name="senha_atual" required>
                </div>
                <div class="form-group">
                    <label for="senha_nova">Nova senha</label>
                    <input type="password" id="senha_nova" name="senha_nova" required minlength="8">
                </div>
                <div class="form-group">
                    <label for="senha_nova2">Confirmar nova senha</label>
                    <input type="password" id="senha_nova2" name="senha_nova2" required minlength="8">
                </div>
                <button type="submit" class="btn btn-primary">Atualizar senha</button>
            </form>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
