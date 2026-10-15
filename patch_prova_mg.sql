-- Aplicar em bancos já existentes (phpMyAdmin)
USE `aprova_cnh`;

UPDATE `simulados` SET
  `nome` = 'Prova teórica DETRAN-MG',
  `qtd_questoes` = 30,
  `duracao_minutos` = 40,
  `pontuacao_minima` = 67
WHERE `tipo` = 'geral' LIMIT 1;

INSERT INTO `configuracoes` (`chave`, `valor`) VALUES
('mg_qtd_questoes', '30'),
('mg_acertos_minimos', '20')
ON DUPLICATE KEY UPDATE `valor` = VALUES(`valor`);
