-- Questões autorais de demonstração (importe após database.sql)
USE `aprova_cnh`;

-- Helper: insere questão e alternativas via variáveis temporárias simplificadas
-- Legislação (categoria 1)
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Conforme o CTB, a validade da CNH na categoria B, para condutores com menos de 50 anos, em regra, é de:', 'medio', 'A CNH tem validade definida em lei, variando conforme idade e categoria.', 'CTB — validade da CNH (consulta oficial)', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','5 anos',0),(@q,'B','10 anos',1),(@q,'C','15 anos',0),(@q,'D','20 anos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Dirigir sem possuir CNH ou PPD, quando exigido, configura infração de natureza:', 'facil', 'Trata-se de infração gravíssima, com medidas administrativas previstas.', 'CTB — infrações', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placa octogonal de fundo vermelho indica:', 'facil', 'Formato octogonal é exclusivo da placa PARE.', 'Manual Brasileiro de Sinalização de Trânsito', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Parada obrigatória',1),(@q,'B','Dê a preferência',0),(@q,'C','Proibido estacionar',0),(@q,'D','Velocidade máxima',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placas circulares com borda vermelha geralmente indicam:', 'medio', 'Regulamentação costuma usar formato circular com borda vermelha.', 'MBST — sinalização regulamentadora', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Advertência',0),(@q,'B','Regulamentação/proibição',1),(@q,'C','Indicação turística',0),(@q,'D','Obras',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Direção defensiva significa, principalmente:', 'facil', 'Antecipar riscos e manter margem de segurança.', 'Direção defensiva — conceito', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Dirigir sempre no limite máximo',0),(@q,'B','Conduzir de forma a prevenir acidentes',1),(@q,'C','Usar buzina com frequência',0),(@q,'D','Confiar na habilidade dos outros',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Em chuva forte, a distância de seguimento deve ser:', 'medio', 'Pista molhada aumenta distância de frenagem.', 'Direção defensiva — aderência', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Reduzida',0),(@q,'B','Mantida',0),(@q,'C','Aumentada',1),(@q,'D','Ignorada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Em acidente com vítima inconsciente e ausência de respiração, a prioridade inicial é:', 'medio', 'Manter vias aéreas e chamar socorro especializado.', 'Primeiros socorros no trânsito', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Oferecer água',0),(@q,'B','Garantir local seguro e acionar emergência',1),(@q,'C','Mover imediatamente sem avaliar',0),(@q,'D','Aplicar torniquete de rotina',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Manter o motor regulado contribui para:', 'facil', 'Motor desregulado polui mais e consome mais.', 'Meio ambiente e manutenção', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Aumentar emissões poluentes',0),(@q,'B','Reduzir poluição e consumo',1),(@q,'C','Eliminar necessidade de revisão',0),(@q,'D','Aumentar ruído propositalmente',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'O sistema responsável por reduzir a temperatura do motor é o de:', 'facil', 'Arrefecimento dissipa calor do motor.', 'Mecânica básica', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Freio',0),(@q,'B','Arrefecimento',1),(@q,'C','Ignição',0),(@q,'D','Direção',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Estacionar em local proibido pela sinalização é infração:', 'medio', 'Depende da sinalização e gradação legal.', 'CTB — estacionamento', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Leve',0),(@q,'B','Grave ou gravíssima conforme o caso',1),(@q,'C','Apenas advertência sempre',0),(@q,'D','Não é infração',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Em cruzamento sem sinalização, a preferência básica é de quem:', 'medio', 'Regra geral: preferência à direita.', 'Normas de circulação — preferência', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES
(@q,'A','Vem pela esquerda',0),(@q,'B','Vem pela direita',1),(@q,'C','Está em via de terra sempre',0),(@q,'D','Estaciona primeiro',0);

-- Questões adicionais para simulado geral (30+)
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O uso do cinto de segurança é obrigatório:', 'facil', 'Obrigatoriedade inclui todos os ocupantes nos assentos previstos.', 'CTB — segurança', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas em rodovias',0),(@q,'B','Para todos os ocupantes, conforme regra',1),(@q,'C','Somente do motorista em vias urbanas',0),(@q,'D','Nunca em trajetos curtos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Linha amarela contínua separando fluxos opostos indica:', 'medio', 'Contínua restringe ultrapassagem.', 'MBST — marca viária', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ultrapassagem livre',0),(@q,'B','Proibição de ultrapassagem',1),(@q,'C','Estacionamento permitido',0),(@q,'D','Ciclovia',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'A aquaplanagem ocorre quando:', 'medio', 'Pneu perde contato com o piso por camada de água.', 'Direção defensiva', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','O veículo está parado',0),(@q,'B','Há perda de aderência em pista molhada',1),(@q,'C','O freio ABS falha sempre',0),(@q,'D','O motor superaquece',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Ao presenciar acidente, o condutor deve:', 'facil', 'Sinalizar o local e acionar socorro.', 'Primeiros socorros', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Fugir para evitar atraso',0),(@q,'B','Prestar auxílio dentro de suas possibilidades',1),(@q,'C','Remover vítimas sempre imediatamente',0),(@q,'D','Filmar e seguir viagem',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Deslocar-se a pé ou de bicicleta quando possível contribui para:', 'facil', 'Mobilidade sustentável reduz emissões.', 'Cidadania no trânsito', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar congestionamento',0),(@q,'B','Menor impacto ambiental',1),(@q,'C','Mais poluição sonora',0),(@q,'D','Eliminar fiscalização',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Pneus com calibragem incorreta podem causar:', 'medio', 'Pressão inadequada afeta consumo e segurança.', 'Mecânica básica', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhor aderência sempre',0),(@q,'B','Desgaste irregular e maior consumo',1),(@q,'C','Aumento automático de potência',0),(@q,'D','Freio mais eficiente sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Recusar-se ao teste de alcoolemia, quando exigido, implica:', 'medio', 'Recusa tem consequências previstas em lei.', 'CTB — alcoolemia', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Nenhuma penalidade',0),(@q,'B','Sanções previstas em lei',1),(@q,'C','Apenas advertência verbal',0),(@q,'D','Isenção de multa',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Ultrapassagem pela contramão só é permitida quando:', 'medio', 'Deve haver visibilidade e permissão legal.', 'Normas de circulação', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sempre em curvas',0),(@q,'B','Quando a sinalização e condições permitirem',1),(@q,'C','Em faixas exclusivas de ônibus',0),(@q,'D','Na contramão em pontes sempre',0);

-- Mais 12 questões variadas
INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O CTB define que o trânsito é direito de todos e dever de:', 'facil', 'Deveres incluem observância às normas.', 'CTB — princípios', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Somente motoristas profissionais',0),(@q,'B','Todos os cidadãos',1),(@q,'C','Apenas pedestres',0),(@q,'D','Somente motociclistas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Sinal amarelo intermitente indica:', 'facil', 'Atenção redobrada.', 'MBST — semafórico', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Parada imediata',0),(@q,'B','Atenção',1),(@q,'C','Via livre absoluta',0),(@q,'D','Proibido seguir',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'O ponto cego do veículo exige:', 'medio', 'Ajuste de espelhos e verificação antes de manobras.', 'Direção defensiva', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Confiar apenas no retrovisor',0),(@q,'B','Verificação visual antes de mudar de faixa',1),(@q,'C','Acelerar sempre',0),(@q,'D','Desligar setas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Em hemorragia externa visível, procedimento inicial adequado inclui:', 'medio', 'Pressão local e acionar socorro.', 'Primeiros socorros', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ignorar e seguir',0),(@q,'B','Compressão local e buscar ajuda',1),(@q,'C','Remédio caseiro sem avaliação',0),(@q,'D','Mover vítima sem necessidade',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Respeitar faixas de pedestres demonstra:', 'facil', 'Cidadania e segurança.', 'Cidadania', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Falta de habilidade',0),(@q,'B','Respeito ao pedestre',1),(@q,'C','Desconhecimento da via',0),(@q,'D','Preferência do veículo',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Luz de advertência de óleo acesa indica possível:', 'medio', 'Lubrificação inadequada pode danificar motor.', 'Mecânica básica', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Excesso de combustível',0),(@q,'B','Problema de lubrificação',1),(@q,'C','Pneu furado',0),(@q,'D','Bateria carregada demais',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Excesso de velocidade é fator de:', 'facil', 'Velocidade incompatível aumenta risco e gravidade.', 'Infrações', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Redução de acidentes',0),(@q,'B','Maior gravidade de colisões',1),(@q,'C','Menor consumo sempre',0),(@q,'D','Melhor visibilidade',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Ao aproximar-se de cruzamento, o condutor deve:', 'facil', 'Reduzir velocidade e observar preferência.', 'Circulação', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Acelerar para passar primeiro',0),(@q,'B','Reduzir e observar',1),(@q,'C','Desligar faróis',0),(@q,'D','Usar celular rapidamente',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Documento obrigatório a ser portado pelo condutor inclui:', 'medio', 'CNH/PPD e CRLV conforme exigência legal.', 'CTB — documentos', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas comprovante de residência',0),(@q,'B','CNH/PPD e documento do veículo',1),(@q,'C','Certidão de nascimento',0),(@q,'D','Carteira de trabalho sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placa amarela em formato triangular indica:', 'facil', 'Triângulo amarelo é advertência.', 'MBST', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Advertência',1),(@q,'B','Serviços',0),(@q,'C','Turismo',0),(@q,'D','Pedágio',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Distrações ao volante, como celular, aumentam:', 'facil', 'Atenção dividida eleva risco de acidente.', 'Direção defensiva', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Segurança',0),(@q,'B','Risco de colisão',1),(@q,'C','Economia de combustível',0),(@q,'D','Visibilidade noturna',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Conversional à direita em via de mão única exige:', 'medio', 'Posicionamento correto e sinalização.', 'Circulação', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Faixa da esquerda',0),(@q,'B','Aproximar-se à direita e sinalizar',1),(@q,'C','Parar no meio da via',0),(@q,'D','Contramão',0);
