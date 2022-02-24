-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24-Fev-2022 às 13:35
-- Versão do servidor: 5.7.35-cll-lve
-- versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tccdaniel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id_aluno` varchar(220) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `id_turma` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamado`
--

CREATE TABLE `chamado` (
  `id_chamado` varchar(220) NOT NULL,
  `id_usuario` varchar(220) DEFAULT NULL,
  `id_responsavel` varchar(220) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `tela` varchar(100) DEFAULT NULL,
  `descricao` varchar(750) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `codigoconfirmacao`
--

CREATE TABLE `codigoconfirmacao` (
  `id_codigo` varchar(220) NOT NULL,
  `id_usuario` varchar(220) NOT NULL,
  `codigo` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinatarioemail`
--

CREATE TABLE `destinatarioemail` (
  `id_destinatarioemail` varchar(200) NOT NULL,
  `id_usuario` varchar(220) DEFAULT NULL,
  `id_email` varchar(220) DEFAULT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destinatarionotificacao`
--

CREATE TABLE `destinatarionotificacao` (
  `id_dest_not` varchar(220) NOT NULL,
  `id_notificacao` varchar(220) DEFAULT NULL,
  `id_usuario` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emaillistanegra`
--

CREATE TABLE `emaillistanegra` (
  `id_emaillistanegra` varchar(220) NOT NULL,
  `email` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `encaminhamento`
--

CREATE TABLE `encaminhamento` (
  `id_encaminhamento` varchar(220) NOT NULL,
  `id_servidor` varchar(220) DEFAULT NULL,
  `id_aluno` varchar(220) NOT NULL,
  `id_motivo` varchar(220) DEFAULT NULL,
  `id_recurso` varchar(220) DEFAULT NULL,
  `id_sugestao` varchar(220) DEFAULT NULL,
  `data_ocorrencia` datetime DEFAULT NULL,
  `data_encaminhamento` datetime DEFAULT CURRENT_TIMESTAMP,
  `relato` text,
  `disciplina` varchar(500) DEFAULT NULL,
  `frequencia` int(1) DEFAULT NULL,
  `setor` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicologin`
--

CREATE TABLE `historicologin` (
  `id_historicologin` varchar(220) NOT NULL,
  `id_usuario` varchar(220) NOT NULL,
  `data` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `id_mensagem` varchar(220) NOT NULL,
  `id_chamado` varchar(220) DEFAULT NULL,
  `id_usuario` varchar(220) DEFAULT NULL,
  `from_user` int(1) NOT NULL,
  `mensagem` varchar(1500) DEFAULT NULL,
  `hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `id_notificacao` varchar(220) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `imageUrl` varchar(150) DEFAULT NULL,
  `id_agendamento` int(11) DEFAULT NULL,
  `urlDestino` varchar(150) DEFAULT NULL,
  `prioridade` int(11) DEFAULT '0',
  `mensagemGeral` int(11) DEFAULT '0',
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enviado` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `id_resposta` varchar(220) NOT NULL,
  `id_servidor` varchar(220) DEFAULT NULL,
  `id_encaminhamento` varchar(220) DEFAULT NULL,
  `resposta` text,
  `data_resposta` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `selectoption`
--

CREATE TABLE `selectoption` (
  `id_option` varchar(220) NOT NULL,
  `texto` varchar(150) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `setor` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `snapshot`
--

CREATE TABLE `snapshot` (
  `id_snap` int(11) NOT NULL,
  `data` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuarios_novos` int(11) DEFAULT NULL,
  `assinaturas_novas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `trocasenha`
--

CREATE TABLE `trocasenha` (
  `id_troSenha` varchar(220) NOT NULL,
  `id_usuario` varchar(220) DEFAULT NULL,
  `hora` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` varchar(220) NOT NULL,
  `nome` varchar(70) NOT NULL,
  `senha` varchar(500) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `codigo_parceiro` varchar(100) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_confirmado` int(1) NOT NULL DEFAULT '1',
  `telefone_confirmado` int(1) NOT NULL DEFAULT '1',
  `administrador` int(1) NOT NULL,
  `ativo` int(1) NOT NULL,
  `deletado` int(1) NOT NULL,
  `facebook_id` varchar(150) NOT NULL,
  `is_foto_url` int(1) NOT NULL DEFAULT '0',
  `pre_cadastro` int(1) DEFAULT '0',
  `cep` varchar(20) DEFAULT NULL,
  `cidade` varchar(220) DEFAULT NULL,
  `estado` varchar(220) DEFAULT NULL,
  `bairro` varchar(220) DEFAULT NULL,
  `rua` varchar(220) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(220) DEFAULT NULL,
  `novo_cadastro` int(1) NOT NULL DEFAULT '1',
  `receber_email` int(1) DEFAULT '1',
  `receber_email_sistema` int(1) DEFAULT '1',
  `setor` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `senha`, `cpf`, `email`, `telefone`, `data_nasc`, `foto`, `token`, `codigo_parceiro`, `data_cadastro`, `email_confirmado`, `telefone_confirmado`, `administrador`, `ativo`, `deletado`, `facebook_id`, `is_foto_url`, `pre_cadastro`, `cep`, `cidade`, `estado`, `bairro`, `rua`, `numero`, `complemento`, `novo_cadastro`, `receber_email`, `receber_email_sistema`, `setor`) VALUES
('314d2f16-5041-4df3-b9b1-9dfa5148db35', 'Teste', '$2y$10$jg1nNpweyGqg9yrh/RRAFuYu9TpvW7b2qlm0FwVdJdBIAdnar8Fv2', '', 'teste@teste.com', '21111654444', NULL, 'Img/Perfil/default.png', '', '', '2021-12-12 16:49:20', 0, 1, 0, 0, 1, '', 0, 0, '', '', '', '', '', '', '', 1, 1, 1, 0),
('46875794-5f99-4a66-8a2f-54813ee9f395', 'exemplo2', '$2y$10$WslIEe5IVY5VnwvAneZGWulSr3CbVLoQs3BxoWMqm/vBOwZsCkpyW', '', 'exemplo2@iffarroupilha.edu.br', '22222222222', NULL, 'Img/Perfil/default.png', '', '', '2021-12-12 21:32:02', 0, 1, 0, 0, 0, '', 0, 0, '', '', '', '', '', '', '', 1, 1, 1, 0),
('7803a5db-1a07-453c-90b2-a59e8d8e1766', 'Daniel Zanini de Castro', '$2y$10$A9.nB56qLzX43ONn0wgc1.t4cktbok7HUmIOksY8vaMiPCtEKNasu', '', 'zanini.castro@gmail.com', '55999598414', NULL, 'Img/Perfil/493e6f0b8324a32e721558e157bb83b5.gif', '', '97760-000', '2021-11-02 08:40:28', 1, 1, 2, 1, 0, '', 0, 0, '', '', '', '', '', '', '', 1, 1, 1, 1),
('817b2150-49e1-4ad8-b541-dda961a41f80', 'Administrador', '$2y$10$waNiyM90M2RISWw3z00VRus78L59P9yZVOUTcjyjT6suUDlfJ9zlC', '', 'administrador', '00000000000', NULL, 'Img/Perfil/6f84dad1ff4d4124a94bb49772350712.webp', '', '', '2021-12-12 15:42:56', 1, 1, 1, 1, 0, '', 0, 0, '', '', '', '', '', '', '', 1, 1, 1, 1),
('c2afc8c6-0c60-41b7-9ac9-4787a65b28a5', 'Exemplo1', '$2y$10$jFsFvnrXagFJE6ywEaOW.OHq7cXRLN4jJTDxg9FECEm4tFusOTvv6', '', 'exemplo1@iffarroupilha.edu.br', '11111111111', NULL, 'Img/Perfil/default.png', '', '', '2021-12-12 21:29:09', 1, 1, 0, 1, 0, '', 0, 0, '', '', '', '', '', '', '', 1, 1, 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id_aluno`),
  ADD KEY `id_turma` (`id_turma`);

--
-- Índices para tabela `chamado`
--
ALTER TABLE `chamado`
  ADD PRIMARY KEY (`id_chamado`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_responsavel` (`id_responsavel`);

--
-- Índices para tabela `codigoconfirmacao`
--
ALTER TABLE `codigoconfirmacao`
  ADD PRIMARY KEY (`id_codigo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `destinatarioemail`
--
ALTER TABLE `destinatarioemail`
  ADD PRIMARY KEY (`id_destinatarioemail`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_email` (`id_email`);

--
-- Índices para tabela `destinatarionotificacao`
--
ALTER TABLE `destinatarionotificacao`
  ADD PRIMARY KEY (`id_dest_not`),
  ADD KEY `id_notificacao` (`id_notificacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `emaillistanegra`
--
ALTER TABLE `emaillistanegra`
  ADD PRIMARY KEY (`id_emaillistanegra`);

--
-- Índices para tabela `encaminhamento`
--
ALTER TABLE `encaminhamento`
  ADD PRIMARY KEY (`id_encaminhamento`),
  ADD KEY `id_aluno` (`id_aluno`),
  ADD KEY `id_motivo` (`id_motivo`),
  ADD KEY `id_recurso` (`id_recurso`),
  ADD KEY `id_sugestao` (`id_sugestao`),
  ADD KEY `id_servidor` (`id_servidor`);

--
-- Índices para tabela `historicologin`
--
ALTER TABLE `historicologin`
  ADD PRIMARY KEY (`id_historicologin`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_chamado` (`id_chamado`);

--
-- Índices para tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`id_notificacao`);

--
-- Índices para tabela `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`id_resposta`),
  ADD KEY `id_servidor` (`id_servidor`),
  ADD KEY `id_encaminhamento` (`id_encaminhamento`);

--
-- Índices para tabela `selectoption`
--
ALTER TABLE `selectoption`
  ADD PRIMARY KEY (`id_option`);

--
-- Índices para tabela `snapshot`
--
ALTER TABLE `snapshot`
  ADD PRIMARY KEY (`id_snap`);

--
-- Índices para tabela `trocasenha`
--
ALTER TABLE `trocasenha`
  ADD PRIMARY KEY (`id_troSenha`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cpf` (`cpf`,`email`,`telefone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `snapshot`
--
ALTER TABLE `snapshot`
  MODIFY `id_snap` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`id_turma`) REFERENCES `selectoption` (`id_option`);

--
-- Limitadores para a tabela `chamado`
--
ALTER TABLE `chamado`
  ADD CONSTRAINT `chamado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `chamado_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `chamado_ibfk_4` FOREIGN KEY (`id_responsavel`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `codigoconfirmacao`
--
ALTER TABLE `codigoconfirmacao`
  ADD CONSTRAINT `codigoconfirmacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `destinatarioemail`
--
ALTER TABLE `destinatarioemail`
  ADD CONSTRAINT `destinatarioemail_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `destinatarioemail_ibfk_2` FOREIGN KEY (`id_email`) REFERENCES `emailbroadcast` (`id_email`);

--
-- Limitadores para a tabela `destinatarionotificacao`
--
ALTER TABLE `destinatarionotificacao`
  ADD CONSTRAINT `destinatarionotificacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `destinatarionotificacao_ibfk_2` FOREIGN KEY (`id_notificacao`) REFERENCES `notificacao` (`id_notificacao`);

--
-- Limitadores para a tabela `encaminhamento`
--
ALTER TABLE `encaminhamento`
  ADD CONSTRAINT `encaminhamento_ibfk_2` FOREIGN KEY (`id_motivo`) REFERENCES `selectoption` (`id_option`),
  ADD CONSTRAINT `encaminhamento_ibfk_3` FOREIGN KEY (`id_recurso`) REFERENCES `selectoption` (`id_option`),
  ADD CONSTRAINT `encaminhamento_ibfk_4` FOREIGN KEY (`id_sugestao`) REFERENCES `selectoption` (`id_option`),
  ADD CONSTRAINT `encaminhamento_ibfk_5` FOREIGN KEY (`id_servidor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `encaminhamento_ibfk_6` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`);

--
-- Limitadores para a tabela `historicologin`
--
ALTER TABLE `historicologin`
  ADD CONSTRAINT `historicologin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_chamado`) REFERENCES `chamado` (`id_chamado`);

--
-- Limitadores para a tabela `resposta`
--
ALTER TABLE `resposta`
  ADD CONSTRAINT `resposta_ibfk_1` FOREIGN KEY (`id_servidor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `resposta_ibfk_2` FOREIGN KEY (`id_encaminhamento`) REFERENCES `encaminhamento` (`id_encaminhamento`);

--
-- Limitadores para a tabela `trocasenha`
--
ALTER TABLE `trocasenha`
  ADD CONSTRAINT `trocasenha_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
