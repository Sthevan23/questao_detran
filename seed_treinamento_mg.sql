-- Questões de TREINAMENTO autoral — prova teórica DETRAN-MG
-- Importe após database.sql (e opcionalmente seed_questoes.sql)
-- Referência: CTB (Lei 9.503/1997), Res. CONTRAN, Portal MG (30 questões, mín. 20 acertos)

-- Banco já selecionado no phpMyAdmin antes de importar.

SET @ref = 'Questão de treinamento autoral. Base: CTB e CONTRAN. Estudo para DETRAN-MG. Não é questão oficial de prova.';

-- Ajuste opcional do simulado geral à regra divulgada para MG (30 questões, ~67% = 20 acertos)
UPDATE `simulados` SET `qtd_questoes` = 30, `pontuacao_minima` = 67, `duracao_minutos` = 40 WHERE `tipo` = 'geral' LIMIT 1;

-- ========== 1 Legislação de trânsito ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O Código de Trânsito Brasileiro (CTB) estabelece que o trânsito, em condições seguras, é um direito de todos e um dever de:', 'facil', 'O CTB define princípios gerais: direitos e deveres compartilhados por condutores, pedestres e demais usuários da via.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Somente dos condutores',0),(@q,'B','Dos órgãos de trânsito apenas',0),(@q,'C','De todos os cidadãos',1),(@q,'D','Apenas das autoescolas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Conduzir veículo sem possuir CNH ou Permissão para Dirigir (PPD), quando exigido, é infração classificada como:', 'medio', 'Dirigir sem habilitação adequada é infração gravíssima, sujeita a penalidades previstas no CTB.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O uso do cinto de segurança pelos ocupantes do veículo, nos assentos onde houver dispositivo, é:', 'facil', 'O cinto é obrigatório para condutor e passageiros nos bancos equipados, salvo exceções legais específicas.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Opcional em vias urbanas',0),(@q,'B','Obrigatório conforme o CTB',1),(@q,'C','Proibido em carros com airbag',0),(@q,'D','Obrigatório só em rodovias',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Em Minas Gerais, o agendamento da prova teórica de legislação é realizado pelo candidato conforme orientação do DETRAN-MG, comparecendo no local e data marcados com:', 'medio', 'O Portal MG orienta levar documento de identificação com foto para realizar a prova agendada.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas comprovante de residência',0),(@q,'B','Documento de identificação com foto',1),(@q,'C','Certidão de casamento',0),(@q,'D','CNH definitiva',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Segundo regra geral do exame teórico (CONTRAN), a prova possui, no mínimo, 30 questões e exige aproveitamento mínimo de 70% — o que corresponde a:', 'medio', '70% de 30 questões = 21 acertos. Em MG, o Portal MG informa aprovação com 20 acertos ou mais (adaptação estadual divulgada).', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','15 acertos',0),(@q,'B','18 acertos',0),(@q,'C','21 acertos na regra geral de 70%',1),(@q,'D','30 acertos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O condutor deve portar, quando exigido, a Carteira Nacional de Habilitação (CNH) ou PPD e o documento do veículo (CRLV-e), sob pena de:', 'facil', 'Documentos obrigatórios conforme CTB; ausência caracteriza infração.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Advertência verbal apenas',0),(@q,'B','Infração prevista em lei',1),(@q,'C','Isenção em vias locais',0),(@q,'D','Multa só após 30 dias',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Transitar em velocidade incompatível com a segurança do local é infração que aumenta o risco de acidentes porque:', 'facil', 'Velocidade inadequada reduz tempo de reação e agrava colisões.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhora a visibilidade',0),(@q,'B','Reduz a distância de frenagem necessária',0),(@q,'C','Diminui o controle e aumenta gravidade de impactos',1),(@q,'D','Isenta o condutor de multas',0);

-- ========== 2 Placas e sinalização ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa regulamentadora de formato octogonal, fundo vermelho e inscrição PARE significa:', 'facil', 'Octógono vermelho identifica parada obrigatória antes de entrar ou cruzar a via.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Parada obrigatória',1),(@q,'B','Preferência de passagem',0),(@q,'C','Proibido estacionar',0),(@q,'D','Velocidade mínima',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placas de advertência em geral têm formato:', 'facil', 'Advertência usa triângulo equilátero com borda vermelha e fundo amarelo.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Triangular',1),(@q,'B','Circular azul',0),(@q,'C','Retangular verde',0),(@q,'D','Octogonal',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Marca viária amarela contínua, separando fluxos opostos, indica:', 'medio', 'Linha contínua amarela proíbe ultrapassagem que invada a faixa oposta.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ultrapassagem permitida',0),(@q,'B','Proibição de ultrapassagem',1),(@q,'C','Estacionamento permitido',0),(@q,'D','Ciclovia',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Semáforo com luz vermelha fixa indica ao condutor que deve:', 'facil', 'Vermelho fixo: parada antes da faixa de retenção ou do cruzamento.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Acelerar para limpar cruzamento',0),(@q,'B','Parar e aguardar liberação',1),(@q,'C','Seguir se não houver veículos',0),(@q,'D','Buzinar e passar',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placa circular com borda vermelha e fundo branco costuma indicar:', 'medio', 'Circular com borda vermelha é típica de regulamentação (proibição ou restrição).', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Indicação turística',0),(@q,'B','Regulamentação',1),(@q,'C','Pedágio',0),(@q,'D','Serviços mecânicos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A sinalização horizontal de faixa de pedestre (zebrada) alerta o condutor a:', 'facil', 'Deve reduzir e dar preferência a pedestres na faixa quando aplicável.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Estacionar sobre ela',0),(@q,'B','Atenção e preferência ao pedestre',1),(@q,'C','Ultrapassar em alta velocidade',0),(@q,'D','Usar como ponto de táxi',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Luz amarela intermitente no semáforo significa, em regra:', 'medio', 'Amarelo intermitente: atenção, cruzamento ou trecho com cuidado redobrado.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Parada obrigatória imediata',0),(@q,'B','Atenção',1),(@q,'C','Via expressa livre',0),(@q,'D','Proibido seguir',0);

-- ========== 3 Direção defensiva ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Direção defensiva consiste em conduzir de modo a prevenir acidentes, mesmo quando outros cometem erros. Isso inclui:', 'facil', 'Antecipar riscos, manter distância e atenção plena.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Confiar cegamente no outro',0),(@q,'B','Antecipar situações de perigo',1),(@q,'C','Usar celular com moderação',0),(@q,'D','Dirigir sempre no limite máximo',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Em pista molhada, a distância de seguimento deve ser:', 'medio', 'Aderência menor exige maior distância e velocidade compatível.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Menor que em seco',0),(@q,'B','Igual em qualquer condição',0),(@q,'C','Maior que em seco',1),(@q,'D','Desnecessária com ABS',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Aquaplanagem ocorre quando:', 'medio', 'Camada de água entre pneu e asfalto reduz aderência.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','O motor superaquece',0),(@q,'B','O pneu perde contato com o solo por excesso de água',1),(@q,'C','O freio de mão trava',0),(@q,'D','A bateria descarrega',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Antes de mudar de faixa, além da seta, o condutor deve verificar:', 'facil', 'Espelhos + ponto cego reduzem colisões laterais.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas o retrovisor central',0),(@q,'B','Espelhos e ponto cego',1),(@q,'C','Somente GPS',0),(@q,'D','Painel de temperatura',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Fadiga e sonolência ao volante:', 'facil', 'Tempo de reação aumenta; risco de acidente grave sobe muito.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhoram reflexos',0),(@q,'B','Aumentam risco de colisão',1),(@q,'C','São irrelevantes em vias urbanas',0),(@q,'D','Substituem pausas obrigatórias',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Manter faróis acesos em rodovia à noite ajuda a:', 'medio', 'Melhora visibilidade e torna o veículo mais perceptível.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ofuscar outros motoristas propositalmente',0),(@q,'B','Ser visto e enxergar melhor',1),(@q,'C','Economizar bateria',0),(@q,'D','Evitar uso de cinto',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Distrações com celular ao dirigir:', 'facil', 'Uso que tira atenção da via é fator de risco e pode configurar infração.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','São seguras em baixa velocidade',0),(@q,'B','Aumentam risco de acidente',1),(@q,'C','São recomendadas no trânsito',0),(@q,'D','Substituem espelhos',0);

-- ========== 4 Primeiros socorros ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Em acidente de trânsito, a primeira atitude do condutor deve ser:', 'facil', 'Sinalizar o local, acionar socorro (SAMU 192 / Bombeiros 193) e prestar auxílio possível.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Fugir para evitar multa',0),(@q,'B','Garantir segurança e chamar ajuda',1),(@q,'C','Mover todas as vítimas imediatamente',0),(@q,'D','Filmar e postar na internet',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Vítima inconsciente e sem respiração aparente: procedimento inicial adequado inclui:', 'medio', 'Verificar responsividade, acionar emergência e iniciar suporte básico se treinado.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Oferecer bebida alcoólica',0),(@q,'B','Acionar serviço de emergência e avaliar vias aéreas',1),(@q,'C','Colocar a sentar e caminhar',0),(@q,'D','Ignorar se houver sangramento leve',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Em hemorragia externa visível, medida inicial comum é:', 'medio', 'Compressão direta limpa ajuda a controlar sangramento até equipe chegar.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Torniquete em qualquer caso',0),(@q,'B','Compressão local e acionar socorro',1),(@q,'C','Aplicar pomada desconhecida',0),(@q,'D','Deixar exposto ao sol',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Suspeita de fratura, sem treinamento: deve-se evitar:', 'facil', 'Imobilização brusca ou movimentação desnecessária pode agravar lesão.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Manter vítima aquecida e monitorada',0),(@q,'B','Mover o membro fraturado desnecessariamente',1),(@q,'C','Acionar emergência',0),(@q,'D','Conversar para acalmá-la',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'O número de emergência do SAMU (atendimento médico móvel) no Brasil é:', 'facil', '192 — SAMU; 193 — Bombeiros; 190 — Polícia.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','190',0),(@q,'B','191',0),(@q,'C','192',1),(@q,'D','199',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Retirar capacete de motociclista acidentado deve ser feito:', 'medio', 'Somente se treinado e quando necessário para via aérea; caso contrário aguardar socorro.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sempre e rapidamente por qualquer pessoa',0),(@q,'B','Com critério, preferencialmente por socorrista treinado',1),(@q,'C','Nunca em hipótese alguma',0),(@q,'D','Para tirar foto',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Sinalizar o local do acidente com triângulo ou meios disponíveis serve para:', 'facil', 'Alerta outros condutores e reduz risco de novo choque.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar congestionamento',0),(@q,'B','Advertir condutores que se aproximam',1),(@q,'C','Substituir polícia',0),(@q,'D','Indicar estacionamento',0);

