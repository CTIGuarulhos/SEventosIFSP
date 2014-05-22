-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 30, 2013 as 10:30 AM
-- Versão do Servidor: 5.0.96
-- Versão do PHP: 5.2.4-2ubuntu5.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `eventos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL auto_increment,
  `data` date NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `album` varchar(60) NOT NULL,
  `semtec` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `edicao`
--

CREATE TABLE IF NOT EXISTS `edicao` (
  `SEMTEC` varchar(11) NOT NULL,
  `NOME` varchar(100) NOT NULL,
  `CADASTRO` varchar(7) NOT NULL default 'fechado',
  `TEMPLATE` varchar(15) NOT NULL default 'Default',
  `URL_INST` varchar(50) NOT NULL,
  `NOME_INST_RED` varchar(30) NOT NULL,
  `NOME_INST_COMP` varchar(200) NOT NULL,
  `ENDERECO_L1` varchar(60) NOT NULL,
  `ENDERECO_L2` varchar(60) NOT NULL,
  `URL_MAPS_IFRAME` varchar(1000) NOT NULL,
  `URL_MAPS` varchar(200) NOT NULL,
  `DIA_INICIO` varchar(2) NOT NULL,
  `DIA_FIM` varchar(2) NOT NULL,
  `MES` varchar(2) NOT NULL,
  `ANO` varchar(4) NOT NULL,
  `HORA` varchar(2) NOT NULL,
  `MINUTO` varchar(2) NOT NULL,
  `LIBERACAO` int(11) NOT NULL default '10',
  `APRESENTACAO` mediumtext NOT NULL,
  `DATASIMPORTANTES` mediumtext NOT NULL,
  `COMISSAOORGANIZADORA` mediumtext NOT NULL,
  `PALESTRANTESCONFIRMADOS` mediumtext NOT NULL,
  UNIQUE KEY `SEMTEC` (`SEMTEC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id` int(11) NOT NULL auto_increment,
  `sigla` varchar(5) default NULL,
  `tipo` char(1) NOT NULL COMMENT '0=outros | 1=palestra | 2=mini-curso | 3=mesa redonda | 4=apresentação',
  `titulo` varchar(127) NOT NULL,
  `descricao` text NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `local` varchar(50) NOT NULL,
  `duracao` int(5) NOT NULL,
  `vagas` int(3) default NULL,
  `semtec` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `semtec` (`semtec`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `inscricoesinvalidas`
--
CREATE TABLE IF NOT EXISTS `inscricoesinvalidas` (
`cpf_participante` varchar(15)
,`id_evento` int(11)
,`presenca` tinyint(1)
);
-- --------------------------------------------------------

--
-- Estrutura da tabela `palestrante`
--

CREATE TABLE IF NOT EXISTS `palestrante` (
  `codigo` int(11) NOT NULL auto_increment,
  `palestrante` varchar(90) NOT NULL,
  `sumario` varchar(9999) NOT NULL,
  PRIMARY KEY  (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `participacoes`
--

CREATE TABLE IF NOT EXISTS `participacoes` (
  `cpf_participante` varchar(15) NOT NULL,
  `tipo` varchar(1) NOT NULL default 'P',
  `id_evento` int(11) NOT NULL,
  `data_inscricao` datetime default NULL,
  `presenca` tinyint(1) default NULL,
  `data_visualizacao` datetime default NULL,
  `verificacao` varchar(32) default NULL,
  PRIMARY KEY  (`cpf_participante`,`id_evento`),
  KEY `id_evento` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `participantes`
--

CREATE TABLE IF NOT EXISTS `participantes` (
  `cpf` varchar(15) NOT NULL,
  `documento` varchar(3) NOT NULL default 'sim',
  `nome` varchar(50) default NULL,
  `rg` varchar(20) default NULL,
  `rua` varchar(50) default NULL,
  `numero` int(5) default NULL,
  `complemento` varchar(15) default NULL,
  `bairro` varchar(30) default NULL,
  `cidade` varchar(30) default NULL,
  `estado` char(2) default NULL,
  `pais` varchar(20) default NULL,
  `cep` varchar(10) default NULL,
  `inst_empresa` varchar(100) default NULL,
  `telefone` varchar(15) default NULL,
  `tel_celular` varchar(15) default NULL,
  `email` varchar(50) default NULL,
  `senha` varchar(35) default NULL,
  `data_inscricao` datetime NOT NULL,
  `tipo` char(1) default NULL,
  `RA` varchar(7) default NULL,
  `cod_confirmacao` varchar(14) default NULL,
  `confirmado` tinyint(1) default '0',
  `admin` int(1) NOT NULL default '0' COMMENT '1 para sim 0 para não',
  `eventos` varchar(90) default NULL,
  PRIMARY KEY  (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `part_palestrante`
--

CREATE TABLE IF NOT EXISTS `part_palestrante` (
  `codigo` int(11) NOT NULL auto_increment,
  `cod_palestrante` int(11) NOT NULL,
  `cod_palestra` int(11) NOT NULL,
  PRIMARY KEY  (`codigo`),
  UNIQUE KEY `cod_palestrante` (`cod_palestrante`,`cod_palestra`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Insere Dados de Administrador
--
INSERT IGNORE INTO `participantes` (`cpf`, `documento`, `nome`, `rg`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `pais`, `cep`, `inst_empresa`, `telefone`, `tel_celular`, `email`, `senha`, `data_inscricao`, `tipo`, `RA`, `cod_confirmacao`, `confirmado`, `admin`, `eventos`) VALUES ('0', 'sim', 'Administrador', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', '1980-01-01 00:00:00', NULL, NULL, NULL, '1', '8', NULL);

-- --------------------------------------------------------

--
-- Estrutura para visualizar `inscricoesinvalidas`
--
DROP TABLE IF EXISTS `inscricoesinvalidas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `eventos`.`inscricoesinvalidas` AS select `p`.`cpf_participante` AS `cpf_participante`,`p`.`id_evento` AS `id_evento`,`p`.`presenca` AS `presenca` from `eventos`.`participacoes` `p` where (not(`p`.`id_evento` in (select `eventos`.`eventos`.`id` AS `id` from `eventos`.`eventos`)));


