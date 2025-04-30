-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/04/2025 às 00:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `disc`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_patterns`
--

CREATE TABLE `tbl_patterns` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `pattern` varchar(30) DEFAULT NULL,
  `behaviour` varchar(255) DEFAULT NULL,
  `jobs` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tbl_patterns`
--

INSERT INTO `tbl_patterns` (`id`, `type`, `pattern`, `behaviour`, `jobs`, `description`) VALUES
(39, 'C-I-D', 'AVALIADOR', 'Cuidadosa, muito à vontade com estranhos, foca na conclusão das tarefas', 'Gerenciamento ou Supervisão (Engenharia, Pesquisa, Finanças, Planejamento), Designer, Estudo de Trabalho', 'Uma pessoa analítica, cuidadosa e amigável quando se sente à vontade. Ela está muito à vontade com estranhos, pois consegue avaliar e se ajustar facilmente aos relacionamentos com eles.'),
(40, 'C-S-D', 'PRECISIONISTA', 'Sistemática e Procedimental, Focada nos detalhes, Exige precisão e altos padrões', 'Engenharia, Diretor de Pesquisa, Produção e Finanças (Diretor, Gerente, Supervisor)', 'Pensa de forma sistemática e tende a seguir procedimentos tanto na vida pessoal quanto no trabalho. Organizada e com um bom planejamento, é atenta aos detalhes. Age com sabedoria, diplomacia e raramente contesta seus colegas de trabalho intencionalmente.'),
(38, 'C-D-S', 'CONTEMPLADOR', 'Tem padrões elevados para si mesma, sempre acredita que há espaço para melhorias, quer produzir o melhor', 'Contador, Administrador, Controlador de Qualidade', 'Orientada para os detalhes, com altos padrões para si mesma. Ela é lógica e analítica. Quer fazer o seu melhor e sempre acredita que há espaço para melhorias.'),
(37, 'C-D-I', 'DESAFIADOR', 'Muito orientado a tarefas, sensível aos problemas, dá mais importância ao trabalho do que às pessoas', 'Suporte Logístico, Analista de Sistemas, Palestrante', 'Uma pessoa altamente orientada a tarefas e sensível aos problemas. Ela dá mais atenção ao trabalho do que às pessoas ao seu redor, incluindo seus sentimentos. Ela tende a ser reservada e desconfiada.'),
(36, 'C-I', 'AVALIADOR', 'Analítica, cuidadosa, amigável quando se sente à vontade', 'Relações Públicas, Palestrante, Administração de Pessoal', 'Uma pessoa analítica, cuidadosa e amigável quando está confortável. Ela demonstra ser atenciosa e amigável, mas consegue focar na resolução das tarefas que lhe são atribuídas.'),
(35, 'S-C-I', 'DEFENSOR', 'Estável, amigável, tende a ser individualista', 'Bem-estar Pessoal, Consultores, Atendimento Jurídico', 'Uma pessoa estável, amigável e que se esforça para construir relacionamentos positivos no trabalho e em casa. Ela deseja ser aceita como parte de uma equipe e quer ser bem vista pelos outros.'),
(34, 'S-C-D', 'INQUIRER', 'Muito orientada aos detalhes, muito cuidadosa na conclusão das tarefas, muito cautelosa', 'Gerenciamento ou Supervisão (Engenharia, Contabilidade, Engenheiro de Projetos, Desenhista)', 'Uma pessoa naturalmente boa e muito orientada aos detalhes. Ela se importa com as pessoas ao seu redor e tem qualidades que a tornam muito cuidadosa ao concluir tarefas. Ela avalia cuidadosamente o ambiente ao tomar decisões, considerando os impactos nas pessoas ao redor. Às vezes, ela é excessivamente cautelosa.'),
(33, 'S-I-C', 'DEFENSOR', 'Estável, detalhista quando necessário, firme em suas convicções', 'Bem-estar Pessoal, Instrutor Técnico, Atendimento ao Cliente.', 'Uma pessoa estável, amigável e que trabalha para construir relacionamentos positivos tanto no trabalho quanto em casa. Ela pode ser muito detalhista quando necessário, mas, em geral, tende a ser mais individualista, independente e com menos atenção aos detalhes. Uma vez tomada a decisão, é difícil mudar sua opinião.'),
(32, 'S-I-D', 'CONSELHEIRO', 'Boa ouvinte, demonstrativa, não impõe suas ideias aos outros', 'Engenharia e Produção (Supervisão), Vendas de Serviços, Distribuição e Supervisão de Armazém', 'Uma pessoa que impressiona os outros com sua calorosidade, simpatia e compreensão. Muitas pessoas a procuram por ela ser uma boa ouvinte. Ela tende a ser bastante demonstrativa e suas emoções geralmente são visíveis para aqueles ao seu redor.'),
(31, 'S-D-I', 'DIRETOR', 'Uma pessoa objetiva e analítica, motivada por metas pessoais, orientada para o trabalho', 'Engenharia e Produção (Supervisão), Vendas de Serviços, Gestão de Escritórios.', 'Uma pessoa objetiva e analítica. Ela quer estar envolvida nas situações e também quer oferecer apoio e assistência às pessoas que respeita. Persistente ao iniciar tarefas, ela trabalha duro para atingir suas metas. É independente, meticulosa e tem um bom acompanhamento de suas ações.'),
(30, 'S-I', 'CONSELHEIRO', 'Simpatia e compreensão, calma em situações sociais, boa ouvinte', 'Hoteleiro, Agente de Viagens, Terapeuta.', 'Uma pessoa que impressiona os outros com seu calor humano, simpatia e compreensão. Ela tem calma na maioria das situações sociais e raramente desagrada aos outros. Ela tende a ver críticas ao seu trabalho como ataques pessoais. Ela é uma verdadeira \"guardião da paz\" e trabalhará para manter a harmonia em qualquer situação.'),
(29, 'S-D', 'AUTOMOTIVADO', 'Independente, bom planejador, comprometido com metas, motivado por metas pessoais', 'Investigador, Pesquisador, Especialista em Computação', 'Uma pessoa objetiva e analítica. Devido à sua determinação, ela muitas vezes tem sucesso em várias áreas. Sua personalidade calma, estável e resistência contribui para seu sucesso. Ela pode parecer fria, embora seja orientada para as pessoas, e em situações desconfortáveis, prefere apoiar seus líderes do que se envolver no problema.'),
(28, 'I-C-S', 'RESPONSIVO & ATENTO', 'Boa habilidade de comunicação, direto ao ponto, precisa de socialização, falta de foco', 'Serviços ao Cliente, Relações Públicas, Artista', 'Uma pessoa orientada para os outros e fluente em comunicação, leal. Ela precisa ser mais direta e evitar ser subjetiva. Precisa de reconhecimento social e atenção pessoal, sendo capaz de se entrosar rapidamente com os outros. Ela é amigável, entusiasta, informal, fala muito e se preocupa demais com o que os outros pensam.'),
(27, 'I-C-D', 'AVALIADOR', 'Analítica, cuidadosa, amigável quando se sente à vontade', 'Financeiro (Gerente, Especialista), Engenharia (Gerente, Designer, Comprador, Desenhista), Engenheiro de Projetos.', 'Uma pessoa analítica, cuidadosa e amigável quando está confortável. Ela gosta de estar em situações previsíveis, sem surpresas. É orientada pela qualidade e trabalhará arduamente para concluir seu trabalho de forma correta. Ela quer que as pessoas reconheçam o trabalho bem feito.'),
(25, 'I-S', 'CONSELHEIRO', 'Aconchegante, simpático, calmo em situações sociais', 'Pessoal-HR, Coach, Mentor.', 'Uma pessoa que impressiona os outros com sua calorosidade, simpatia e compreensão. Ela tem calma na maioria das situações sociais e raramente desagrada aos outros. Se ela sentir algo de forma intensa, ela falará abertamente e de forma direta sobre sua opinião. Ela tende a levar críticas ao seu trabalho como algo pessoal.'),
(26, 'I-C', 'AVALIADOR', 'Gosta de fazer amigos, confortável mesmo com estranhos, fácil em desenvolver novos relacionamentos', 'Treinamento, Inventor, Engenheiro de Serviço ou Supervisão em uma área Técnica/Especializada.', 'Uma pessoa amigável e sociável, que se sente confortável até com estranhos. Ela tende a ser perfeccionista por natureza e se isola quando necessário para concluir seu trabalho. Às vezes, ela pode avaliar mal as habilidades dos outros devido às suas visões otimistas.'),
(23, 'D-C-S', 'DESAFIADOR', 'Reage rapidamente, capaz de encontrar soluções para problemas, oferece muitas ideias. Esforça-se pela precisão.', 'Engenharia, Científico, Planejamento de Pesquisa.', 'Uma pessoa sensível aos problemas e criativa na resolução dos mesmos. Ela pode concluir tarefas importantes rapidamente devido à sua forte decisão. É perseverante e reage de forma rápida.'),
(24, 'I', 'COMUNICADOR', 'Persuasivo, fala ativamente, inspirador', 'Promoção, Demonstração, Coleta de informações', 'Uma pessoa entusiasta e otimista, que prefere atingir seus objetivos através dos outros. Ela gosta de interagir com as pessoas, e até mesmo organizar festas ou atividades para se reunir, o que reflete sua personalidade amigável. Não gosta de trabalhar sozinha e tende a estar com os outros ao resolver projetos. Sua atenção e foco nem sempre são tão bons quanto ela gostaria, preferindo usar um estilo de gestão participativo, construído com base em relacionamentos fortes.'),
(22, 'D-C-I', 'DESAFIADOR', 'Uma pessoa perseverante, com decisão forte, criativa na resolução de problemas.', 'Técnico/Científico (Direção, Gestão, Supervisão), Engenharia, Finanças.', 'Uma pessoa sensível aos problemas, com boa criatividade para resolvê-los. Ela pesquisa e busca todas as possibilidades na busca por soluções. Ela costuma oferecer muitas ideias focadas no trabalho. O esforço para ser precisa compensa sua vontade de alcançar resultados mensuráveis.'),
(21, 'Diretor', 'D-S-C', 'Quer se envolver, Quer Dar Ajuda e Suporte, Motivado por Metas Pessoais, Orientado para o Trabalho', 'Gestão de Escritório, Consultoria de Negócios, Recursos Humanos', 'Objetivo e analítico. Quer estar envolvido nas situações e dar apoio às pessoas que respeita. Motivado internamente por metas pessoais.'),
(20, 'Diretor', 'D-S-I', 'Quer se envolver, Quer Dar Ajuda e Suporte, Motivado por Metas Pessoais', 'Engenharia e Produção (Direção, Gestão, Supervisão), Gerente de Serviços, Distribuição', 'Objetivo e analítico. Quer estar envolvido nas situações e dar apoio às pessoas que respeita. Motivado internamente por metas pessoais, é orientado para o trabalho, mas valoriza os relacionamentos.'),
(19, 'Chanceler', 'D-I-C', 'Amigável por Natureza, Combina Diversão com Trabalho, Gosta de Relacionamentos', 'Finanças, Planejamento de Produção, Disciplina de Pessoal', 'Combina diversão com trabalho ao realizar suas tarefas. Gosta de relacionamentos e pode fazer o trabalho detalhado. Naturalmente amigável, gosta de interagir com os outros, mas avalia cuidadosamente as pessoas e tarefas. Sua amizade pode ser moldada conforme seus sentimentos pelos outros ao seu redor.'),
(18, 'Desafiante', 'D-C', 'Decisivo, Criativo na Solução de Problemas, Rápido nas Reações', 'Supervisor de Hospital, Marketing Industrial, Bancário de Investimentos', 'Determinado e rápido na reação. Pesquisa e explora todas as possibilidades ao buscar uma solução para problemas. Muitas vezes oferece ideias focadas no trabalho. O esforço pela precisão compensa seu desejo por resultados medidos.'),
(16, 'Perfeccionista', 'S / C-S', 'Detalhista, Sistemático e Procedural, Anti-Crítica', 'Estatístico, Topógrafo, Optometrista', 'Pensa de maneira sistemática e tende a seguir procedimentos na vida pessoal e no trabalho. Organizado e com um bom planejamento, é detalhista e focado. Age com sabedoria e diplomacia, raramente se opõe aos colegas de trabalho. Prefere diretrizes claras e sem mudanças repentinas.'),
(17, 'Pacificador, Respeit', 'S-C', 'Considera o Impacto nos Outros, Muito Profundo em Seu Pensamento, Preocupado com Dados e Fatos', 'Gestão de Escritório, Chefe de Escrita, Administrador Geral', 'Se preocupa com os outros ao seu redor e é muito cuidadoso ao concluir tarefas. Quando percebe que alguém está se aproveitando de uma situação, diminui o ritmo para observar o que está acontecendo ao seu redor.'),
(14, 'Responsivo e Reflexi', 'I-S-C / I-C-S', 'Alta Energia, Direto ao Ponto, Sensível', 'Atores, Chefes, Pessoal, Bem-estar', 'Indivíduo orientado para as pessoas, com fluidez na comunicação e lealdade. Tende a ser sensível e tem padrões elevados. Toma decisões baseadas em dados e fatos. Parece incapaz de ficar quieto. Precisa ser mais direto e menos subjetivo.'),
(15, 'Especialista', 'S', 'Estável e Consistente, Confortável nos Bastidores, Orientado para Processos', 'Trabalho Administrativo, Serviços Gerais, Jardineiro de Paisagismo', 'Indivíduo consistente, que busca manter o ambiente estável. Precisa de tempo para se ajustar a mudanças e tende a evitar confrontos. Busca manter seus sentimentos internos sem ser exposto.'),
(12, 'Mediador', 'I / C-I-S', 'Sensível, Boa Comunicação, Bom Pensamento Analítico', 'Relações Públicas, Administração, Administrador de Escritório', 'Indivíduo orientado para as pessoas, combina precisão e lealdade. Tende a ser sensível e tem padrões altos. Busca estabilidade e foca em objetivos. Deseja reconhecimento social e atenção pessoal.'),
(13, 'Praticante', 'I / C-S-I', 'Perfeccionista, Focado na Qualidade, Organizado', 'Pesquisa Química, Programador de Computador, Analista de Mercado', 'Amigável, entusiástico, informal, fala muito e se preocupa excessivamente com o que os outros pensam. Rejeita agressões e busca harmonia. Inteligente em diversas áreas e um ótimo coletor de dados. Tomará decisões sólidas depois de reunir informações e dados relevantes.'),
(11, 'Autossuficiente', 'D-S', 'Objetivo e Analítico, Independente, Bom Planejador', 'Pesquisador, Advogado, Procurador', 'Objetivo e analítico. Gosta de estar envolvido nas situações e também de dar apoio a pessoas que respeita. Internamente motivado por suas próprias metas, é orientado para o trabalho, mas valoriza as relações pessoais. Independente, meticuloso e segue suas atividades com bom acompanhamento.'),
(10, 'Diretor', 'D-I-S', 'Gestor, Energético, Pouco Detalhista', 'Gerente de Serviços, Gestão de Escritório, Gerente de Contas', 'Focado na execução e demonstra alta apreciação pelos outros. Tem a capacidade de motivar pessoas e tarefas por suas habilidades de pensar à frente e suas habilidades interpessoais. Não foca nos detalhes, prefere delegar essas tarefas a outros. Quando decide algo, continua até concluir.'),
(9, 'Tomador de Decisão', 'D-I', 'Líder, Frio/Orientado para Tarefas, Argumentativo', 'Gestão Geral (Direção/Gestão/Supervisão), Relações Públicas, Gestão de Negócios', 'Direto e assertivo, tende a ser um individualista forte. Tem uma visão progressista e gosta de competir para alcançar metas. Coloca padrões elevados nas pessoas ao seu redor e valoriza a perfeição. Prefere autoridade clara e tarefas novas.'),
(8, 'Inquisidor', 'D / S-D-C / S-C-D', 'Focado em Resultados, Rígido e Teimoso, Bom Atendimento', 'Gerente de Pesquisa, Trabalho Científico, Contador', 'Paciente, controlado e gosta de explorar fatos e soluções. É calmo e amigável. Planeja o trabalho com cuidado, mas é agressivo ao fazer perguntas e coletar dados. Consistente e útil, com habilidades interpessoais superiores à sua orientação para tarefas.'),
(7, 'Motivador', 'D / I-S-D', 'Apoiante, Socializa Bem, Precisa de Elogios e Reconhecimento', 'Hoteleiro, Conselheiro Comunitário, Gerente de Reclamações', 'Exibe um estilo animado quando motivado para alcançar suas metas. Prefere liderar ou se envolver, embora também esteja disposto a servir como assistente. Mostra excelentes habilidades de relacionamento e comunicação. Trabalha duro para completar tarefas com eficiência e rapidez.'),
(6, 'Reformador', 'D / I-D-S', 'Precisa de Elogios e Reconhecimento, Confia Rápido nas Pessoas, Empático e Simpático', 'Agente de Recrutamento, Vendas (Gerente/Pessoal), Serviços de Marketing', 'Cumpre suas tarefas através de suas habilidades sociais. Cuida dos outros e os aceita. Se concentra em concluir o trabalho e pede ajuda se necessário. É cativante e as pessoas gostam de ajudá-lo.'),
(4, 'Negociador', 'D / I-D', 'Muito Confiante, Agresivo, Otimista', 'Consultor de Recrutamento, Político, Autônomo', 'Um líder integrador que trabalha com e através de outras pessoas. Ele é amigável, atencioso e tem a capacidade de conquistar respeito de diferentes tipos de pessoas. Trabalha de forma amigável, tanto para alcançar seus objetivos quanto para convencer outros de suas ideias.'),
(5, 'Confiante e Determin', 'D / I-D-C', 'Dominante, Agresivo, Perfeccionista', 'Vendas de Seguro, Hipoteca e Finanças, Serviços de Pessoal e Marketing', 'Muito focado em tarefas e gosta de pessoas. É bom em atrair pessoas/recrutamento. É amigável, mas prefere que as tarefas sejam feitas corretamente. Precisa aprender a ouvir de verdade os outros ao invés de sempre pensar no que vai dizer. Tem alta capacidade lógica quando a usa.'),
(1, 'Lógico', 'C', 'Pendiam, Anti Crítica, Perfeccionista', 'Planejador (qualquer função), Engenheiro (Instalação, Técnico), Técnico/Pesquisa (Técnico Químico)', 'Uma pessoa prática, capaz e única. É alguém que consegue avaliar a si mesmo e é crítico consigo e com os outros.'),
(2, 'Estabilizador', 'D', 'Individualista, Ego Elevado, Pouco Sensível', 'Advogado, Pesquisador, Representante de Vendas', 'Tem um ego elevado e tende a ser individualista, com padrões muito altos. Prefere analisar problemas sozinho do que em grupo.'),
(3, 'Designer', 'D / C-D', 'Sensível, Focado em Resultados, Gosta de Desafios', 'Engenharia (Gestão, Pesquisa, Design), Pesquisa (P&D), Planejamento', 'Muito orientado para tarefas e sensível a problemas. Dá mais atenção ao trabalho do que às pessoas ao redor, incluindo seus colegas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_personalities`
--

CREATE TABLE `tbl_personalities` (
  `id` tinyint(2) NOT NULL,
  `no` tinyint(2) NOT NULL,
  `term` varchar(100) NOT NULL,
  `most` char(1) NOT NULL,
  `least` char(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tbl_personalities`
--

INSERT INTO `tbl_personalities` (`id`, `no`, `term`, `most`, `least`) VALUES
(63, 16, 'Regras criam tédio', 'I', 'I'),
(62, 16, 'Regras criam justiça', 'C', 'N'),
(61, 16, 'Questionador das regras', 'N', 'D'),
(60, 15, 'Cumpre regras', 'N', 'C'),
(59, 15, 'Busca equilíbrio', 'S', 'S'),
(58, 15, 'Rápido em ações', 'D', 'D'),
(57, 15, 'Falador', 'I', 'N'),
(56, 14, 'Preciso', 'C', 'N'),
(55, 14, 'Focado em resultados', 'D', 'N'),
(54, 14, 'Criativo', 'I', 'I'),
(53, 14, 'Confiável', 'N', 'S'),
(52, 13, 'Tem objetivos claros', 'D', 'N'),
(51, 13, 'Gosta de grupos', 'N', 'S'),
(50, 13, 'Perfeccionista', 'N', 'C'),
(49, 13, 'Motivador', 'I', 'I'),
(48, 12, 'Pacificador', 'S', 'S'),
(47, 12, 'Gosta de socializar', 'N', 'I'),
(46, 12, 'Visionário', 'D', 'D'),
(45, 12, 'Silencioso', 'C', 'N'),
(44, 11, 'Sistemático', 'N', 'C'),
(43, 11, 'Otimista', 'I', 'I'),
(42, 11, 'Gosta de desafios', 'D', 'D'),
(41, 11, 'Pensa nos outros primeiro', 'S', 'S'),
(40, 10, 'Persistente', 'I', 'N'),
(39, 10, 'Sem pressões', 'S', 'S'),
(38, 10, 'Segue o coração', 'D', 'D'),
(37, 10, 'Descontrolado', 'N', 'C'),
(36, 9, 'Organizado', 'N', 'C'),
(35, 9, 'Alegre', 'I', 'I'),
(34, 9, 'Segue a liderança', 'S', 'N'),
(33, 9, 'Difícil de ser derrotado', 'D', 'D'),
(32, 8, 'Delegador', 'D', 'D'),
(31, 8, 'Analítico', 'C', 'C'),
(30, 8, 'Bom ouvinte', 'S', 'S'),
(29, 8, 'Motivador', 'I', 'I'),
(28, 7, 'Competitivo', 'N', 'D'),
(27, 7, 'Evita confrontos', 'N', 'C'),
(26, 7, 'Facilidade em prometer', 'I', 'I'),
(25, 7, 'Planejado', 'S', 'N'),
(24, 6, 'Comprometido', 'S', 'S'),
(23, 6, 'Sociável', 'I', 'I'),
(22, 6, 'Apressado', 'D', 'D'),
(21, 6, 'Disciplinado', 'C', 'N'),
(20, 5, 'Espera recompensa', 'D', 'D'),
(19, 5, 'Gosta de novas aventuras', 'I', 'I'),
(18, 5, 'Preparado', 'C', 'N'),
(17, 5, 'Sociável', 'S', 'S'),
(16, 4, 'Pronto para desafiar', 'D', 'D'),
(15, 4, 'Compartilhar meu ponto de vista', 'N', 'I'),
(14, 4, 'Guardar sentimentos', 'S', 'S'),
(13, 4, 'Frustrado', 'C', 'C'),
(12, 3, 'Simplicidade', 'N', 'C'),
(11, 3, 'Sensível', 'I', 'N'),
(10, 3, 'Fácil de se contentar', 'S', 'N'),
(9, 3, 'Busca por progresso', 'D', 'D'),
(8, 2, 'Calmo', 'C', 'C'),
(7, 2, 'Destemido', 'D', 'D'),
(6, 2, 'Rir livremente', 'N', 'I'),
(5, 2, 'Agradar os outros', 'S', 'S'),
(4, 1, 'Busca por segurança', 'C', 'C'),
(3, 1, 'Inovador', 'D', 'D'),
(2, 1, 'Ocupado', 'N', 'I'),
(1, 1, 'Empático', 'S', 'N'),
(64, 16, 'Regras criam segurança', 'S', 'S'),
(65, 17, 'Educação', 'N', 'C'),
(66, 17, 'Realizações', 'D', 'D'),
(67, 17, 'Segurança', 'S', 'S'),
(68, 17, 'Social', 'I', 'N'),
(69, 18, 'Liderança', 'D', 'D'),
(70, 18, 'Entusiasta', 'N', 'I'),
(71, 18, 'Consistente', 'N', 'S'),
(72, 18, 'Alerta', 'C', 'N'),
(73, 19, 'Focado em resultados', 'D', 'D'),
(74, 19, 'Preciso', 'C', 'C'),
(75, 19, 'Torna divertido', 'N', 'I'),
(76, 19, 'Colaborativo', 'N', 'S'),
(77, 20, 'Eu os liderarei', 'D', 'N'),
(78, 20, 'Eu os farei realizar', 'S', 'S'),
(79, 20, 'Eu os convencia', 'I', 'I'),
(80, 20, 'Eu obtive os fatos', 'C', 'N'),
(81, 21, 'Fácil de concordar', 'S', 'S'),
(82, 21, 'Fácil de acreditar', 'I', 'I'),
(83, 21, 'Aventureiro', 'N', 'D'),
(84, 21, 'Tolerante', 'C', 'C'),
(85, 22, 'Desiste facilmente', 'N', 'S'),
(86, 22, 'Detalhista', 'C', 'N'),
(87, 22, 'Fácil de mudar', 'I', 'I'),
(88, 22, 'Rude', 'D', 'D'),
(89, 23, 'Busca mais autoridade', 'N', 'D'),
(90, 23, 'Busca novas oportunidades', 'I', 'N'),
(91, 23, 'Evita conflitos', 'S', 'S'),
(92, 23, 'Busca instruções claras', 'N', 'C'),
(93, 24, 'Calmo', 'C', 'C'),
(94, 24, 'Sem preocupações', 'I', 'I'),
(95, 24, 'Bondoso', 'S', 'N'),
(96, 24, 'Corajoso', 'D', 'D');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_results`
--

CREATE TABLE `tbl_results` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `d` float NOT NULL,
  `i` float NOT NULL,
  `s` float NOT NULL,
  `c` float NOT NULL,
  `line` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `tbl_results`
--

INSERT INTO `tbl_results` (`id`, `value`, `d`, `i`, `s`, `c`, `line`) VALUES
(1, 0, -6, -7, -5.7, -6, 1),
(2, 1, -5.3, -4.6, -4.3, -4.7, 1),
(3, 2, -4, -2.5, -3.5, -3.5, 1),
(4, 3, -2.5, -1.3, -1.5, -1.5, 1),
(5, 4, -1.7, 1, -0.7, 0.5, 1),
(6, 5, -1.3, 3, 0.5, 2, 1),
(7, 6, 0, 3.5, 1, 3, 1),
(8, 7, 0.5, 5.3, 2.5, 5.3, 1),
(9, 8, 1, 5.7, 3, 5.7, 1),
(10, 9, 2, 6, 4, 6, 1),
(11, 10, 3, 6.5, 4.6, 6.3, 1),
(12, 11, 3.5, 7, 5, 6.5, 1),
(13, 12, 4, 7, 5.7, 6.7, 1),
(14, 13, 4.7, 7, 6, 7, 1),
(15, 14, 5.3, 7, 6.5, 7.3, 1),
(16, 15, 6.5, 7, 6.5, 7.3, 1),
(17, 16, 7, 7.5, 7, 7.3, 1),
(18, 17, 7, 7.5, 7, 7.5, 1),
(19, 18, 7, 7.5, 7, 8, 1),
(20, 19, 7.5, 7.5, 7.5, 8, 1),
(21, 20, 7.5, 8, 7.5, 8, 1),
(22, 0, 7.5, 7, 7.5, 7.5, 2),
(23, 1, 6.5, 6, 7, 7, 2),
(24, 2, 4.3, 4, 6, 5.6, 2),
(25, 3, 2.5, 2.5, 4, 4, 2),
(26, 4, 1.5, 0.5, 2.5, 2.5, 2),
(27, 5, 0.5, 0, 1.5, 1.5, 2),
(28, 6, 0, -2, 0.5, 0.5, 2),
(29, 7, -1.3, -3.5, -1.3, 0, 2),
(30, 8, -1.5, -4.3, -2, -1.3, 2),
(31, 9, -2.5, -5.3, -3, -2.5, 2),
(32, 10, -3, -6, -4.3, -3.5, 2),
(33, 11, -3.5, -6.5, -5.3, -5.3, 2),
(34, 12, -4.3, -7, -6, -5.7, 2),
(35, 13, -5.3, -7.2, -6.5, -6, 2),
(36, 14, -5.7, -7.2, -6.7, -6.5, 2),
(37, 15, -6, -7.2, -6.7, -7, 2),
(38, 16, -6.5, -7.3, -7, -7.3, 2),
(39, 17, 6.7, -7.3, -7.2, -7.5, 2),
(40, 18, 7, -7.3, -7.3, -7.7, 2),
(41, 19, -7.3, -7.5, -7.5, -7.9, 2),
(42, 20, -7.5, -8, -8, -8, 2),
(43, -22, -8, -8, -8, -7.5, 3),
(44, -21, -7.5, -8, -8, -7.3, 3),
(45, -20, -7, -8, -8, -7.3, 3),
(46, -19, -6.8, -8, -8, -7, 3),
(47, -18, -6.75, -7, -7.5, -6.7, 3),
(48, -17, -6.7, -6.7, -7.3, -6.7, 3),
(49, -16, -6.5, -6.7, -7.3, -6.7, 3),
(50, -15, -6.3, -6.7, -7, -6.5, 3),
(51, -14, -6.1, -6.7, -6.5, -6.3, 3),
(52, -13, -5.9, -6.7, -6.5, -6, 3),
(53, -12, -5.7, -6.7, -6.5, -5.85, 3),
(54, -11, -5.3, -6.7, -6.5, -5.85, 3),
(55, -10, -4.3, -6.5, -6, -5.7, 3),
(56, -9, -3.5, -6, -4.7, -4.7, 3),
(57, -8, -3.25, -5.7, -4.3, -4.3, 3),
(58, -7, -3, -4.7, -3.5, -3.5, 3),
(59, -6, -2.75, -4.3, -3, -3, 3),
(60, -5, -2.5, -3.5, -2, -2.5, 3),
(61, -4, -1.5, -3, -1.5, -0.5, 3),
(62, -3, -1, -2, -1, 0, 3),
(63, -2, -0.5, -1.5, -0.5, 0.3, 3),
(64, -1, -0.25, 0, 0, 0.5, 3),
(65, 0, 0, 0.5, 1, 1.5, 3),
(66, 1, 0.5, 1, 1.5, 3, 3),
(67, 2, 0.7, 1.5, 2, 4, 3),
(68, 3, 1, 3, 3, 4.3, 3),
(69, 4, 1.3, 4, 3.5, 5.5, 3),
(70, 5, 1.5, 4.3, 4, 5.7, 3),
(71, 6, 2, 5, 4.3, 6, 3),
(72, 7, 2.5, 5.5, 4.7, 6.3, 3),
(73, 8, 3.5, 6.5, 5, 6.5, 3),
(74, 9, 4, 6.7, 5.5, 6.7, 3),
(75, 10, 4.7, 7, 6, 7, 3),
(76, 11, 4.85, 7.3, 6.2, 7.3, 3),
(77, 12, 5, 7.3, 6.3, 7.3, 3),
(78, 13, 5.5, 7.3, 6.5, 7.3, 3),
(79, 14, 6, 7.3, 6.7, 7.3, 3),
(80, 15, 6.3, 7.3, 7, 7.3, 3),
(81, 16, 6.5, 7.3, 7.3, 7.3, 3),
(82, 17, 6.7, 7.3, 7.3, 7.5, 3),
(83, 18, 7, 7.5, 7.3, 8, 3),
(84, 19, 7.3, 8, 7.3, 8, 3),
(85, 20, 7.3, 8, 7.5, 8, 3),
(86, 21, 7.5, 8, 8, 8, 3),
(87, 22, 8, 8, 8, 8, 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_patterns`
--
ALTER TABLE `tbl_patterns`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_personalities`
--
ALTER TABLE `tbl_personalities`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_results`
--
ALTER TABLE `tbl_results`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_patterns`
--
ALTER TABLE `tbl_patterns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `tbl_personalities`
--
ALTER TABLE `tbl_personalities`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de tabela `tbl_results`
--
ALTER TABLE `tbl_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
