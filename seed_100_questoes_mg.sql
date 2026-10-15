-- 100 questões de treinamento DETRAN-MG (gerado de scripts/questoes_100.json)
-- Importe pelo phpMyAdmin. Duplicatas: use scripts/carga_100_questoes.php para carga idempotente.

-- Selecione seu banco no phpMyAdmin antes de importar.

SET @ref = 'Questão de treinamento autoral. Base: CTB (Lei 9.503/1997) e normas CONTRAN. Estudo DETRAN-MG. Não é questão oficial de prova.';

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'De acordo com o CTB, qual documento é obrigatório para conduzir veículo automotor em via pública?', 'facil', 'O condutor deve portar CNH válida e dentro do prazo, na categoria adequada ao veículo, conforme o CTB.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 162 e arts. relacionados à habilitação.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas o CRLV do veículo',0),(@q,'B','Carteira Nacional de Habilitação (CNH) válida e compatível com a categoria',1),(@q,'C','Comprovante de residência',0),(@q,'D','Certificado de registro do curso teórico, sem CNH',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'No CTB, a validade da CNH para condutores com menos de 50 anos, em regra, é de quanto tempo?', 'medio', 'Pela regra geral do CTB, a CNH tem validade de 10 anos para condutores com menos de 50 anos, salvo disposições específicas.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 148.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','5 anos',0),(@q,'B','10 anos',1),(@q,'C','15 anos',0),(@q,'D','Indeterminada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Crianças com até dez anos de idade devem ser transportadas no banco traseiro, salvo exceções previstas em lei. Qual equipamento de retenção é exigido quando aplicável?', 'facil', 'O CTB exige dispositivo de retenção adequado à idade, peso e estatura da criança, além do transporte no banco traseiro quando cabível.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 64.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Cinto de segurança apenas no colo do adulto',0),(@q,'B','Dispositivo de retenção infantil (bebê-conforto, cadeirinha ou assento de elevação) conforme idade e peso',1),(@q,'C','Nenhum, se a viagem for curta',0),(@q,'D','Capacete homologado',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Conduzir veículo sob influência de álcool ou de substância psicoativa que determine dependência configura infração gravíssima. Qual é a tolerância de álcool por litro de sangue prevista no CTB?', 'medio', 'O CTB estabelece tolerância zero para álcool na direção: qualquer concentração detectável caracteriza infração.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 165 e alterações (Lei 14.071/2020).', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Até 0,6 g/L',0),(@q,'B','Até 0,2 g/L',0),(@q,'C','Qualquer concentração detectável (tolerância zero)',1),(@q,'D','Até 0,4 g/L apenas para motociclistas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O uso do cinto de segurança é obrigatório para condutor e passageiros em veículos equipados com esse dispositivo?', 'facil', 'Todos os ocupantes devem usar cinto de segurança nos assentos onde o veículo dispõe do equipamento, conforme o CTB.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 65.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Somente o condutor',0),(@q,'B','Condutor e passageiros do banco dianteiro',0),(@q,'C','Condutor e todos os ocupantes, nos assentos equipados com cinto',1),(@q,'D','Apenas em rodovias',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Permitir que pessoa não habilitada conduza o veículo é infração de que natureza, segundo o CTB?', 'dificil', 'Entregar ou permitir a condução a pessoa sem habilitação ou com CNH cassada/suspensa é infração gravíssima.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 162, § 2º.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Qual categoria de CNH habilita, em regra, a conduzir automóvel e camioneta?', 'medio', 'A categoria B abrange veículos automotores de passageiros com até oito lugares, excluído o motorista, e peso bruto total até 3.500 kg.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 143; Resoluções CONTRAN sobre categorias.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','A',0),(@q,'B','B',1),(@q,'C','C',0),(@q,'D','D',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O condutor deve portar a CNH durante a condução. Em caso de fiscalização, o que o CTB prevê?', 'facil', 'O condutor deve portar e apresentar a habilitação quando solicitado, observadas as normas sobre documento digital quando admitidas.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997); normas CONTRAN sobre CNH digital.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Pode apresentar apenas foto no celular, sem documento oficial',0),(@q,'B','Deve apresentar documento de habilitação válido ou forma legalmente prevista de comprovação',1),(@q,'C','Não precisa portar se conhece o agente',0),(@q,'D','Basta informar o CPF verbalmente',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Veículos de emergência (como ambulância em serviço urgente) podem desrespeitar sinalização e limites de velocidade?', 'medio', 'Veículos de emergência têm prerrogativas limitadas e condicionadas à urgência e à segurança, conforme disposições do CTB.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 29, § 5º e art. 97.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Nunca, em hipótese alguma',0),(@q,'B','Sim, sempre, sem qualquer cuidado',0),(@q,'C','Sim, quando necessário ao serviço urgente, com segurança e respeitando regras específicas do CTB',1),(@q,'D','Somente em rodovias federais',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'O CTB classifica as infrações de trânsito em quantas naturezas?', 'facil', 'As infrações administrativas de trânsito são classificadas em leve, média, grave e gravíssima.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 231.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Duas: leve e grave',0),(@q,'B','Três: leve, média e grave',0),(@q,'C','Quatro: leve, média, grave e gravíssima',1),(@q,'D','Cinco, incluindo criminal',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Conduzir motocicleta, motoneta ou ciclomotor sem capacete de segurança com viseira ou óculos de proteção configura infração de que natureza?', 'dificil', 'Dirigir motocicleta ou similar sem capacete homologado e sem proteção ocular quando exigida é infração gravíssima.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 244.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Em vias urbanas, salvo sinalização em contrário, qual é o limite máximo de velocidade para automóveis, segundo o CTB?', 'medio', 'O CTB fixa 60 km/h como limite urbano padrão para automóveis, salvo sinalização ou norma local diversa.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 61.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','30 km/h',0),(@q,'B','40 km/h',0),(@q,'C','60 km/h',1),(@q,'D','80 km/h',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(1, 'Pedestres devem atravessar a via preferencialmente por onde?', 'facil', 'O pedestre deve usar faixa, passarela ou túnel próximos; atravessar fora desses locais só quando não houver em distância razoável.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 69.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Em qualquer ponto, desde que corram',0),(@q,'B','Pela faixa de pedestres ou passarela/túnel quando existirem, a até cinquenta metros',1),(@q,'C','Somente sobre pontes',0),(@q,'D','Entre veículos parados no congestionamento, sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placas de regulamentação, em geral, têm fundo de qual cor e formato?', 'facil', 'As placas de regulamentação indicam obrigações ou proibições e costumam ser retangulares com fundo branco.', 'Questão de treinamento autoral. CONTRAN (sinalização vertical); CTB, art. 90.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Amarelo, losangular',0),(@q,'B','Branco, retangular',1),(@q,'C','Azul, circular',0),(@q,'D','Verde, octogonal',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa octogonal vermelha com a inscrição \'PARE\' exige que o condutor:', 'facil', 'A placa R-1 (PARE) impõe parada total antes de entrar no cruzamento ou cruzar a faixa de pedestres.', 'Questão de treinamento autoral. Manual Brasileiro de Sinalização de Trânsito (CONTRAN).', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Reduza a velocidade e siga se não houver veículos',0),(@q,'B','Pare completamente antes da faixa ou do cruzamento e só prossiga com segurança',1),(@q,'C','Pare apenas à noite',0),(@q,'D','Buzine e prossiga',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placas de advertência (A-) têm, em geral, qual formato e cor de fundo?', 'medio', 'Placas de advertência alertam sobre condições perigosas; o padrão é losangular amarelo com símbolo preto.', 'Questão de treinamento autoral. CONTRAN — sinalização de advertência.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Circular, azul',0),(@q,'B','Losangular (diamante), amarela',1),(@q,'C','Retangular, verde',0),(@q,'D','Octogonal, vermelha',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa circular azul com seta branca indica:', 'facil', 'Placas circulares azuis com símbolos brancos pertencem ao grupo de indicação (orientação, serviços, etc.).', 'Questão de treinamento autoral. CONTRAN — placas de indicação.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Proibição de conversão',0),(@q,'B','Indicação ou serviço (placa de indicação)',1),(@q,'C','Advertência de curva',0),(@q,'D','Parada obrigatória',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa \'Proibido estacionar\' (círculo vermelho com \'E\' cortado) significa que:', 'medio', 'Proibido estacionar permite parada rápida para embarque ou desembarque, mas não permanência como estacionamento.', 'Questão de treinamento autoral. CONTRAN — placa R-6a; CTB sobre parada e estacionamento.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É proibido parar e estacionar em qualquer hipótese',0),(@q,'B','Pode parar momentaneamente para embarque/desembarque, mas não estacionar',1),(@q,'C','Estacionamento liberado apenas para deficientes',0),(@q,'D','Válida só em rodovias',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa \'Proibido parar e estacionar\' difere da \'Proibido estacionar\' porque:', 'dificil', 'Proibido parar e estacionar impede qualquer permanência do veículo naquele local, inclusive parada breve.', 'Questão de treinamento autoral. CONTRAN — placas R-6b e R-6a.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Permite estacionar à noite',0),(@q,'B','Veda também a parada do veículo, mesmo momentânea',1),(@q,'C','Aplica-se só a caminhões',0),(@q,'D','Indica obra na pista',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Faixa amarela contínua junto à guia da calçada, em regra, indica:', 'facil', 'A faixa amarela contínua na guia sinaliza proibição de parar e estacionar ao lado da demarcação.', 'Questão de treinamento autoral. CONTRAN — sinalização horizontal; CTB.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Livre estacionamento',0),(@q,'B','Proibição de parada e estacionamento na faixa demarcada',1),(@q,'C','Área exclusiva de motos',0),(@q,'D','Ciclovia',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placa de \'Velocidade máxima permitida\' informa:', 'medio', 'A placa R-19 fixa o limite máximo de velocidade regulamentado para o trecho sinalizado.', 'Questão de treinamento autoral. CONTRAN — placa de regulamentação R-19.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Velocidade mínima obrigatória',0),(@q,'B','Limite superior de velocidade naquele trecho',1),(@q,'C','Velocidade recomendada apenas em chuva',0),(@q,'D','Velocidade média dos veículos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa \'Dê a preferência\' (triângulo invertido vermelho e branco) exige:', 'facil', 'R-2 (Dê a preferência) obriga ceder passagem aos veículos na via principal, parando se necessário.', 'Questão de treinamento autoral. CONTRAN — placa R-2.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Parada total sempre',0),(@q,'B','Reduzir a velocidade e ceder passagem a quem cruza a via preferencial',1),(@q,'C','Acelerar para cruzar primeiro',0),(@q,'D','Retroceder na via',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Marcas zebradas (listras brancas e pretas ou amarelas) pintadas no pavimento indicam:', 'medio', 'Zebrados delimitam áreas proibidas ao tráfego ou à parada, canalizando o fluxo.', 'Questão de treinamento autoral. CONTRAN — sinalização horizontal.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Local preferencial para ultrapassagem',0),(@q,'B','Área onde não se deve parar, estacionar ou circular (obstáculo ou canalização)',1),(@q,'C','Estacionamento rotativo',0),(@q,'D','Pista molhada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Placas educativas (com mensagens de campanha) têm função principal de:', 'dificil', 'Placas educativas reforçam comportamentos seguros; obrigações vêm das placas de regulamentação e do CTB.', 'Questão de treinamento autoral. CONTRAN — placas educativas.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Substituir a fiscalização',0),(@q,'B','Informar ou educar o usuário, sem criar obrigação por si só',1),(@q,'C','Fixar multa automaticamente',0),(@q,'D','Indicar pedágio',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'A placa \'Sentido proibido\' (círculo branco com faixa vermelha horizontal) significa:', 'facil', 'R-3 veda a circulação no sentido indicado pela placa naquele acesso ou trecho.', 'Questão de treinamento autoral. CONTRAN — placa R-3.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Via com mão dupla',0),(@q,'B','Proibido entrar ou seguir naquele sentido da via',1),(@q,'C','Proibido ultrapassar',0),(@q,'D','Área de descanso',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(2, 'Semáforo com luz verde acesa permite:', 'medio', 'Verde libera a passagem, mas o condutor ainda deve ceder a quem ainda cruzava com sinal favorável e aos pedestres.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 44; CONTRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Atravessar sem olhar pedestres',0),(@q,'B','Seguir em frente ou converter, respeitando regras de preferência e pedestres na faixa',1),(@q,'C','Parar obrigatoriamente',0),(@q,'D','Retroceder',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Direção defensiva é conduzir de modo a prevenir acidentes, apesar das ações incorretas dos outros e das condições adversas. Qual atitude faz parte desse conceito?', 'facil', 'Direção defensiva exige vigilância, distância de segurança e decisões que reduzam o risco de colisão.', 'Questão de treinamento autoral. CTB — dever de cuidado; material educativo DETRAN-MG.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Confiar que todos respeitarão a sinalização',0),(@q,'B','Antecipar riscos, manter distância segura e atenção constante',1),(@q,'C','Usar o celular para economizar tempo',0),(@q,'D','Dirigir sempre no limite máximo da via',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'A distância de seguimento segura deve considerar principalmente:', 'medio', 'Espaço para frear depende da velocidade, aderência, visibilidade e tempo de percepção e reação.', 'Questão de treinamento autoral. CTB, art. 29, II; educação para o trânsito.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas a velocidade do veículo da frente',0),(@q,'B','Velocidade, condição do pavimento, visibilidade e tempo de reação do condutor',1),(@q,'C','Somente o tamanho do seu carro',0),(@q,'D','A cor do veículo precedente',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Em pista molhada, a distância de frenagem, em geral:', 'facil', 'Menor aderência na chuva aumenta a distância necessária para parar o veículo com segurança.', 'Questão de treinamento autoral. Direção defensiva; CTB — adaptação às condições.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Diminui',0),(@q,'B','Permanece igual',0),(@q,'C','Aumenta',1),(@q,'D','Não depende do pavimento',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'O \'ponto cego\' em veículos é a área:', 'medio', 'Espelhos não mostram toda a lateral/traseira; verificar o ponto cego reduz risco ao mudar de direção.', 'Questão de treinamento autoral. Material de direção defensiva; Portal DETRAN-MG (educação).', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Visível apenas pelo retrovisor interno',0),(@q,'B','Não coberta pelos espelhos, exigindo verificação por olhar por cima do ombro antes de mudar de faixa',1),(@q,'C','Dianteira do para-brisa',0),(@q,'D','Sempre à esquerda do motorista',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Aquaplanagem ocorre quando:', 'dificil', 'Em pista alagada, o pneu pode \'flutuar\' sobre a água; reduzir velocidade e evitar freadas bruscas ajuda a controlar.', 'Questão de treinamento autoral. Direção defensiva; CONTRAN/educação no trânsito.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','O motor superaquece',0),(@q,'B','Os pneus perdem contato com o solo por camada de água, reduzindo a aderência',1),(@q,'C','O freio de mão trava sozinho',0),(@q,'D','A bateria descarrega',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Usar o celular handheld (na mão) enquanto dirige:', 'facil', 'Distração reduz tempo de reação; o CTB pune o uso do celular enquanto conduz, salvo exceções legais.', 'Questão de treinamento autoral. CTB, art. 252; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhora a concentração',0),(@q,'B','Distrai o condutor e aumenta o risco de acidente, além de poder configurar infração',1),(@q,'C','É recomendado apenas em filas',0),(@q,'D','Substitui o uso de setas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Ao aproximar-se de cruzamento, condutor defensivo deve:', 'medio', 'Cruzamentos concentram conflitos; reduzir velocidade e ampliar observação previne colisões.', 'Questão de treinamento autoral. CTB, arts. 34 e 44; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Acelerar para passar antes',0),(@q,'B','Reduzir velocidade, observar sinalização, pedestres e veículos cruzando',1),(@q,'C','Fechar os olhos brevemente',0),(@q,'D','Desligar os faróis',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Cinto de segurança em colisão ajuda principalmente a:', 'facil', 'O cinto limita o movimento do corpo no impacto, reduzindo ferimentos graves.', 'Questão de treinamento autoral. CTB, art. 65; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ligar o rádio',0),(@q,'B','Manter o ocupante na posição e reduzir lesões por impacto ou ejeção',1),(@q,'C','Aumentar a velocidade',0),(@q,'D','Evitar multas apenas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Fadiga ao volante é perigosa porque:', 'medio', 'Cansaço prejudica julgamento e reflexos; pausas e sono adequado são essenciais antes de dirigir.', 'Questão de treinamento autoral. Educação para o trânsito; Portal DETRAN-MG.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumenta a atenção',0),(@q,'B','Prolonga tempo de reação e pode causar micro-sonos',1),(@q,'C','Melhora a visão noturna',0),(@q,'D','Reduz o consumo de combustível',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Regra prática de distância em condições normais: manter distância que permita parar se o veículo da frente frear bruscamente. Isso está relacionado ao:', 'dificil', 'Distância segura cobre o tempo até perceber o perigo mais a distância percorrida durante a frenagem.', 'Questão de treinamento autoral. CTB, art. 29; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Consumo de óleo',0),(@q,'B','Espaço de frenagem e tempo de reação',1),(@q,'C','Tipo de pintura do carro',0),(@q,'D','Número de portas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Ao dirigir à noite, condutor defensivo deve:', 'facil', 'Visibilidade reduzida exige faróis corretos, velocidade compatível e cortesia com o alto/baixo.', 'Questão de treinamento autoral. CTB, arts. 40 e 41; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Usar farol alto o tempo todo em vias urbanas',0),(@q,'B','Usar iluminação adequada, reduzir velocidade se a visibilidade for menor e evitar ofuscar outros',1),(@q,'C','Desligar os faróis para economizar bateria',0),(@q,'D','Olhar fixamente para faróis de quem vem em sentido contrário',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Ultrapassagem segura exige, entre outros cuidados:', 'medio', 'Ultrapassar só com visibilidade e margem de segurança; usar seta e voltar à faixa direita após concluir.', 'Questão de treinamento autoral. CTB, arts. 28 e 29; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ultrapassar em curva fechada sem visibilidade',0),(@q,'B','Visibilidade suficiente, sinalização com seta e retorno à faixa sem cortar o ultrapassado',1),(@q,'C','Buzinar continuamente em zona urbana residencial à noite',0),(@q,'D','Ultrapassar pela direita em rodovia sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(3, 'Em neblina ou chuva forte, acender faróis baixos (e, se previsto, luz de neblina dianteira conforme norma) serve para:', 'facil', 'Iluminação correta aumenta visibilidade e presença do veículo; velocidade deve ser compatível com a condição.', 'Questão de treinamento autoral. CTB, art. 40; Resoluções CONTRAN sobre iluminação.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ofuscar outros motoristas de propósito',0),(@q,'B','Ser visto e melhorar a visão, com velocidade reduzida',1),(@q,'C','Desligar o limpador',0),(@q,'D','Substituir o cinto de segurança',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Em acidente de trânsito, a primeira providência do condutor envolvido, quando possível, deve ser:', 'facil', 'O CTB impõe prestar socorro; chamar serviços de emergência salva vidas enquanto se aguarda equipe qualificada.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 176; primeiros socorros.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Fugir do local para evitar multa',0),(@q,'B','Prestar socorro às vítimas e acionar autoridades (SAMU 192, Bombeiros 193, Polícia 190)',1),(@q,'C','Mover todas as vítimas imediatamente sem avaliar',0),(@q,'D','Filmear para redes sociais antes de ajudar',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Vítima consciente, com sangramento externo abundante em membro. Conduta inicial adequada:', 'medio', 'Pressão direta controla sangramento; torniquete é exceção. Buscar atendimento médico urgente.', 'Questão de treinamento autoral. Noções de primeiros socorros; CTB — dever de socorro.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aplicar torniquete sempre como primeira medida',0),(@q,'B','Comprimir o local com pano limpo e elevar o membro se possível, mantendo a vítima calma',1),(@q,'C','Oferecer álcool para desinfetar por dentro',0),(@q,'D','Colocar a vítima sentada e deixá-la sozinha',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Qual número ligar para o Serviço de Atendimento Móvel de Urgência (SAMU) no Brasil?', 'facil', 'O SAMU atende emergências médicas pré-hospitalares pelo telefone 192.', 'Questão de treinamento autoral. Ministério da Saúde; educação DETRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','190',0),(@q,'B','191',0),(@q,'C','192',1),(@q,'D','193',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Suspeita de fratura exposta após colisão. O que NÃO se deve fazer na cena?', 'medio', 'Não reintroduzir osso nem movimentar sem necessidade; imobilizar e aguardar socorro especializado.', 'Questão de treinamento autoral. Primeiros socorros básicos; CTB.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Imobilizar grosso modo o membro na posição encontrada',0),(@q,'B','Cobrir ferida com material limpo',0),(@q,'C','Repor osso exposto ou movimentar o membro desnecessariamente',1),(@q,'D','Manter a vítima aquecida e monitorada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Vítima inconsciente, respirando, em via pública após acidente. Posição lateral de segurança serve para:', 'dificil', 'Deitar de lado mantém a língua afastada da garganta e facilita drenagem de secreções.', 'Questão de treinamento autoral. Primeiros socorros; material educativo DETRAN-MG.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Acelerar a respiração artificial',0),(@q,'B','Manter vias aéreas desobstruídas e evitar engasgo se vomitar',1),(@q,'C','Substituir atendimento médico',0),(@q,'D','Aplicar em queimaduras',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Kit de primeiros socorros no veículo deve conter, idealmente:', 'facil', 'Material simples para contenção de sangramento e proteção ajuda até chegar o socorro profissional.', 'Questão de treinamento autoral. Resoluções CONTRAN sobre equipamentos; educação no trânsito.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas documentos do carro',0),(@q,'B','Itens básicos como luvas, gazes, ataduras e orientação de uso, conforme recomendações de segurança',1),(@q,'C','Medicamentos controlados sem receita',0),(@q,'D','Ferramentas de pintura',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Choque elétrico de vítima presa a fio caído. Conduta segura:', 'medio', 'Interromper a corrente ou isolar com material não condutor evita eletrocussão de quem presta socorro.', 'Questão de treinamento autoral. Primeiros socorros; NR/educação de segurança.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Segurar a vítima com as mãos nuas imediatamente',0),(@q,'B','Desenergizar a fonte se possível e usar material isolante; não tocar na vítima enquanto houver contato com corrente',1),(@q,'C','Jogar água no fio',0),(@q,'D','Puxar o fio com pé descalço',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Queimadura química ou térmica leve na pele. Medida inicial:', 'facil', 'Água fria reduz dano térmico; não aplicar substâncias caseiras; buscar médico se extensa.', 'Questão de treinamento autoral. Primeiros socorros básicos.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Passar manteiga ou pasta de dente',0),(@q,'B','Resfriar com água corrente limpa por tempo adequado e proteger o local',1),(@q,'C','Estourar bolhas sempre',0),(@q,'D','Expor ao sol para secar',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Sinalizar acidente à noite em rodovia reduz risco de novas colisões. Item útil previsto para veículos:', 'medio', 'Dispositivo refletivo de sinalização alerta outros condutores; CTB exige equipamento de segurança no veículo.', 'Questão de treinamento autoral. CTB e Resoluções CONTRAN — equipamentos obrigatórios.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Triângulo de sinalização ou dispositivo equivalente homologado',1),(@q,'B','Fogos de artifício',0),(@q,'C','Pintura no asfalto',0),(@q,'D','Som alto do rádio',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Parada cardiorrespiratória em adulto. A sequência atual recomendada para leigos (RCP) prioriza:', 'dificil', 'Compressões mantêm circulação até desfibrilador ou SAMU; cursos oficiais ensinam a sequência completa.', 'Questão de treinamento autoral. Diretrizes de RCP; educação em primeiros socorros.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas respiração boca a boca, sem compressões',0),(@q,'B','Compressões torácicas ritmadas e, se treinado, ventilações conforme protocolo atual',1),(@q,'C','Aguardar sem fazer nada',0),(@q,'D','Massagear apenas os braços',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Deixar de prestar socorro em acidente quando possível pode configurar:', 'facil', 'O CTB pune quem deixa de prestar socorro à vítima de acidente ou não facilita atendimento.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 176.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas falta de educação, sem consequência legal',0),(@q,'B','Infração gravíssima prevista no CTB, além de responsabilidade moral',1),(@q,'C','Infração leve',0),(@q,'D','Benefício fiscal',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(4, 'Vítima com possível lesão na coluna após capotamento. Movimentá-la deve ser:', 'medio', 'Movimentação inadequada pode agravar lesão medular; aguardar equipe treinada.', 'Questão de treinamento autoral. Primeiros socorros; CTB.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Feito sempre pelos presentes para colocá-la no carro',0),(@q,'B','Evitado, salvo risco iminente (ex.: incêndio), mantendo cabeça alinhada ao tronco',1),(@q,'C','Feito puxando pelos braços rapidamente',0),(@q,'D','Substituído por exercícios de alongamento',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Descartar óleo usado de motor ou peças automotivas em rua, córrego ou lixo comum:', 'facil', 'Resíduos automotivos contaminam solo e água; descarte correto é dever ambiental e cívico.', 'Questão de treinamento autoral. Política Nacional de Resíduos Sólidos; educação DETRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É permitido se for pouca quantidade',0),(@q,'B','Polui o meio ambiente e deve ser levado a coleta/reciclagem adequada',1),(@q,'C','Melhora o asfalto',0),(@q,'D','É exigido pelo CTB',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Veículos com catalisador contribuem para reduzir a emissão de:', 'medio', 'O catalisador acelera reações químicas que diminuem poluentes como CO, HC e NOx.', 'Questão de treinamento autoral. Controle de emissões veiculares (CONAMA/CONTRAN).', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas ruído',0),(@q,'B','Gases poluentes do escapamento, transformando parte deles em substâncias menos nocivas',1),(@q,'C','Consumo de água',0),(@q,'D','Peso do veículo',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Manutenção preventiva do motor bem regulada tende a:', 'facil', 'Motor desregulado queima mal e polui mais; revisões periódicas ajudam meio ambiente e bolso.', 'Questão de treinamento autoral. Mecânica básica e meio ambiente; Portal DETRAN-MG.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar a fumaça preta sempre',0),(@q,'B','Melhorar eficiência e reduzir emissões e consumo excessivo',1),(@q,'C','Eliminar a necessidade de CNH',0),(@q,'D','Proibir o uso de filtro de ar',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Inspeção veicular de emissões (quando exigida na região) visa:', 'medio', 'Programas de inspeção buscam identificar veículos poluentes e exigir reparo.', 'Questão de treinamento autoral. Resoluções CONAMA/CONTRAN sobre emissões.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar poluição',0),(@q,'B','Verificar se o veículo atende limites de poluentes e ruído',1),(@q,'C','Substituir o licenciamento',0),(@q,'D','Isentar de IPVA',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Jogar bituca de cigarro ou lixo pela janela do veículo em movimento:', 'facil', 'Lixo arremessado polui e pode causar incêndios; o CTB prevê penalidade para essa conduta.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 252.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É infração e agride o meio ambiente',1),(@q,'B','É recomendado para limpar o carro',0),(@q,'C','Só é proibido em rodovias',0),(@q,'D','Ajuda na compostagem imediata',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Combustível adulterado ou de procedência duvidosa pode:', 'dificil', 'Abastecer em postos confiáveis protege motor, reduz poluição e evita prejuízos mecânicos.', 'Questão de treinamento autoral. ANP/educação ambiental no trânsito.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhorar sempre o desempenho',0),(@q,'B','Danificar motor, aumentar emissões e invalidar garantias',1),(@q,'C','Reduzir multas de trânsito',0),(@q,'D','Substituir o extintor',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Transporte de carga a granel sem lona ou enceramento adequado, espalhando material na via, pode:', 'medio', 'Carga mal acondicionada polui e cria risco; o CTB exige transporte seguro da carga.', 'Questão de treinamento autoral. CTB, art. 99; meio ambiente.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ser indiferente ao ambiente',0),(@q,'B','Causar poluição, acidentes e configurar infração',1),(@q,'C','Ser obrigatório',0),(@q,'D','Reduzir consumo de combustível',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Desligar o motor em paradas prolongadas (quando seguro e permitido) ajuda a:', 'facil', 'Motor ocioso consome e polui sem deslocar; desligar em filas longas pode ser ecologicamente positivo.', 'Questão de treinamento autoral. Educação ambiental; boas práticas de condução.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Aumentar emissões de CO2 parado',0),(@q,'B','Reduzir consumo de combustível e emissões desnecessárias',1),(@q,'C','Estourar pneus',0),(@q,'D','Evitar uso de cinto',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Ruído excessivo de escapamento modificado irregularmente:', 'medio', 'Alterações que aumentam ruído acima do permitido agridem saúde pública e podem ser autuadas.', 'Questão de treinamento autoral. CTB e normas de emissão acústica (CONTRAN/CONAMA).', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É desejável em áreas residenciais',0),(@q,'B','Pode configurar infração e poluição sonora',1),(@q,'C','Substitui a buzina',0),(@q,'D','Isenta de vistoria',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Pneus com desgaste irregular ou calibragem incorreta tendem a:', 'facil', 'Pneus mal conservados reduzem eficiência e segurança, elevando consumo e poluição.', 'Questão de treinamento autoral. Mecânica básica e meio ambiente.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Reduzir consumo sempre',0),(@q,'B','Aumentar consumo de combustível e desgaste prematuro',1),(@q,'C','Melhorar a emissão de gases',0),(@q,'D','Eliminar aquaplanagem',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Veículos elétricos ou híbridos, quando comparados a modelos equivalentes a combustão, em uso urbano:', 'dificil', 'Tecnologias alternativas podem diminuir poluição no ponto de uso; impacto total depende de energia e ciclo de vida.', 'Questão de treinamento autoral. Educação ambiental; políticas de mobilidade.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sempre poluem mais no exhaust',0),(@q,'B','Podem reduzir emissões locais de escape, dependendo da matriz energética e do modelo',1),(@q,'C','Não precisam de freios',0),(@q,'D','São proibidos no CTB',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(5, 'Lavar veículo em rio ou córrego com detergentes comuns:', 'medio', 'Esgoto de lavagem com produtos químicos prejudica cursos d\'água; use áreas de contenção.', 'Questão de treinamento autoral. Legislação ambiental; cidadania no trânsito.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É prática sustentável',0),(@q,'B','Contamina a água e deve ser evitado; usar locais apropriados de lavagem',1),(@q,'C','É exigido anualmente',0),(@q,'D','Reduz IPVA',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'A luz vermelha de óleo no painel acesa durante a marcha indica:', 'facil', 'Pressão de óleo insuficiente pode causar dano grave ao motor; interromper a condução é prudente.', 'Questão de treinamento autoral. Mecânica básica veicular; educação DETRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Tanque cheio',0),(@q,'B','Pressão de óleo do motor baixa — parar o veículo com segurança e verificar',1),(@q,'C','Pneu furado',0),(@q,'D','Farol alto ligado',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Sistema de freios a disco usa pastilhas que:', 'medio', 'Pastilhas pressionam discos rotativos, convertendo energia cinética em calor e freada.', 'Questão de treinamento autoral. Mecânica básica — sistema de freios.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Lubrificam o motor',0),(@q,'B','Apertam o disco para reduzir a velocidade das rodas',1),(@q,'C','Carregam a bateria',0),(@q,'D','Substituem o cinto de segurança',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Calibragem correta dos pneus deve seguir:', 'facil', 'Pressão indicada pelo fabricante garante segurança, aderência e desgaste uniforme.', 'Questão de treinamento autoral. Manual do proprietário; CONTRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Qualquer valor aleatório',0),(@q,'B','Especificação do fabricante do veículo (porta, manual ou etiqueta)',1),(@q,'C','Sempre o máximo da borracharia',0),(@q,'D','Zero PSI',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Bateria descarregada pode impedir:', 'medio', 'A bateria fornece energia para partida e circuitos elétricos quando o motor está parado.', 'Questão de treinamento autoral. Mecânica básica — sistema elétrico.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Abrir portas manualmente',0),(@q,'B','Dar partida no motor de arranque e alimentar sistemas elétricos essenciais',1),(@q,'C','Usar cinto',0),(@q,'D','Ler placa de PARE',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Fluido de freio com nível baixo persistente pode indicar:', 'dificil', 'Queda anormal do fluido compromete frenagem; inspecionar vazamentos e componentes.', 'Questão de treinamento autoral. Mecânica básica — freios hidráulicos.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Pneus novos',0),(@q,'B','Desgaste excessivo de pastilhas ou possível vazamento no sistema — exige verificação',1),(@q,'C','Ar-condicionado ligado',0),(@q,'D','Limpador desligado',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Extintor de incêndio no veículo (quando exigido) deve estar:', 'facil', 'Equipamento de combate a incêndio precisa estar válido e pronto para uso conforme normas.', 'Questão de treinamento autoral. Resoluções CONTRAN — equipamentos obrigatórios.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Vencido e sem lacre',0),(@q,'B','Dentro da validade, acessível e com carga adequada',1),(@q,'C','Guardado no porta-malas sem identificação',0),(@q,'D','Substituído por água com gás',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Correia dentada ou corrente de comando rompida em motor pode causar:', 'medio', 'Rompimento pode fazer válvulas e pistões colidirem em motores interferentes; manutenção preventiva é vital.', 'Questão de treinamento autoral. Mecânica básica — motor.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhoria de consumo',0),(@q,'B','Danos graves ao motor se não houver válvulas de segurança adequadas',1),(@q,'C','Aumento automático de pneus',0),(@q,'D','Cancelamento de multas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Espelhos retrovisores ajustados corretamente ajudam o condutor a:', 'facil', 'Ajuste adequado dos espelhos complementa a visão direta e aumenta segurança.', 'Questão de treinamento autoral. CTB — condições do veículo; direção defensiva.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ver apenas o interior do carro',0),(@q,'B','Monitorar tráfego traseiro e lateral com menor ponto cego',1),(@q,'C','Evitar uso de setas',0),(@q,'D','Desligar faróis',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Luz indicadora de ABS acesa constantemente após partida pode significar:', 'medio', 'ABS ajuda a manter controle na frenagem; luz fixa indica mau funcionamento do sistema.', 'Questão de treinamento autoral. Mecânica básica — freios ABS.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sistema antitravamento com falha — requer diagnóstico',1),(@q,'B','Pneu calibrado',0),(@q,'C','CNH vencida',0),(@q,'D','Farol queimado sempre normal',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Suspensão com amortecedores muito desgastados pode provocar:', 'dificil', 'Amortecedores ruins reduzem contato uniforme dos pneus com o solo, prejudicando segurança.', 'Questão de treinamento autoral. Mecânica básica — suspensão.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Melhor estabilidade em curvas',0),(@q,'B','Instabilidade, aquaplanagem precoce e maior distância de frenagem',1),(@q,'C','Redução de peso do veículo',0),(@q,'D','Aumento de validade da CNH',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Antes de viagem longa, verificação básica inclui:', 'facil', 'Inspeção simples previne pane e acidentes por falha mecânica evitável.', 'Questão de treinamento autoral. CTB — veículo em condições de segurança; Portal DETRAN-MG.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ignorar nível de água do radiador',0),(@q,'B','Checar pneus, fluidos, luzes e documentos do veículo',1),(@q,'C','Remover retrovisores',0),(@q,'D','Desligar freios',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(6, 'Direção hidráulica ou elétrica com falha pode manifestar-se por:', 'medio', 'Assistência de direção comprometida dificulta manobras e exige reparo.', 'Questão de treinamento autoral. Mecânica básica — direção.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Volante mais leve sempre',0),(@q,'B','Esforço excessivo para girar o volante ou ruídos anormais',1),(@q,'C','Aumento automático de velocidade',0),(@q,'D','Troca de categoria da CNH',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Estacionar em vaga reservada a pessoa com deficiência sem credencial válida é infração:', 'facil', 'Uso indevido de vaga PCD é gravíssima, além de falta de respeito à acessibilidade.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 181, XX.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Ultrapassar pelo acostamento configura infração de natureza:', 'medio', 'Transitar ou ultrapassar pelo acostamento é conduta gravíssima prevista no CTB.', 'Questão de treinamento autoral. CTB, art. 203.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Dirigir sem possuir CNH, quando exigida, é infração:', 'facil', 'Conduzir sem habilitação ou com CNH cassada/suspensa é gravíssima.', 'Questão de treinamento autoral. CTB, art. 162.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Grave',0),(@q,'C','Gravíssima',1),(@q,'D','Apenas advertência sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Avançar o sinal vermelho do semáforo ou o de parada obrigatória, salvo exceções legais, é:', 'medio', 'Desrespeitar sinal vermelho ou PARE é uma das infrações mais graves e perigosas.', 'Questão de treinamento autoral. CTB, art. 208.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Recusar-se a submeter a teste, exame ou procedimento legal para verificar influência de álcool ou substância psicoativa:', 'dificil', 'A recusa ao procedimento legal previsto tem penalidade equivalente à condução sob influência.', 'Questão de treinamento autoral. CTB, art. 165-A.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Não tem consequência',0),(@q,'B','Configura infração gravíssima prevista no CTB',1),(@q,'C','Gera apenas advertência',0),(@q,'D','Isenta de responsabilidade',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Não usar cinto de segurança como condutor configura infração:', 'facil', 'Deixar de usar cinto de segurança é infração grave, com multa e pontos na CNH.', 'Questão de treinamento autoral. CTB, art. 167.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Grave',1),(@q,'C','Gravíssima',0),(@q,'D','Média sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Excesso de velocidade até 20% acima do limite, em regra, classifica-se como infração:', 'medio', 'Faixas de excesso de velocidade têm gradações; até 20% acima costuma ser média (ver tabela atual do CTB).', 'Questão de treinamento autoral. CTB, art. 218.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',1),(@q,'C','Grave',0),(@q,'D','Gravíssima',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Estacionar sobre faixa de pedestres na mudança de sinal:', 'facil', 'Parar ou estacionar em local proibido, inclusive sobre faixa, gera autuação e risco a pedestres.', 'Questão de treinamento autoral. CTB, arts. 181 e 182.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É permitido se for rápido',0),(@q,'B','Pode obstruir cruzamento e configurar infração',1),(@q,'C','Reduz multas',0),(@q,'D','É obrigatório',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Dirigir ameaçando pedestres ou veículos configura infração:', 'medio', 'Conduzir de forma ameaçadora à integridade de pessoas ou patrimônio é gravíssima.', 'Questão de treinamento autoral. CTB, art. 170.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Grave',0),(@q,'C','Gravíssima',1),(@q,'D','Inexistente',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Acumular pontos na CNH dentro do período pode levar à:', 'dificil', 'Sistema de pontuação prevê suspensão e, em casos graves, cassação da habilitação.', 'Questão de treinamento autoral. CTB, arts. 259 a 261; Resoluções CONTRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Renovação automática sem exames',0),(@q,'B','Suspensão do direito de dirigir, conforme regras do CONTRAN',1),(@q,'C','Isenção de IPVA',0),(@q,'D','Categoria A automática',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Transitar na contramão em via de sentido único é infração:', 'facil', 'Circular em sentido proibido coloca todos em risco e é gravíssima.', 'Questão de treinamento autoral. CTB, art. 186, II.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Leve',0),(@q,'B','Média',0),(@q,'C','Grave',0),(@q,'D','Gravíssima',1);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(7, 'Multa por infração de trânsito pode ser acompanhada de:', 'medio', 'Penalidades incluem multa, pontos, retenção/apreensão do veículo e suspensão, conforme o caso.', 'Questão de treinamento autoral. CTB, arts. 231 e 258; CONTRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Apenas elogio',0),(@q,'B','Pontuação na CNH e medidas administrativas conforme gravidade',1),(@q,'C','Cancelamento automático do CPF',0),(@q,'D','Proibição de usar calçado',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Em cruzamento não sinalizado, a preferência básica do CTB é de quem:', 'facil', 'Regra geral: cede passagem a quem vem da direita, salvo outras normas específicas.', 'Questão de treinamento autoral. CTB (Lei 9.503/1997), art. 29.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Vem pela esquerda do condutor',0),(@q,'B','Vem pela direita do condutor',1),(@q,'C','Chega por último sempre',0),(@q,'D','Está em veículo maior sempre',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Rotatória (trevo circular) sinalizada: quem já circula dentro da rotatória tem:', 'medio', 'Quem está na rotatória tem prioridade; quem entra deve ceder passagem.', 'Questão de treinamento autoral. CTB, art. 29; CONTRAN.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sempre que parar',0),(@q,'B','Preferência sobre quem vai ingressar, salvo sinalização em contrário',1),(@q,'C','Proibição de sair',0),(@q,'D','Preferência apenas de caminhões',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Ao convergir à esquerda em cruzamento com semáforo, deve-se:', 'facil', 'Conversão exige seta, atenção ao fluxo oposto e respeito aos pedestres na faixa.', 'Questão de treinamento autoral. CTB, arts. 34 e 44.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Cortar faixa contrária sem sinalizar',0),(@q,'B','Sinalizar com antecedência e dar passagem a pedestres e veículos conforme sinal',1),(@q,'C','Acelerar no meio da faixa de pedestres',0),(@q,'D','Desligar os faróis',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Ultrapassagem pela direita é permitida quando:', 'medio', 'Regra geral é ultrapassar pela esquerda; a direita só nas situações previstas no CTB.', 'Questão de treinamento autoral. CTB, art. 29, § 2º.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Sempre em rodovia',0),(@q,'B','O veículo da frente sinalizou conversão à esquerda e houver espaço seguro, entre outras hipóteses legais',1),(@q,'C','Na calçada',0),(@q,'D','Em faixa de pedestres',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Veículo parado em fila dupla (segunda fila ao lado de veículos estacionados legalmente):', 'dificil', 'Estacionar em fila dupla atrapalha fluxo e é autuável.', 'Questão de treinamento autoral. CTB, art. 181, VIII.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É prática recomendada',0),(@q,'B','Obstrui via e configura infração de estacionamento irregular',1),(@q,'C','Tem preferência de passagem',0),(@q,'D','Substitui o ponto de táxi',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Pedestre iniciou travessia na faixa com sinal favorável. Condutor com sinal verde deve:', 'facil', 'Mesmo com verde, deve-se respeitar quem ainda cruza com segurança na faixa.', 'Questão de treinamento autoral. CTB, art. 44.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Acelerar para passar antes',0),(@q,'B','Aguardar a conclusão da travessia se o pedestre ainda estiver na faixa',1),(@q,'C','Buzinar até o pedestre correr',0),(@q,'D','Desviar pela calçada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Em rodovia, salvo sinalização diversa, qual faixa deve ser usada normalmente por veículos lentos?', 'medio', 'Veículos mais lentos devem usar faixa da direita, deixando a esquerda para ultrapassagens.', 'Questão de treinamento autoral. CTB, art. 29.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Faixa da esquerda',0),(@q,'B','Faixa da direita',1),(@q,'C','Acostamento como pista',0),(@q,'D','Canteiro central',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Marcha à ré deve ser usada:', 'facil', 'Ré é para manobra curta e controlada, com visibilidade e cuidado com pedestres.', 'Questão de treinamento autoral. CTB, art. 38.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Para percorrer longas distâncias rapidamente',0),(@q,'B','Por pequena distância, com segurança, para manobras como estacionar',1),(@q,'C','Em rodovia sempre',0),(@q,'D','Sem olhar espelhos',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Ciclistas em via compartilhada devem ser ultrapassados com:', 'medio', 'O CTB exige distância lateral mínima ao ultrapassar ciclistas (1,5 m em vias urbanas, salvo norma diversa).', 'Questão de treinamento autoral. CTB, art. 29, § 2º, alterações recentes.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Distância mínima legal lateral e velocidade que não coloque em risco',1),(@q,'B','Buzina contínua a centímetros',0),(@q,'C','Empurrão leve',0),(@q,'D','Farol alto ligado de propósito',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Veículo de transporte coletivo parado em ponto sinalizado: ultrapassá-lo pela direita onde há embarque:', 'dificil', 'Ultrapassagem junto a ônibus parado exige cautela com passageiros que atravessam a via.', 'Questão de treinamento autoral. CTB, art. 29; circulação urbana.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','É sempre permitido em alta velocidade',0),(@q,'B','Pode ser proibido ou perigoso; respeitar sinalização e pedestres embarcando',1),(@q,'C','É obrigatório',0),(@q,'D','Dispensa uso de setas',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Entrar ou sair de garagem, lote ou estacionamento exige:', 'facil', 'Quem sai de imóvel ou estacionamento deve ceder passagem a quem já circula na via ou calçada.', 'Questão de treinamento autoral. CTB, art. 36.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Prioridade sobre todos sempre',0),(@q,'B','Ceder passagem aos pedestres e veículos que transitam pela via',1),(@q,'C','Buzinar forte',0),(@q,'D','Ignorar calçada',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Em via com duas faixas no mesmo sentido, conversão à direita deve ser feita:', 'medio', 'Conversões devem ser feitas pela faixa adequada ao sentido da manobra, com sinalização.', 'Questão de treinamento autoral. CTB, art. 34.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Pela faixa mais à esquerda',0),(@q,'B','Pela faixa mais próxima à direita, sinalizando antes',1),(@q,'C','Por qualquer faixa sem seta',0),(@q,'D','Pela contramão',0);

INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES
(8, 'Acostamento destina-se, em regra, a:', 'facil', 'Acostamento não é faixa de tráfego normal; usar para parada emergencial ou situações previstas.', 'Questão de treinamento autoral. CTB, art. 39.', 1, 1);
SET @q = LAST_INSERT_ID();
INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (@q,'A','Ultrapassagem rápida',0),(@q,'B','Parada de emergência e socorro, não à circulação habitual de veículos',1),(@q,'C','Corridas de motos',0),(@q,'D','Estacionamento diário',0);