-- ========== 5 Meio ambiente e cidadania ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Motor desregulado ou com falhas na injeção tende a:', 'facil', 'Aumenta consumo e emissão de poluentes.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Reduzir poluição',0),(@q,'B','Aumentar poluição e consumo',1),(@q,'C','Eliminar revisões',0),(@q,'D','Melhorar silenciador apenas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Descartar lixo pela janela do veículo:', 'facil', 'Polui ambiente e pode causar acidentes; conduta anti-cidadã e passível de penalidade.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É permitido em estradas vazias',0),(@q,'B','Polui e pode gerar infração',1),(@q,'C','Ajuda na limpeza pública',0),(@q,'D','É recomendado à noite',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Respeitar faixa de pedestres e ciclistas demonstra:', 'facil', 'Convívio urbano seguro e cidadania no trânsito.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Falta de habilidade',0),(@q,'B','Cidadania e segurança',1),(@q,'C','Desconhecimento da via',0),(@q,'D','Preferência absoluta do carro',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Buzina deve ser usada:', 'medio', 'Uso abusivo perturba e pode configurar infração; serve para advertir perigo.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Para cumprimentar amigos',0),(@q,'B','De forma moderada para advertir perigo',1),(@q,'C','Em frente a hospitais à noite',0),(@q,'D','No lugar da seta',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Transportar carga mal amarrada pode causar:', 'medio', 'Queda de objetos na via gera risco a outros usuários.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhor aerodinâmica',0),(@q,'B','Acidentes e infrações',1),(@q,'C','Economia de combustível',0),(@q,'D','Isenção de seguro',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Preferir transporte coletivo ou deslocamentos a pé, quando possível, contribui para:', 'facil', 'Menos veículos individuais reduzem emissões e congestionamento.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Mais poluição',0),(@q,'B','Mobilidade mais sustentável',1),(@q,'C','Aumento de multas',0),(@q,'D','Eliminar pedestres',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Manutenção preventiva do veículo (filtros, velas, pneus) ajuda a:', 'medio', 'Veículo conservado consome menos e polui menos.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar consumo propositalmente',0),(@q,'B','Reduzir impacto ambiental e custos',1),(@q,'C','Anular garantia sempre',0),(@q,'D','Evitar licenciamento',0);

