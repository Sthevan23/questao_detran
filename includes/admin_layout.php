<?php
declare(strict_types=1);

function aluno_sidebar(string $active): void
{
    $links = [
        'index' => ['aluno/index.php', 'Resumo'],
        'historico' => ['aluno/historico.php', 'Histórico'],
        'favoritos' => ['aluno/favoritos.php', 'Favoritos'],
        'erradas' => ['aluno/erradas.php', 'Questões erradas'],
        'perfil' => ['aluno/perfil.php', 'Perfil'],
    ];
    echo '<aside class="painel-sidebar"><nav>';
    foreach ($links as $key => [$href, $label]) {
        $cls = $key === $active ? ' class="active"' : '';
        echo '<a href="' . e(url($href)) . '"' . $cls . '>' . e($label) . '</a>';
    }
    echo '</nav></aside>';
}

function admin_sidebar(string $active): void
{
    $links = [
        'index' => ['admin/index.php', 'Dashboard'],
        'questoes' => ['admin/questoes.php', 'Questões'],
        'categorias' => ['admin/categorias.php', 'Categorias'],
        'simulados' => ['admin/simulados.php', 'Simulados'],
        'usuarios' => ['admin/usuarios.php', 'Alunos'],
        'tentativas' => ['admin/tentativas.php', 'Histórico'],
        'configuracoes' => ['admin/configuracoes.php', 'Configurações'],
        'importar' => ['admin/importar.php', 'Importar CSV'],
    ];
    echo '<aside class="painel-sidebar"><nav>';
    foreach ($links as $key => [$href, $label]) {
        $cls = $key === $active ? ' class="active"' : '';
        echo '<a href="' . e(url($href)) . '"' . $cls . '>' . e($label) . '</a>';
    }
    echo '</nav></aside>';
}
