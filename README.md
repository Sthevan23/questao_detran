# questao_detran

# Aprova CNH — Simulados DETRAN (PHP)

Plataforma leve de simulados para prova teórica do DETRAN: PHP 8.1+, MySQL/MariaDB, HTML5, CSS3 e JavaScript puro (Fetch API apenas no simulado).

## Requisitos

- PHP 8.1 ou superior (extensões: `pdo_mysql`, `session`, `fileinfo`)
- MySQL 5.7+ ou MariaDB 10.3+
- Apache com `mod_rewrite` (opcional) ou nginx
- Hospedagem compartilhada com cPanel (sem Node.js)

## Estrutura

```
questao_detran/           # Raiz = pasta public_html na Hostinger (auto-deploy Git)
├── index.php
├── simulados.php
├── config/               # database.php (local, não vai no Git)
├── includes/
├── assets/
├── database.sql
├── seed_100_questoes_mg.sql
└── scripts/
```

## Instalação no cPanel

1. **Banco de dados:** cPanel → MySQL® Databases → crie o banco (ex.: `usuario_aprovacnh`).
2. **Usuário MySQL:** crie usuário, senha forte e associe **ALL PRIVILEGES** ao banco.
3. **Importar SQL:** phpMyAdmin → Importar → `database.sql`.
4. **Questões de treinamento:** importe **`seed_100_questoes_mg.sql`** (100 questões autorais DETRAN-MG). Opcional: `seed_treinamento_mg.sql` / `seed_questoes.sql`.
5. **Carga idempotente (alternativa):** na hospedagem, `php scripts/carga_100_questoes.php` — ignora enunciados duplicados.
6. **Configuração:** edite `config/database.php` no servidor (copie de `database.example.php`).
7. **Git Hostinger:** deploy da branch `main` direto em `public_html` (raiz do repo = site).
8. **Permissões:** pasta `uploads/` gravável pelo PHP.
9. **HTTPS:** ative SSL no cPanel.
10. **Ativação:** acesse `/install.php` uma vez (só confirma o banco) ou use site direto se `instalado=1`.
11. **Testes:** modo estudo, simulado e resultado.

## Uso

| Área | URL |
|------|-----|
| Site | `/index.php` |
| Modo estudo | `/estudo.php` (feedback imediato; não exige login) |
| Simulados | `/simulados.php` (sem login) |
| Aluno | `/aluno/index.php` |
| Admin | `/admin/index.php` |

- Cadastro público cria apenas perfil **aluno**.
- Administradores só via `install.php` (primeiro acesso).
- Correção das respostas é feita no **servidor** ao finalizar; alternativas corretas não são expostas durante o simulado.

## Importação CSV (admin)

Colunas: `categoria_slug;enunciado;alt_a;alt_b;alt_c;alt_d;correta;explicacao`

Slugs de categoria: `legislacao`, `placas`, `direcao-defensiva`, `primeiros-socorros`, `meio-ambiente`, `mecanica`, `infracoes`, `circulacao`.

## Desenvolvimento local

1. Coloque o projeto em um virtual host apontando para `public_html`.
2. Importe `database.sql` e configure `config/database.php`.
3. Acesse `/install.php`.

## Produção

- Minifique `assets/css/*.css` e `assets/js/*.js` se desejar.
- Não commite `config/database.php` com senhas reais (use `.gitignore`).

## Estudo para DETRAN-MG

- **Modo estudo** (`estudo.php`): após marcar uma alternativa, o sistema mostra gabarito e explicação (correção via API no servidor).
- **Simulado**: permanece cronometrado, com resultado, percentual e revisão — sem exibir gabarito durante a prova.
- Regra divulgada pelo [Portal MG](https://www.mg.gov.br/servico/obter-1a-habilitacao-cnh-ou-acc): prova com **30 questões**, aprovação com **≥ 20 acertos**. O seed MG ajusta o simulado geral para refletir isso (67% de mínimo).
- Todas as questões do seed são **treinamento autoral**, identificadas no campo referência — não são oficiais.

## Aviso legal

Conteúdo educacional independente. Não representa o DETRAN-MG. Utilize questões autorais ou com autorização de uso.