-- ========== 6 Mecânica básica ==========
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'O sistema de arrefecimento do motor tem função principal de:', 'facil', 'Dissipar calor para evitar superaquecimento.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Frear o veículo',0),(@q,'B','Controlar temperatura do motor',1),(@q,'C','Carregar bateria',0),(@q,'D','Girar os pneus',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Pneus com calibragem abaixo da recomendada:', 'medio', 'Aumenta consumo, aquecimento e risco de estouro.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhoram aderência sempre',0),(@q,'B','Prejudicam segurança e consumo',1),(@q,'C','Aumentam potência',0),(@q,'D','Não alteram frenagem',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Luz de advertência de óleo no painel acesa indica possível:', 'medio', 'Pressão ou nível de óleo inadequado — risco ao motor.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Excesso de combustível',0),(@q,'B','Problema de lubrificação',1),(@q,'C','Pneu furado',0),(@q,'D','Limpador de para-brisa',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Freios em bom estado são essenciais porque:', 'facil', 'Permitem reduzir velocidade e parar com segurança.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Decoram o interior',0),(@q,'B','Garantem controle de velocidade e paradas',1),(@q,'C','Substituem cinto',0),(@q,'D','Eliminam aquaplanagem',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Bateria descarregada pode impedir:', 'facil', 'Partida elétrica e funcionamento de sistemas eletrônicos.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Abrir portas manualmente',0),(@q,'B','Dar partida no motor',1),(@q,'C','Usar cinto',0),(@q,'D','Ler placa de trânsito',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Pneus com sulcos abaixo do limite legal (desgaste excessivo):', 'medio', 'Reduzem aderência, especialmente em pista molhada — exigem troca.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','São mais seguros',0),(@q,'B','Devem ser substituídos',1),(@q,'C','Economizam combustível sempre',0),(@q,'D','Só afetam estética',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Verificar nível de fluido de freio periodicamente ajuda a:', 'medio', 'Nível baixo pode indicar desgaste ou vazamento — compromete frenagem.', @ref, 1, 1);
SET @q = LAST_INSERT_ID(); INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar potência',0),(@q,'B','Manter eficiência do sistema de freio',1),(@q,'C','Evitar troca de pneus',0),(@q,'D','Desligar airbag',0);
