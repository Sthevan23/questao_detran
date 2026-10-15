-- Aprova CNH - Schema MySQL/MariaDB
-- Charset: utf8mb4

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `aprova_cnh` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `aprova_cnh`;

-- ---------------------------------------------------------------------------
-- Usuários
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `senha_hash` VARCHAR(255) NOT NULL,
  `papel` ENUM('aluno','admin') NOT NULL DEFAULT 'aluno',
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `login_tentativas` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `bloqueado_ate` DATETIME NULL DEFAULT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuarios_email` (`email`),
  KEY `idx_usuarios_papel` (`papel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Categorias
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `slug` VARCHAR(120) NOT NULL,
  `descricao` TEXT NULL,
  `icone` VARCHAR(40) NULL DEFAULT NULL,
  `ordem` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_categorias_slug` (`slug`),
  KEY `idx_categorias_ativo_ordem` (`ativo`, `ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Questões
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `questoes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria_id` INT UNSIGNED NOT NULL,
  `enunciado` TEXT NOT NULL,
  `imagem` VARCHAR(255) NULL DEFAULT NULL,
  `dificuldade` ENUM('facil','medio','dificil') NOT NULL DEFAULT 'medio',
  `explicacao` TEXT NULL,
  `referencia` VARCHAR(255) NULL DEFAULT NULL,
  `autoral` TINYINT(1) NOT NULL DEFAULT 1,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_questoes_categoria_ativo` (`categoria_id`, `ativo`),
  KEY `idx_questoes_dificuldade` (`dificuldade`),
  FULLTEXT KEY `ft_questoes_enunciado` (`enunciado`),
  CONSTRAINT `fk_questoes_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Alternativas (4 por questão; exatamente uma correta)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `alternativas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `questao_id` INT UNSIGNED NOT NULL,
  `letra` CHAR(1) NOT NULL,
  `texto` TEXT NOT NULL,
  `correta` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_alternativas_questao_letra` (`questao_id`, `letra`),
  KEY `idx_alternativas_questao` (`questao_id`),
  CONSTRAINT `fk_alternativas_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Modalidades de simulado (configuração admin)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `simulados` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `tipo` ENUM('geral','categoria') NOT NULL DEFAULT 'geral',
  `categoria_id` INT UNSIGNED NULL DEFAULT NULL,
  `qtd_questoes` SMALLINT UNSIGNED NOT NULL DEFAULT 30,
  `duracao_minutos` SMALLINT UNSIGNED NOT NULL DEFAULT 40,
  `pontuacao_minima` TINYINT UNSIGNED NOT NULL DEFAULT 70,
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_simulados_tipo` (`tipo`),
  CONSTRAINT `fk_simulados_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Tentativas
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tentativas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT UNSIGNED NULL DEFAULT NULL,
  `simulado_id` INT UNSIGNED NOT NULL,
  `categoria_id` INT UNSIGNED NULL DEFAULT NULL,
  `status` ENUM('em_andamento','finalizado','expirado') NOT NULL DEFAULT 'em_andamento',
  `iniciado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finalizado_em` DATETIME NULL DEFAULT NULL,
  `tempo_utilizado_seg` INT UNSIGNED NULL DEFAULT NULL,
  `qtd_acertos` SMALLINT UNSIGNED NULL DEFAULT NULL,
  `qtd_erros` SMALLINT UNSIGNED NULL DEFAULT NULL,
  `percentual` DECIMAL(5,2) NULL DEFAULT NULL,
  `aprovado` TINYINT(1) NULL DEFAULT NULL,
  `token_sessao` VARCHAR(64) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tentativas_usuario` (`usuario_id`, `status`),
  KEY `idx_tentativas_simulado` (`simulado_id`),
  KEY `idx_tentativas_iniciado` (`iniciado_em`),
  CONSTRAINT `fk_tentativas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tentativas_simulado` FOREIGN KEY (`simulado_id`) REFERENCES `simulados` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_tentativas_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Questões sorteadas para cada tentativa (ordem fixa)
CREATE TABLE IF NOT EXISTS `tentativa_questoes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tentativa_id` INT UNSIGNED NOT NULL,
  `questao_id` INT UNSIGNED NOT NULL,
  `ordem` SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_tentativa_questao` (`tentativa_id`, `questao_id`),
  KEY `idx_tentativa_questoes_ordem` (`tentativa_id`, `ordem`),
  CONSTRAINT `fk_tq_tentativa` FOREIGN KEY (`tentativa_id`) REFERENCES `tentativas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tq_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Respostas do aluno
CREATE TABLE IF NOT EXISTS `respostas_tentativas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tentativa_id` INT UNSIGNED NOT NULL,
  `questao_id` INT UNSIGNED NOT NULL,
  `alternativa_id` INT UNSIGNED NULL DEFAULT NULL,
  `marcada_revisao` TINYINT(1) NOT NULL DEFAULT 0,
  `respondido_em` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_resposta_tentativa_questao` (`tentativa_id`, `questao_id`),
  KEY `idx_respostas_alternativa` (`alternativa_id`),
  CONSTRAINT `fk_rt_tentativa` FOREIGN KEY (`tentativa_id`) REFERENCES `tentativas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rt_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_rt_alternativa` FOREIGN KEY (`alternativa_id`) REFERENCES `alternativas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Favoritos
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `favoritos` (
  `usuario_id` INT UNSIGNED NOT NULL,
  `questao_id` INT UNSIGNED NOT NULL,
  `criado_em` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`, `questao_id`),
  KEY `idx_favoritos_questao` (`questao_id`),
  CONSTRAINT `fk_favoritos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_favoritos_questao` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Configurações gerais (chave-valor)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `configuracoes` (
  `chave` VARCHAR(80) NOT NULL,
  `valor` TEXT NULL,
  PRIMARY KEY (`chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Categorias padrão
INSERT INTO `categorias` (`nome`, `slug`, `descricao`, `icone`, `ordem`, `ativo`) VALUES
('Legislação de trânsito', 'legislacao', 'Normas do CTB e responsabilidades do condutor.', 'law', 1, 1),
('Placas e sinalização', 'placas', 'Sinalização vertical, horizontal e semafórica.', 'sign', 2, 1),
('Direção defensiva', 'direcao-defensiva', 'Antecipação de riscos e comportamento seguro.', 'shield', 3, 1),
('Primeiros socorros', 'primeiros-socorros', 'Procedimentos iniciais em emergências no trânsito.', 'heart', 4, 1),
('Meio ambiente e cidadania', 'meio-ambiente', 'Impactos ambientais e convívio no trânsito.', 'leaf', 5, 1),
('Mecânica básica', 'mecanica', 'Noções de funcionamento e manutenção do veículo.', 'gear', 6, 1),
('Infrações e penalidades', 'infracoes', 'Multas, pontos e medidas administrativas.', 'alert', 7, 1),
('Normas de circulação', 'circulacao', 'Ultrapassagem, preferência e velocidade.', 'road', 8, 1);

-- Modalidades de simulado
INSERT INTO `simulados` (`nome`, `tipo`, `categoria_id`, `qtd_questoes`, `duracao_minutos`, `pontuacao_minima`, `ativo`) VALUES
('Prova teórica DETRAN-MG', 'geral', NULL, 30, 40, 67, 1);

INSERT INTO `configuracoes` (`chave`, `valor`) VALUES
('site_nome', 'Aprova CNH'),
('instalado', '1'),
('mg_qtd_questoes', '30'),
('mg_acertos_minimos', '20'),
('max_login_tentativas', '5'),
('bloqueio_minutos', '15');
