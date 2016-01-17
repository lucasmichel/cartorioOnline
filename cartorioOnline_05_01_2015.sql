-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2016 at 02:36 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cartorioOnline`
--

-- --------------------------------------------------------

--
-- Table structure for table `CAD_ACO_ACOES`
--

CREATE TABLE IF NOT EXISTS `CAD_ACO_ACOES` (
  `ACO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACO_Descricao` varchar(45) NOT NULL,
  `ACO_Status` char(1) NOT NULL COMMENT 'A => Ativo, I => Inativo',
  PRIMARY KEY (`ACO_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `CAD_ACO_ACOES`
--

INSERT INTO `CAD_ACO_ACOES` (`ACO_ID`, `ACO_Descricao`, `ACO_Status`) VALUES
(1, 'Salvar', 'A'),
(2, 'Alterar', 'A'),
(3, 'Consultar', 'A'),
(4, 'Excluir', 'A'),
(5, 'AUXILIAR_COMPLETO', 'A'),
(6, 'PREVIO_COMPLETO', 'A'),
(7, 'StatusConclusaoLinhaPrevio', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_FAC_FORMULARIOS_ACOES`
--

CREATE TABLE IF NOT EXISTS `CAD_FAC_FORMULARIOS_ACOES` (
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  PRIMARY KEY (`ACO_ID`,`FRM_ID`),
  KEY `FK_CAD_ACO_FRM` (`FRM_ID`),
  KEY `FK_CAD_FRM_ACO` (`ACO_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_FAC_FORMULARIOS_ACOES`
--

INSERT INTO `CAD_FAC_FORMULARIOS_ACOES` (`ACO_ID`, `FRM_ID`) VALUES
(3, 1),
(3, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(3, 7),
(3, 8),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(1, 12),
(2, 12),
(3, 12),
(4, 12),
(5, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 13),
(1, 14),
(2, 14),
(3, 14),
(4, 14),
(1, 15),
(2, 15),
(3, 15),
(4, 15),
(6, 15),
(7, 15),
(1, 16),
(2, 16),
(3, 16);

-- --------------------------------------------------------

--
-- Table structure for table `CAD_FRM_FORMULARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_FRM_FORMULARIOS` (
  `FRM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FRM_Descricao` varchar(45) NOT NULL,
  `FRM_Caminho` varchar(150) NOT NULL,
  `FRM_Status` char(1) NOT NULL COMMENT 'A => Ativo, I => Inativo',
  PRIMARY KEY (`FRM_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Relaciona os menus.' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `CAD_FRM_FORMULARIOS`
--

INSERT INTO `CAD_FRM_FORMULARIOS` (`FRM_ID`, `FRM_Descricao`, `FRM_Caminho`, `FRM_Status`) VALUES
(1, 'Cadastro de Modulos', 'frmModulo.php', 'A'),
(2, 'Cadastro de Categorias de Modulos', 'frmModuloCategoria.php', 'A'),
(3, 'Cadastro de Formulários', 'frmFormulario.php', 'A'),
(4, 'Controle de Permissões do Sistema', 'frmPermissao.php', 'A'),
(5, 'Controle de Grupos de Usuários', 'frmGrupo.php', 'A'),
(6, 'Controle de Usuários', 'frmUsuario.php', 'A'),
(7, 'Relatório dos Usuários', 'relAcessoUsuario.php', 'A'),
(8, 'Relatório de Grupos de Usuários', 'relGruposUsuario.php', 'A'),
(9, 'Cadastro Tipos de Linhas', 'frmTipoLinhaLivro.php', 'A'),
(10, 'Cadastro Livro Auxiliar', 'frmLivroAuxiliar.php', 'A'),
(11, 'Cadastro Folha Auxiliar', 'frmFolhaAuxiliar.php', 'A'),
(12, 'Cadastro Linha Auxiliar', 'frmLinhaAuxiliar.php', 'A'),
(13, 'Cadastro Livro Prévio', 'frmLivroPrevio.php', 'A'),
(14, 'Cadastro Folha Prévio', 'frmFolhaPrevio.php', 'A'),
(15, 'Cadastro Linha Prévio', 'frmLinhaPrevio.php', 'A'),
(16, 'Configuração do sistema', 'frmParametro.php', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_GPE_GRUPOS_PERMISSOES`
--

CREATE TABLE IF NOT EXISTS `CAD_GPE_GRUPOS_PERMISSOES` (
  `GRU_ID` int(11) NOT NULL,
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  PRIMARY KEY (`GRU_ID`,`ACO_ID`,`FRM_ID`),
  KEY `FK_GPE_FRM_ID_ACO_ID` (`ACO_ID`,`FRM_ID`),
  KEY `FK_GPE_GRU_ID` (`GRU_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_GPE_GRUPOS_PERMISSOES`
--

INSERT INTO `CAD_GPE_GRUPOS_PERMISSOES` (`GRU_ID`, `ACO_ID`, `FRM_ID`) VALUES
(1, 1, 3),
(1, 1, 4),
(1, 1, 5),
(1, 1, 6),
(1, 1, 9),
(1, 1, 10),
(1, 1, 11),
(1, 1, 12),
(1, 1, 13),
(1, 1, 14),
(1, 1, 15),
(1, 1, 16),
(1, 2, 3),
(1, 2, 4),
(1, 2, 5),
(1, 2, 6),
(1, 2, 9),
(1, 2, 10),
(1, 2, 11),
(1, 2, 12),
(1, 2, 13),
(1, 2, 14),
(1, 2, 15),
(1, 2, 16),
(1, 3, 1),
(1, 3, 2),
(1, 3, 3),
(1, 3, 4),
(1, 3, 5),
(1, 3, 6),
(1, 3, 7),
(1, 3, 8),
(1, 3, 9),
(1, 3, 10),
(1, 3, 11),
(1, 3, 12),
(1, 3, 13),
(1, 3, 14),
(1, 3, 15),
(1, 3, 16),
(1, 4, 3),
(1, 4, 4),
(1, 4, 5),
(1, 4, 6),
(1, 4, 9),
(1, 4, 10),
(1, 4, 11),
(1, 4, 12),
(1, 4, 13),
(1, 4, 14),
(1, 4, 15),
(1, 5, 12),
(1, 6, 15),
(1, 7, 15),
(2, 1, 11),
(2, 1, 12),
(2, 1, 14),
(2, 1, 15),
(2, 2, 11),
(2, 2, 12),
(2, 2, 14),
(2, 2, 15),
(2, 3, 11),
(2, 3, 12),
(2, 3, 14),
(2, 3, 15),
(2, 5, 12),
(2, 6, 15),
(2, 7, 15),
(3, 1, 3),
(3, 1, 4),
(3, 1, 5),
(3, 1, 6),
(3, 1, 9),
(3, 1, 10),
(3, 1, 11),
(3, 1, 12),
(3, 1, 13),
(3, 1, 14),
(3, 1, 15),
(3, 1, 16),
(3, 2, 3),
(3, 2, 4),
(3, 2, 5),
(3, 2, 6),
(3, 2, 9),
(3, 2, 10),
(3, 2, 11),
(3, 2, 12),
(3, 2, 13),
(3, 2, 14),
(3, 2, 15),
(3, 2, 16),
(3, 3, 1),
(3, 3, 2),
(3, 3, 3),
(3, 3, 4),
(3, 3, 5),
(3, 3, 6),
(3, 3, 7),
(3, 3, 8),
(3, 3, 9),
(3, 3, 10),
(3, 3, 11),
(3, 3, 12),
(3, 3, 13),
(3, 3, 14),
(3, 3, 15),
(3, 3, 16),
(3, 4, 3),
(3, 4, 4),
(3, 4, 5),
(3, 4, 6),
(3, 4, 9),
(3, 4, 10),
(3, 4, 11),
(3, 4, 12),
(3, 4, 13),
(3, 4, 14),
(3, 4, 15),
(3, 5, 12),
(3, 6, 15),
(3, 7, 15),
(4, 1, 10),
(4, 1, 11),
(4, 1, 12),
(4, 1, 13),
(4, 1, 14),
(4, 1, 15),
(4, 2, 10),
(4, 2, 11),
(4, 2, 12),
(4, 2, 13),
(4, 2, 14),
(4, 2, 15),
(4, 3, 10),
(4, 3, 11),
(4, 3, 12),
(4, 3, 13),
(4, 3, 14),
(4, 3, 15),
(4, 4, 10),
(4, 4, 11),
(4, 4, 12),
(4, 4, 13),
(4, 4, 14),
(4, 4, 15),
(4, 5, 12),
(4, 6, 15),
(4, 7, 15);

-- --------------------------------------------------------

--
-- Table structure for table `CAD_GRU_GRUPOS_USUARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_GRU_GRUPOS_USUARIOS` (
  `GRU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `GRU_Descricao` varchar(45) NOT NULL,
  `GRU_Status` char(1) NOT NULL DEFAULT 'I',
  PRIMARY KEY (`GRU_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Grupos de usuários. (Perfis)' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `CAD_GRU_GRUPOS_USUARIOS`
--

INSERT INTO `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`, `GRU_Descricao`, `GRU_Status`) VALUES
(1, 'ADMINISTRADOR', 'A'),
(2, 'USERS', 'A'),
(3, 'SUPORTE', 'A'),
(4, 'GERENTE', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_LOG_LOGS`
--

CREATE TABLE IF NOT EXISTS `CAD_LOG_LOGS` (
  `LOG_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USU_ID` int(11) NOT NULL COMMENT 'Usuário que realizou a ação.',
  `LOG_SQL` text NOT NULL,
  `LOG_DataHora` datetime NOT NULL,
  PRIMARY KEY (`LOG_ID`),
  KEY `FK_CAD_USU_LOG` (`USU_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `CAD_LOG_LOGS`
--


-- --------------------------------------------------------

--
-- Table structure for table `CAD_MCT_MODULOS_CATEGORIAS`
--

CREATE TABLE IF NOT EXISTS `CAD_MCT_MODULOS_CATEGORIAS` (
  `MCT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MCT_Descricao` text NOT NULL,
  `MCT_Imagem` text NOT NULL,
  `MCT_BackgroundModulo` text NOT NULL,
  `MCT_BackgroundSubModulo` text NOT NULL,
  `MCT_Ordem` int(11) NOT NULL COMMENT 'Indica a ordem que será exibido o menu. Nao pode repetir.',
  `MCT_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo',
  PRIMARY KEY (`MCT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `CAD_MCT_MODULOS_CATEGORIAS`
--

INSERT INTO `CAD_MCT_MODULOS_CATEGORIAS` (`MCT_ID`, `MCT_Descricao`, `MCT_Imagem`, `MCT_BackgroundModulo`, `MCT_BackgroundSubModulo`, `MCT_Ordem`, `MCT_Status`) VALUES
(1, 'Sistema', 'botao-modulo-sistema.png', 'bg-modulo-azul.jpg', 'bg-submodulo-azul.jpg', 1, 'A'),
(2, 'Livros de Registos', 'botao-modulo-livrosRegistros.png', 'bg-modulo-verde.jpg', 'bg-submodulo-verde.jpg', 2, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_MFR_MODULOS_FORMULARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_MFR_MODULOS_FORMULARIOS` (
  `MOD_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  `MFR_Nivel1Descricao` text,
  `MFR_Nivel2Descricao` text,
  `MFR_Nivel3Descricao` text,
  `MFR_Nivel1Ordem` int(11) DEFAULT NULL,
  `MFR_Nivel2Ordem` int(11) DEFAULT NULL,
  `MFR_Nivel3Ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`MOD_ID`,`FRM_ID`),
  KEY `FK_CAD_FRM_MOD` (`FRM_ID`),
  KEY `FK_CAD_MOD_FRM` (`MOD_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_MFR_MODULOS_FORMULARIOS`
--

INSERT INTO `CAD_MFR_MODULOS_FORMULARIOS` (`MOD_ID`, `FRM_ID`, `MFR_Nivel1Descricao`, `MFR_Nivel2Descricao`, `MFR_Nivel3Descricao`, `MFR_Nivel1Ordem`, `MFR_Nivel2Ordem`, `MFR_Nivel3Ordem`) VALUES
(1, 1, 'Estrutura +', 'Submódulos', NULL, NULL, NULL, NULL),
(1, 2, 'Estrutura +', 'Módulos', NULL, NULL, NULL, NULL),
(1, 3, 'Formulários', '', '', NULL, NULL, NULL),
(1, 4, 'Permissões', '', '', NULL, NULL, NULL),
(1, 5, 'Usuários +', 'Grupos de Usuários', '', NULL, NULL, NULL),
(1, 6, 'Usuários +', 'Cadastros', '', NULL, NULL, NULL),
(1, 7, 'Relatórios +', 'Usuários', '', NULL, NULL, NULL),
(1, 8, 'Relatórios +', 'Grupos de Usuários', '', NULL, NULL, NULL),
(1, 16, 'Configuração', '', '', NULL, NULL, NULL),
(2, 9, 'Tipos de Linhas de Livro', '', '', NULL, NULL, NULL),
(3, 10, 'Livro Auxiliar', '', '', NULL, NULL, NULL),
(3, 11, 'Folha Auxiliar', '', '', NULL, NULL, NULL),
(3, 12, 'Linha Auxiliar', '', '', NULL, NULL, NULL),
(4, 13, 'Livro Prévio', '', '', NULL, NULL, NULL),
(4, 14, 'Folha Prévio', '', '', NULL, NULL, NULL),
(4, 15, 'Linha Prévio', '', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `CAD_MOD_MODULOS`
--

CREATE TABLE IF NOT EXISTS `CAD_MOD_MODULOS` (
  `MOD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `MCT_ID` int(11) NOT NULL,
  `MOD_Descricao` text NOT NULL,
  `MOD_Caminho` text NOT NULL,
  `MOD_Imagem` text NOT NULL,
  `MOD_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo',
  PRIMARY KEY (`MOD_ID`),
  KEY `FK_CAD_MCT_MOD` (`MCT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `CAD_MOD_MODULOS`
--

INSERT INTO `CAD_MOD_MODULOS` (`MOD_ID`, `MCT_ID`, `MOD_Descricao`, `MOD_Caminho`, `MOD_Imagem`, `MOD_Status`) VALUES
(1, 1, 'Gerencial (Cadastros)', 'sistema/gerencial/', 'sistema/sm-gerencial.png', 'A'),
(2, 2, 'Tipos de Linhas dos Livros', 'livroRegistro/tipo-linha-livro/', 'livro-registro/sm-tipo-livro.png', 'A'),
(3, 2, 'Livro Auxiliar', 'livroRegistro/livro-auxiliar/', 'livro-registro/sm-livro-auxiliar.png', 'A'),
(4, 2, 'Livro Prévio', 'livroRegistro/livro-previo/', 'livro-registro/sm-livro-previo.png', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_PAR_PARAMETROS`
--

CREATE TABLE IF NOT EXISTS `CAD_PAR_PARAMETROS` (
  `PAR_CNPJ` int(11) NOT NULL,
  `PAR_RazaoSocial` varchar(45) DEFAULT NULL,
  `PAR_NomeFantasia` varchar(45) DEFAULT NULL,
  `PAR_Denominacao` varchar(45) DEFAULT NULL,
  `PAR_Site` varchar(45) DEFAULT NULL,
  `PAR_Pastor` varchar(45) DEFAULT NULL,
  `PAR_EnderecoLogradouro` varchar(45) DEFAULT NULL,
  `PAR_EnderecoNumero` varchar(45) DEFAULT NULL,
  `PAR_EnderecoComplemento` varchar(45) DEFAULT NULL,
  `PAR_EnderecoBairro` varchar(45) DEFAULT NULL,
  `PAR_EnderecoCidade` varchar(45) DEFAULT NULL,
  `PAR_EnderecoUf` varchar(45) DEFAULT NULL,
  `PAR_EnderecoCep` varchar(45) DEFAULT NULL,
  `PAR_Logo` varchar(45) DEFAULT NULL,
  `PAR_TotFolhaLivro` varchar(45) DEFAULT NULL,
  `PAR_TotLinhaFolha` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`PAR_CNPJ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_PAR_PARAMETROS`
--

INSERT INTO `CAD_PAR_PARAMETROS` (`PAR_CNPJ`, `PAR_RazaoSocial`, `PAR_NomeFantasia`, `PAR_Denominacao`, `PAR_Site`, `PAR_Pastor`, `PAR_EnderecoLogradouro`, `PAR_EnderecoNumero`, `PAR_EnderecoComplemento`, `PAR_EnderecoBairro`, `PAR_EnderecoCidade`, `PAR_EnderecoUf`, `PAR_EnderecoCep`, `PAR_Logo`, `PAR_TotFolhaLivro`, `PAR_TotLinhaFolha`) VALUES
(0, '', '', '', '', '', '', '', '', '', '', '', '', '', '4', '16');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_SYS_SYSTEM`
--

CREATE TABLE IF NOT EXISTS `CAD_SYS_SYSTEM` (
  `SYS_Versao` varchar(20) NOT NULL,
  `SYS_QuantidadeMaxMembros` int(11) NOT NULL,
  `SYS_CodigoUnicoCliente` varchar(45) DEFAULT NULL COMMENT 'Atualizado via sistema MS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_SYS_SYSTEM`
--


-- --------------------------------------------------------

--
-- Table structure for table `CAD_UPE_USUARIOS_PERMISSOES`
--

CREATE TABLE IF NOT EXISTS `CAD_UPE_USUARIOS_PERMISSOES` (
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  `USU_ID` int(11) NOT NULL,
  PRIMARY KEY (`ACO_ID`,`FRM_ID`,`USU_ID`),
  KEY `FK_CAD_USU_FAC` (`USU_ID`),
  KEY `FK_CAD_FAC_USU` (`ACO_ID`,`FRM_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CAD_UPE_USUARIOS_PERMISSOES`
--


-- --------------------------------------------------------

--
-- Table structure for table `CAD_USA_USUARIOS_ACESSOS`
--

CREATE TABLE IF NOT EXISTS `CAD_USA_USUARIOS_ACESSOS` (
  `USA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USU_ID` int(11) NOT NULL,
  `USA_DataHora` datetime NOT NULL,
  PRIMARY KEY (`USA_ID`),
  KEY `FK_CAD_USU_USA` (`USU_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `CAD_USA_USUARIOS_ACESSOS`
--

INSERT INTO `CAD_USA_USUARIOS_ACESSOS` (`USA_ID`, `USU_ID`, `USA_DataHora`) VALUES
(1, 1, '2015-07-20 20:37:18'),
(2, 1, '2015-07-20 20:38:31'),
(3, 1, '2015-07-22 12:46:23'),
(4, 1, '2015-07-22 22:11:20'),
(5, 1, '2015-07-23 14:17:38'),
(6, 1, '2015-09-18 14:12:44'),
(7, 1, '2015-09-18 14:20:24'),
(8, 4, '2015-09-18 14:28:06'),
(9, 1, '2015-09-18 14:29:08'),
(10, 4, '2015-09-18 14:46:52'),
(11, 1, '2015-09-18 14:47:26'),
(12, 4, '2015-09-18 14:49:16'),
(13, 1, '2015-09-18 14:55:30'),
(14, 4, '2015-09-18 14:58:01'),
(15, 1, '2015-09-22 14:19:50'),
(16, 1, '2015-09-22 14:20:46'),
(17, 4, '2015-09-22 14:22:44'),
(18, 1, '2015-09-22 14:24:54'),
(19, 4, '2015-09-22 14:25:53'),
(20, 1, '2015-09-22 14:26:50'),
(21, 4, '2015-09-22 14:28:10'),
(22, 1, '2015-09-22 14:32:08'),
(23, 4, '2015-09-22 14:33:42'),
(24, 1, '2015-09-23 08:31:24'),
(25, 1, '2015-09-23 08:43:10'),
(26, 1, '2015-09-23 08:50:58'),
(27, 4, '2015-09-23 09:10:02'),
(28, 1, '2015-09-23 09:11:05'),
(29, 4, '2015-09-23 09:11:50'),
(30, 2, '2015-09-23 09:12:29'),
(31, 1, '2015-09-23 09:13:12'),
(32, 1, '2015-09-25 13:34:02'),
(33, 1, '2015-09-25 15:21:56'),
(34, 1, '2015-10-02 14:13:30'),
(35, 4, '2015-10-02 14:14:05'),
(36, 1, '2015-10-28 11:57:01'),
(37, 4, '2015-10-28 13:46:31'),
(38, 1, '2015-10-28 13:53:41'),
(39, 4, '2015-10-28 13:59:05'),
(40, 1, '2015-10-28 13:59:57'),
(41, 1, '2015-10-29 10:03:00'),
(42, 6, '2015-10-29 10:06:18'),
(43, 6, '2015-10-29 10:06:34'),
(44, 1, '2015-10-29 10:06:55'),
(45, 5, '2015-10-29 10:07:37'),
(46, 1, '2015-10-29 10:07:57'),
(47, 1, '2015-10-29 14:26:21'),
(48, 1, '2015-10-30 11:01:58'),
(49, 6, '2015-10-30 13:30:44'),
(50, 1, '2015-11-04 14:40:24'),
(51, 1, '2015-11-04 14:40:24'),
(52, 1, '2015-12-18 11:53:40'),
(53, 1, '2015-12-21 12:15:59'),
(54, 1, '2015-12-30 13:27:44'),
(55, 1, '2016-01-04 08:14:50'),
(56, 4, '2016-01-04 13:29:22'),
(57, 1, '2016-01-04 13:29:50'),
(58, 1, '2016-01-04 13:30:06'),
(59, 4, '2016-01-04 13:30:38'),
(60, 1, '2016-01-04 13:34:58'),
(61, 4, '2016-01-04 13:35:23'),
(62, 1, '2016-01-04 13:46:51'),
(63, 4, '2016-01-04 13:48:45'),
(64, 1, '2016-01-04 13:58:25'),
(65, 5, '2016-01-04 14:00:31'),
(66, 5, '2016-01-04 14:01:43'),
(67, 1, '2016-01-04 14:02:10'),
(68, 1, '2016-01-04 14:02:43'),
(69, 5, '2016-01-04 14:03:39'),
(70, 4, '2016-01-04 14:05:38'),
(71, 4, '2016-01-04 14:06:51'),
(72, 4, '2016-01-04 14:07:22'),
(73, 5, '2016-01-04 14:09:03'),
(74, 7, '2016-01-04 14:12:17'),
(75, 1, '2016-01-04 14:14:12'),
(76, 7, '2016-01-04 14:18:04'),
(77, 6, '2016-01-04 14:46:07'),
(78, 3, '2016-01-04 14:50:15'),
(79, 5, '2016-01-04 14:56:44'),
(80, 1, '2016-01-05 08:50:25'),
(81, 1, '2016-01-05 09:06:32'),
(82, 5, '2016-01-05 09:06:58'),
(83, 4, '2016-01-05 09:13:03'),
(84, 1, '2016-01-05 09:21:59'),
(85, 1, '2016-01-05 10:33:57');

-- --------------------------------------------------------

--
-- Table structure for table `CAD_USU_USUARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_USU_USUARIOS` (
  `USU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `GRU_ID` int(11) NOT NULL,
  `USU_Login` varchar(45) NOT NULL,
  `USU_Senha` text NOT NULL,
  `USU_Email` varchar(45) DEFAULT NULL,
  `USU_Telefone` varchar(20) DEFAULT NULL,
  `USU_DataHoraCadastro` datetime NOT NULL,
  `USU_DataHoraUltimoAcesso` datetime DEFAULT NULL,
  `USU_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo',
  `USU_Nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`USU_ID`),
  UNIQUE KEY `USU_Login_UNIQUE` (`USU_Login`),
  KEY `FK_CAD_GRU_USU` (`GRU_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Controle dos usuários do sistema.' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `CAD_USU_USUARIOS`
--

INSERT INTO `CAD_USU_USUARIOS` (`USU_ID`, `GRU_ID`, `USU_Login`, `USU_Senha`, `USU_Email`, `USU_Telefone`, `USU_DataHoraCadastro`, `USU_DataHoraUltimoAcesso`, `USU_Status`, `USU_Nome`) VALUES
(1, 1, 'ADMIN', '202cb962ac59075b964b07152d234b70', 'amin@gmail.com', '', '2014-02-25 00:00:00', '2016-01-05 10:33:57', 'A', NULL),
(2, 2, 'ANDREZA', '15020f672ce172fcff2efebcf36ef755', 'CARTORIOUNICOIMOVEISMORENO_MARCOS@HOTMAIL.COM', '', '2015-09-18 14:15:36', '2015-09-23 09:12:29', 'A', 'ANDREZA'),
(3, 2, 'SYNAME', 'd5ed680d462acb281007b3ca396c4211', 'SYNAME@GMAIL.COM', '', '2015-09-18 14:16:39', '2016-01-04 14:50:15', 'A', 'SYNAME'),
(4, 2, 'TATIANNE', 'ebaa876aeb5077e58c7c72fe773b54ea', 'TATIANNE@GMAIL.COM', '', '2015-09-18 14:24:19', '2016-01-05 09:13:03', 'A', 'TATIANNE'),
(5, 3, 'DIEGO MESQUITA', 'dbb3a2bce5474da40ee28be629ce8125', 'DIEGO@GMAIL.COM', '', '2015-09-18 14:24:55', '2016-01-05 09:06:58', 'A', 'DIEGO MESQUITA'),
(6, 4, 'CLAUDIA', '79104359add36182de2b3336311a477c', 'CLAUDIA@GMAIL.COM', '', '2015-09-18 14:25:30', '2016-01-04 14:46:07', 'A', 'CLAUDIA'),
(7, 4, 'LEONARDO', 'a4ba835059a521df1d50b60880247f45', 'LEO@GMAIL.COM', '', '2015-09-18 14:26:20', '2016-01-04 14:18:04', 'A', 'MANOEL LEONARDO');

-- --------------------------------------------------------

--
-- Table structure for table `LIR_FAU_FOLHA_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_FAU_FOLHA_AUXILIAR` (
  `FAU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIA_ID` int(11) NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `FAU_NumeroFolha` varchar(45) NOT NULL,
  `FAU_DataFolha` date NOT NULL,
  `FAU_DataHoraCadastro` datetime NOT NULL,
  `FAU_DataHoraAlteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`FAU_ID`,`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_LIR_LIA_LIVRO_AUXILIAR1_idx` (`LIA_ID`),
  KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `LIR_FAU_FOLHA_AUXILIAR`
--

INSERT INTO `LIR_FAU_FOLHA_AUXILIAR` (`FAU_ID`, `LIA_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `FAU_NumeroFolha`, `FAU_DataFolha`, `FAU_DataHoraCadastro`, `FAU_DataHoraAlteracao`) VALUES
(8, 7, 1, NULL, '1', '2016-01-04', '0000-00-00 00:00:00', NULL),
(9, 7, 1, NULL, '2', '2016-01-04', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_FPR_FOLHA_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_FPR_FOLHA_PREVIO` (
  `FPR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIP_ID` int(11) NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `FPR_NumeroFolha` varchar(45) NOT NULL,
  `FPR_DataFolha` date NOT NULL,
  `FPR_DataHoraCadastro` datetime NOT NULL,
  `FPR_DataHoraAlteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`FPR_ID`,`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_LIR_LIP_LIVRO_PREVIO1_idx` (`LIP_ID`),
  KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `LIR_FPR_FOLHA_PREVIO`
--

INSERT INTO `LIR_FPR_FOLHA_PREVIO` (`FPR_ID`, `LIP_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `FPR_NumeroFolha`, `FPR_DataFolha`, `FPR_DataHoraCadastro`, `FPR_DataHoraAlteracao`) VALUES
(2, 2, 1, 1, '1', '2015-12-29', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 1, 1, '2', '2016-01-04', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 3, 1, NULL, '1', '2016-01-05', '2016-01-05 09:24:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_LAU_LINHA_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_LAU_LINHA_AUXILIAR` (
  `LAU_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FAU_ID` int(11) NOT NULL,
  `TIL_ID` int(11) NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `LAU_Descricao` text NOT NULL,
  `LAU_Guia` text,
  `LAU_ProtocoloRecepcao` text,
  `LAU_Quantidade` int(11) DEFAULT NULL,
  `LAU_Cpf` varchar(45) DEFAULT NULL,
  `LAU_Data` date DEFAULT NULL,
  `LAU_Valor` double DEFAULT NULL,
  `LAU_DataHoraCadastro` datetime NOT NULL,
  `LAU_DataHoraAlteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`LAU_ID`),
  KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_LFA_LIVRO_FOLHA_AUXILIA_idx` (`FAU_ID`),
  KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_TLA_TIPO_LIVRO_AUXILIAR_idx` (`TIL_ID`),
  KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`),
  KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `LIR_LAU_LINHA_AUXILIAR`
--

INSERT INTO `LIR_LAU_LINHA_AUXILIAR` (`LAU_ID`, `FAU_ID`, `TIL_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `LAU_Descricao`, `LAU_Guia`, `LAU_ProtocoloRecepcao`, `LAU_Quantidade`, `LAU_Cpf`, `LAU_Data`, `LAU_Valor`, `LAU_DataHoraCadastro`, `LAU_DataHoraAlteracao`) VALUES
(28, 8, 2, 1, NULL, 'PROTESTO', '05264522', '14278', 1, '091.322.504-52', '2014-01-02', 22.18, '2016-01-04 10:43:20', NULL),
(29, 8, 2, 1, NULL, 'PROTESTO', '05264562', '14283', 1, '364.554.044-66', '2014-01-02', 115.2, '2016-01-04 10:44:45', NULL),
(30, 8, 2, 1, NULL, 'PROTESTO', '05264775', '14281', 1, '464.594.666-00', '2014-01-02', 22.18, '2016-01-04 10:45:42', NULL),
(31, 8, 2, 1, NULL, 'OF', '05278955', '385', 1, '092.445.778-96', '2016-01-04', 389.8, '2016-01-04 10:46:41', NULL),
(32, 8, 2, 1, NULL, 'OF', '05244977', '387', 1, '047.996.404-52', '2014-01-02', 396.76, '2016-01-04 10:47:31', NULL),
(33, 8, 2, 1, NULL, 'OF', '05242501', '387', 1, '047.887.942-20', '2014-01-02', 192.23, '2016-01-04 10:49:57', NULL),
(34, 8, 2, 1, NULL, 'ABERTURA DE FIRMA', '05292403', '', 3, '', '2014-01-02', 4.68, '2016-01-04 10:55:41', NULL),
(35, 8, 2, 1, NULL, 'AUTENTICAÇÃO', '05269454', '', 42, '', '2014-01-02', 99.54, '2016-01-04 10:56:25', NULL),
(36, 8, 2, 1, NULL, 'REC. DE FIRMA', '05292666', '', 17, '', '2014-01-02', 47.26, '2016-01-04 10:57:20', NULL),
(37, 8, 1, 1, NULL, 'ALMOÇO', '', '', 1, '', '2014-01-02', 17, '2016-01-04 10:58:09', NULL),
(38, 8, 1, 1, NULL, 'MOTO', '', '', 1, '', '2014-01-02', 3, '2016-01-04 10:58:43', NULL),
(39, 8, 1, 1, NULL, 'MOTO', '', '', 1, '', '2014-01-02', 6, '2016-01-04 10:59:05', NULL),
(40, 9, 1, 1, NULL, 'PROTESTO', '05296433', '14511', 1, '096.404.425-20', '2014-01-03', 23.46, '2016-01-04 11:00:06', NULL),
(41, 9, 2, 1, NULL, 'PROTESTO', '05244696', '14512', 1, '044.546.966-00', '2014-01-03', 23.46, '2016-01-04 11:00:47', NULL),
(42, 9, 2, 1, NULL, 'PROTESTO', '05277894', '14577', 1, '054.990.440-25', '2014-01-03', 129.6, '2016-01-04 11:01:59', NULL),
(43, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05212392', '17097', 1, '052.660.996-44', '2014-01-03', 676.55, '2016-01-04 11:03:03', NULL),
(44, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05265487', '17097', 1, '054.660.445-25', '2014-01-03', 269.21, '2016-01-04 11:04:22', NULL),
(45, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05265898', '17097', 1, '045.789.996-00', '2014-01-03', 637.6, '2016-01-04 11:05:24', NULL),
(46, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05288094', '17098', 1, '064.552.404-50', '2014-01-03', 637.6, '2016-01-04 11:11:13', NULL),
(47, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05297845', '17098', 1, '052.996.354-44', '2014-01-03', 560.06, '2016-01-04 11:13:12', NULL),
(48, 9, 2, 1, NULL, 'ESCRITURA COMPRA E VENDA', '05245688', '17099', 1, '052.091.322-52', '2016-01-04', 909.05, '2016-01-04 11:21:35', NULL),
(49, 9, 2, 1, NULL, 'ABERTURA DE FIRMA', '', '', 4, '', '2014-01-03', 6.24, '2016-01-04 11:22:54', NULL),
(50, 9, 2, 1, NULL, 'AUTENTICAÇÃO', '', '', 51, '', '2014-01-03', 120.87, '2016-01-04 11:23:23', NULL),
(51, 9, 2, 1, NULL, 'ABERTURA DE FIRMA', '', '', 4, '', '2015-01-03', 6.24, '2016-01-04 11:40:08', NULL),
(52, 9, 2, 1, NULL, 'AUTENTICAÇÃO', '', '', 51, '', '2015-01-03', 120.87, '2016-01-04 11:40:45', NULL),
(54, 9, 1, 1, NULL, 'ALMOÇO', '', '', 1, '', '2014-01-03', 17, '2016-01-04 11:41:40', NULL),
(55, 9, 1, 1, NULL, 'MOTO', '', '', 1, '', '2014-01-03', 0.06, '2016-01-04 11:42:03', NULL),
(60, 8, 2, 1, NULL, 'CERTIDÃO ACIMA DE 20 ANOS', '05244566', '2160', 1, '091.322.504-52', '2016-01-05', 36.7, '2016-01-05 08:52:17', NULL),
(62, 8, 2, 4, NULL, 'CERTIDÃO 5 ANOS', '05244566', '2160', 1, '091.322.504-52', '2016-01-05', 10.5, '2016-01-05 09:17:51', NULL),
(63, 9, 1, 1, NULL, 'MOTO', '', '', 1, '', '2016-01-05', 4, '2016-01-05 09:26:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_LIA_LIVRO_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_LIA_LIVRO_AUXILIAR` (
  `LIA_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIA_NumeroLivro` varchar(45) NOT NULL,
  `LIA_DataHoraCadastro` datetime NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  PRIMARY KEY (`LIA_ID`,`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LIA_LIVRO_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `LIR_LIA_LIVRO_AUXILIAR`
--

INSERT INTO `LIR_LIA_LIVRO_AUXILIAR` (`LIA_ID`, `LIA_NumeroLivro`, `LIA_DataHoraCadastro`, `USU_UsuarioCadastroID`) VALUES
(7, '1', '2016-01-04 10:38:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_LIP_LIVRO_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_LIP_LIVRO_PREVIO` (
  `LIP_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LIP_NumeroLivro` varchar(45) NOT NULL,
  `LIP_DataHoraCadastro` datetime NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  PRIMARY KEY (`LIP_ID`,`USU_UsuarioCadastroID`),
  KEY `fk_LIR_LIP_LIVRO_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `LIR_LIP_LIVRO_PREVIO`
--

INSERT INTO `LIR_LIP_LIVRO_PREVIO` (`LIP_ID`, `LIP_NumeroLivro`, `LIP_DataHoraCadastro`, `USU_UsuarioCadastroID`) VALUES
(2, '1', '2015-12-30 14:11:47', 1),
(3, '1', '2016-01-05 09:24:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_LPR_LINHA_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_LPR_LINHA_PREVIO` (
  `LPR_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FPR_ID` int(11) NOT NULL,
  `TIL_ID` int(11) DEFAULT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `LPR_Descricao` text,
  `LPR_Guia` varchar(45) DEFAULT NULL,
  `LPR_Nome` varchar(100) DEFAULT NULL,
  `LPR_Cpf` varchar(45) DEFAULT NULL,
  `LPR_Quantidade` int(11) DEFAULT NULL,
  `LPR_Data` date DEFAULT NULL,
  `LPR_Valor` double DEFAULT NULL,
  `LPR_DataHoraCadastro` datetime NOT NULL,
  `LPR_DataHoraAlteracao` datetime DEFAULT NULL,
  `LPR_StatusConclusao` char(1) NOT NULL COMMENT 'S=SIM,N=NAO',
  `LPR_DataHoraStatusConclusao` datetime DEFAULT NULL,
  `USU_StatusConclusao_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`LPR_ID`),
  KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_LFP_LIVRO_FOLHA_PREVIO1_idx` (`FPR_ID`),
  KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`),
  KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`),
  KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_TIL_TIPO_LINHA1_idx` (`TIL_ID`),
  KEY `fk_LIR_LPR_LINHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_StatusConclusao_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `LIR_LPR_LINHA_PREVIO`
--

INSERT INTO `LIR_LPR_LINHA_PREVIO` (`LPR_ID`, `FPR_ID`, `TIL_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `LPR_Descricao`, `LPR_Guia`, `LPR_Nome`, `LPR_Cpf`, `LPR_Quantidade`, `LPR_Data`, `LPR_Valor`, `LPR_DataHoraCadastro`, `LPR_DataHoraAlteracao`, `LPR_StatusConclusao`, `LPR_DataHoraStatusConclusao`, `USU_StatusConclusao_ID`) VALUES
(7, 2, NULL, 1, NULL, 'ESCRITURA DOAÇÃO', '05044523', 'DIEGO MESQUITA', '091.322.504-52', 1, '2015-12-30', 2630, '2015-12-30 14:46:17', NULL, 'S', '2016-01-04 09:08:05', 1),
(8, 2, NULL, 1, NULL, 'PROTESTO', '05166789', 'TATIANNE', '465.566.901-20', 1, '2015-12-30', 860, '2015-12-30 14:47:06', NULL, 'S', '2016-01-04 13:27:22', 1),
(9, 2, NULL, 1, NULL, 'PROTESTO', '05145466', 'PATRICIA OLIVEIRA', '446.554.889-00', 1, '2015-12-30', 905, '2015-12-30 14:51:12', NULL, 'S', '2016-01-04 09:49:16', 1),
(10, 2, NULL, 1, NULL, 'PROTESTO', '05144652', 'CLAUDIA', '966.454.666-00', 1, '2015-12-30', 994, '2015-12-30 14:53:31', NULL, 'S', '2016-01-04 09:49:06', 1),
(11, 2, NULL, 1, NULL, 'AVERBAÇÃO SEM CONTEUDO FINANCEIRO', '05265644', 'PEDRO JOÃO DOS SANTOS', '966.404.225-44', 1, '2016-01-04', 72.4, '2016-01-04 08:36:14', NULL, 'S', '2016-01-04 09:48:12', 1),
(12, 3, NULL, 1, NULL, 'AVERBAÇÃO SEM CONTEUDO FINANCEIRO', '05249466', 'MANOEL LEONARDO', '966.444.654-00', 1, '2016-01-04', 72.4, '2016-01-04 08:42:46', NULL, 'S', '2016-01-04 11:43:44', 1),
(13, 3, NULL, 1, NULL, 'CERTIDÃO NEGATIVA 5 ANOS', '05292244', 'CLAUDIA CORREIA', '455.987.044-50', 1, '2016-01-04', 10.2, '2016-01-04 08:45:55', NULL, 'S', '2016-01-04 09:53:56', 1),
(16, 2, NULL, 4, NULL, 'ESCRITURA COMPRA E VENDA', '0500800', 'DIEGO MESQUITA', '091.322.504-52', 1, '2016-01-04', 1150, '2016-01-04 13:51:37', NULL, 'S', '2016-01-04 14:13:13', 7),
(17, 3, NULL, 1, NULL, 'ESCRITURA', '05252230', 'DIEGO', '091.322.504-52', 1, '2016-01-05', 1000, '2016-01-05 09:00:28', NULL, 'S', '2016-01-05 09:00:43', 1),
(18, 4, NULL, 1, NULL, 'ESCRITURA', '5266464', 'DIEGO', '465.465.413-16', 1, '2016-01-05', 500, '2016-01-05 09:24:52', NULL, 'N', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `LIR_TIL_TIPO_LINHA`
--

CREATE TABLE IF NOT EXISTS `LIR_TIL_TIPO_LINHA` (
  `TIL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIL_Descricao` varchar(45) NOT NULL,
  `TIL_Tipo` varchar(1) NOT NULL COMMENT 'D: desepesa\nR: receita',
  `TIL_DataHoraCadastro` datetime NOT NULL,
  `TIL_DataHoraAlteracao` datetime DEFAULT NULL,
  `TIL_Status` varchar(1) NOT NULL COMMENT 'A: ativo\nI: inativo',
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TIL_ID`,`USU_UsuarioCadastroID`),
  KEY `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`),
  KEY `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `LIR_TIL_TIPO_LINHA`
--

INSERT INTO `LIR_TIL_TIPO_LINHA` (`TIL_ID`, `TIL_Descricao`, `TIL_Tipo`, `TIL_DataHoraCadastro`, `TIL_DataHoraAlteracao`, `TIL_Status`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`) VALUES
(1, 'DESPESA', 'D', '2015-07-22 23:13:32', '2015-09-18 14:37:17', 'A', 1, 1),
(2, 'RECEITA', 'R', '2015-07-22 23:13:41', '2015-09-18 14:37:27', 'A', 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CAD_FAC_FORMULARIOS_ACOES`
--
ALTER TABLE `CAD_FAC_FORMULARIOS_ACOES`
  ADD CONSTRAINT `FK_CAD_ACO_FRM` FOREIGN KEY (`ACO_ID`) REFERENCES `CAD_ACO_ACOES` (`ACO_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CAD_FRM_ACO` FOREIGN KEY (`FRM_ID`) REFERENCES `CAD_FRM_FORMULARIOS` (`FRM_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CAD_GPE_GRUPOS_PERMISSOES`
--
ALTER TABLE `CAD_GPE_GRUPOS_PERMISSOES`
  ADD CONSTRAINT `FK_GPE_FRM_ID_ACO_ID` FOREIGN KEY (`ACO_ID`, `FRM_ID`) REFERENCES `CAD_FAC_FORMULARIOS_ACOES` (`ACO_ID`, `FRM_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_GPE_GRU_ID` FOREIGN KEY (`GRU_ID`) REFERENCES `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CAD_LOG_LOGS`
--
ALTER TABLE `CAD_LOG_LOGS`
  ADD CONSTRAINT `FK_CAD_USU_LOG` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CAD_MFR_MODULOS_FORMULARIOS`
--
ALTER TABLE `CAD_MFR_MODULOS_FORMULARIOS`
  ADD CONSTRAINT `FK_CAD_FRM_MOD` FOREIGN KEY (`MOD_ID`) REFERENCES `CAD_MOD_MODULOS` (`MOD_ID`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_CAD_MOD_FRM` FOREIGN KEY (`FRM_ID`) REFERENCES `CAD_FRM_FORMULARIOS` (`FRM_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CAD_MOD_MODULOS`
--
ALTER TABLE `CAD_MOD_MODULOS`
  ADD CONSTRAINT `FK_CAD_MCT_MOD` FOREIGN KEY (`MCT_ID`) REFERENCES `CAD_MCT_MODULOS_CATEGORIAS` (`MCT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CAD_UPE_USUARIOS_PERMISSOES`
--
ALTER TABLE `CAD_UPE_USUARIOS_PERMISSOES`
  ADD CONSTRAINT `FK_CAD_FAC_USU` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_CAD_USU_FAC` FOREIGN KEY (`ACO_ID`, `FRM_ID`) REFERENCES `CAD_FAC_FORMULARIOS_ACOES` (`ACO_ID`, `FRM_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `CAD_USA_USUARIOS_ACESSOS`
--
ALTER TABLE `CAD_USA_USUARIOS_ACESSOS`
  ADD CONSTRAINT `FK_CAD_USU_USA` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `CAD_USU_USUARIOS`
--
ALTER TABLE `CAD_USU_USUARIOS`
  ADD CONSTRAINT `FK_USU_GRU_ID` FOREIGN KEY (`GRU_ID`) REFERENCES `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LIR_FAU_FOLHA_AUXILIAR`
--
ALTER TABLE `LIR_FAU_FOLHA_AUXILIAR`
  ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_LIR_LIA_LIVRO_AUXILIAR1` FOREIGN KEY (`LIA_ID`) REFERENCES `LIR_LIA_LIVRO_AUXILIAR` (`LIA_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LIR_FPR_FOLHA_PREVIO`
--
ALTER TABLE `LIR_FPR_FOLHA_PREVIO`
  ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_LIR_LIP_LIVRO_PREVIO1` FOREIGN KEY (`LIP_ID`) REFERENCES `LIR_LIP_LIVRO_PREVIO` (`LIP_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LIR_LAU_LINHA_AUXILIAR`
--
ALTER TABLE `LIR_LAU_LINHA_AUXILIAR`
  ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_LFA_LIVRO_FOLHA_AUXILIAR1` FOREIGN KEY (`FAU_ID`) REFERENCES `LIR_FAU_FOLHA_AUXILIAR` (`FAU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_TLA_TIPO_LIVRO_AUXILIAR1` FOREIGN KEY (`TIL_ID`) REFERENCES `LIR_TIL_TIPO_LINHA` (`TIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LIR_LIA_LIVRO_AUXILIAR`
--
ALTER TABLE `LIR_LIA_LIVRO_AUXILIAR`
  ADD CONSTRAINT `fk_LIR_LIA_LIVRO_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `LIR_LIP_LIVRO_PREVIO`
--
ALTER TABLE `LIR_LIP_LIVRO_PREVIO`
  ADD CONSTRAINT `fk_LIR_LIP_LIVRO_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
