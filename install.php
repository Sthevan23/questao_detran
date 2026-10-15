<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$erro = null;
$okDb = false;
$configPath = APP_ROOT . '/config/database.php';

if (config_get('instalado', '0') === '1') {
    try {
        db()->query('SELECT 1');
        redirect(url('simulados.php'));
    } catch (Throwable) {
        // Banco quebrou após instalação — permite reconfigurar
    }
}

function testar_conexao_mysql(string $host, string $dbname, string $user, string $pass): ?string
{
    try {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbname);
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->query('SELECT 1');
        return null;
    } catch (Throwable $e) {
        return $e->getMessage();
    }
}

function salvar_database_php(string $path, array $cfg): bool
{
    $content = "<?php\nreturn " . var_export([
        'host'     => $cfg['host'],
        'dbname'   => $cfg['dbname'],
        'username' => $cfg['username'],
        'password' => $cfg['password'],
        'charset'  => 'utf8mb4',
    ], true) . ";\n";
    return file_put_contents($path, $content) !== false;
}

$defaults = [
    'host'     => 'localhost',
    'dbname'   => 'u586160337_detran',
    'username' => 'u586160337_detran',
    'password' => '',
];

if (is_readable($configPath)) {
    $cur = require $configPath;
    if (is_array($cur)) {
        $defaults = array_merge($defaults, $cur);
    }
}

if (is_post()) {
    csrf_verify();
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'salvar_db') {
        $defaults['host'] = trim($_POST['host'] ?? 'localhost');
        $defaults['dbname'] = trim($_POST['dbname'] ?? '');
        $defaults['username'] = trim($_POST['username'] ?? '');
        $defaults['password'] = (string) ($_POST['password'] ?? '');

        if ($defaults['dbname'] === '' || $defaults['username'] === '') {
            $erro = 'Preencha banco e usuário MySQL.';
        } else {
            $teste = testar_conexao_mysql(
                $defaults['host'],
                $defaults['dbname'],
                $defaults['username'],
                $defaults['password']
            );
            if ($teste !== null) {
                $erro = 'Conexão recusada: ' . $teste;
            } elseif (!is_dir(dirname($configPath)) || !is_writable(dirname($configPath))) {
                $erro = 'A pasta config/ não tem permissão de escrita. Crie config/database.php manualmente pelo Gerenciador de arquivos.';
            } elseif (!salvar_database_php($configPath, $defaults)) {
                $erro = 'Não foi possível gravar config/database.php.';
            } else {
                $okDb = true;
                try {
                    db()->query('SELECT 1');
                } catch (Throwable $e) {
                    $erro = 'Arquivo salvo, mas a conexão falhou: ' . $e->getMessage();
                    $okDb = false;
                }
            }
        }
    } elseif ($acao === 'finalizar' && !$erro) {
        try {
            db()->query('SELECT 1');
            db()->prepare('INSERT INTO configuracoes (chave, valor) VALUES ("instalado", "1") ON DUPLICATE KEY UPDATE valor = "1"')->execute();
            redirect(url('simulados.php'));
        } catch (Throwable $e) {
            $erro = 'Conecte o banco antes de continuar. Detalhe: ' . $e->getMessage();
        }
    }
}

if (!$okDb && !$erro) {
    try {
        db()->query('SELECT 1');
        $okDb = true;
    } catch (Throwable $e) {
        if (!is_readable($configPath)) {
            $erro = 'Crie a conexão MySQL abaixo (o arquivo config/database.php ainda não existe no servidor).';
        } else {
            $erro = 'Não conectou ao MySQL. Confira usuário, senha e se importou database.sql no phpMyAdmin.';
        }
    }
}

$pageTitle = 'Configuração — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container">
    <div class="form-card" style="max-width:480px;">
        <h1>Quase pronto</h1>
        <p class="text-muted">Informe os dados do MySQL da Hostinger (hPanel → Bancos de dados). Não é necessário cadastro de aluno.</p>

        <?php if ($erro): ?><div class="alert alert-error"><?= e($erro) ?></div><?php endif; ?>
        <?php if ($okDb): ?><div class="alert alert-success">Conexão com o banco OK.</div><?php endif; ?>

        <?php if (!$okDb): ?>
        <form method="post" data-loading>
            <?= csrf_field() ?>
            <input type="hidden" name="acao" value="salvar_db">
            <div class="form-group">
                <label for="host">Host MySQL</label>
                <input type="text" id="host" name="host" required value="<?= e($defaults['host']) ?>">
                <p class="form-hint">Na Hostinger use <strong>localhost</strong> (ou o host que aparecer no hPanel).</p>
            </div>
            <div class="form-group">
                <label for="dbname">Nome do banco</label>
                <input type="text" id="dbname" name="dbname" required value="<?= e($defaults['dbname']) ?>">
            </div>
            <div class="form-group">
                <label for="username">Usuário MySQL</label>
                <input type="text" id="username" name="username" required value="<?= e($defaults['username']) ?>">
            </div>
            <div class="form-group">
                <label for="password">Senha MySQL</label>
                <input type="password" id="password" name="password" value="<?= e($defaults['password']) ?>" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Testar e salvar conexão</button>
        </form>
        <?php else: ?>
        <form method="post" data-loading style="margin-top:1rem;">
            <?= csrf_field() ?>
            <input type="hidden" name="acao" value="finalizar">
            <button type="submit" class="btn btn-primary" style="width:100%;">Ir para os simulados</button>
        </form>
        <?php endif; ?>

        <p class="form-hint" style="margin-top:1.25rem;">Antes disso, no phpMyAdmin importe <strong>database.sql</strong> e <strong>seed_100_questoes_mg.sql</strong> com o banco selecionado.</p>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
