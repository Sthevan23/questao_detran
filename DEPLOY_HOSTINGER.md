# Auto-deploy Hostinger + GitHub

A **raiz do repositório** é a pasta pública do site (`index.php`, `includes/`, etc.).

1. hPanel → **Git** → repositório `Sthevan23/questao_detran` → branch `main` → deploy em `public_html`.
2. Após o pull, crie **`config/database.php`** no servidor (não vai no Git):

```php
<?php
return [
    'host'     => 'localhost',
    'dbname'   => 'u586160337_detran',
    'username' => 'u586160337_detran',
    'password' => 'SUA_SENHA',
    'charset'  => 'utf8mb4',
];
```

3. MySQL: importe `database.sql` e `seed_100_questoes_mg.sql` (banco já selecionado).
4. Teste: `/simulados.php`
