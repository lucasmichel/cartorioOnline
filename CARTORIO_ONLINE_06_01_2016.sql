-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 23/07/2015 às 04:55
-- Versão do servidor: 5.6.21
-- Versão do PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `CARTORIO_ONLINE`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_ACO_ACOES`
--

CREATE TABLE IF NOT EXISTS `CAD_ACO_ACOES` (
`ACO_ID` int(11) NOT NULL,
  `ACO_Descricao` varchar(45) NOT NULL,
  `ACO_Status` char(1) NOT NULL COMMENT 'A => Ativo, I => Inativo'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_ACO_ACOES`
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
-- Estrutura para tabela `CAD_FAC_FORMULARIOS_ACOES`
--

CREATE TABLE IF NOT EXISTS `CAD_FAC_FORMULARIOS_ACOES` (
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_FAC_FORMULARIOS_ACOES`
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
-- Estrutura para tabela `CAD_FRM_FORMULARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_FRM_FORMULARIOS` (
`FRM_ID` int(11) NOT NULL,
  `FRM_Descricao` varchar(45) NOT NULL,
  `FRM_Caminho` varchar(150) NOT NULL,
  `FRM_Status` char(1) NOT NULL COMMENT 'A => Ativo, I => Inativo'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Relaciona os menus.';

--
-- Fazendo dump de dados para tabela `CAD_FRM_FORMULARIOS`
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
-- Estrutura para tabela `CAD_GPE_GRUPOS_PERMISSOES`
--

CREATE TABLE IF NOT EXISTS `CAD_GPE_GRUPOS_PERMISSOES` (
  `GRU_ID` int(11) NOT NULL,
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_GPE_GRUPOS_PERMISSOES`
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
(1, 7, 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_GRU_GRUPOS_USUARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_GRU_GRUPOS_USUARIOS` (
`GRU_ID` int(11) NOT NULL,
  `GRU_Descricao` varchar(45) NOT NULL,
  `GRU_Status` char(1) NOT NULL DEFAULT 'I'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Grupos de usuários. (Perfis)';

--
-- Fazendo dump de dados para tabela `CAD_GRU_GRUPOS_USUARIOS`
--

INSERT INTO `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`, `GRU_Descricao`, `GRU_Status`) VALUES
(1, 'ADMINISTRADOR', 'A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_LOG_LOGS`
--

CREATE TABLE IF NOT EXISTS `CAD_LOG_LOGS` (
`LOG_ID` int(11) NOT NULL,
  `USU_ID` int(11) NOT NULL COMMENT 'Usuário que realizou a ação.',
  `LOG_SQL` text NOT NULL,
  `LOG_DataHora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_MCT_MODULOS_CATEGORIAS`
--

CREATE TABLE IF NOT EXISTS `CAD_MCT_MODULOS_CATEGORIAS` (
`MCT_ID` int(11) NOT NULL,
  `MCT_Descricao` text NOT NULL,
  `MCT_Imagem` text NOT NULL,
  `MCT_BackgroundModulo` text NOT NULL,
  `MCT_BackgroundSubModulo` text NOT NULL,
  `MCT_Ordem` int(11) NOT NULL COMMENT 'Indica a ordem que será exibido o menu. Nao pode repetir.',
  `MCT_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_MCT_MODULOS_CATEGORIAS`
--

INSERT INTO `CAD_MCT_MODULOS_CATEGORIAS` (`MCT_ID`, `MCT_Descricao`, `MCT_Imagem`, `MCT_BackgroundModulo`, `MCT_BackgroundSubModulo`, `MCT_Ordem`, `MCT_Status`) VALUES
(1, 'Sistema', 'botao-modulo-sistema.png', 'bg-modulo-azul.jpg', 'bg-submodulo-azul.jpg', 1, 'A'),
(2, 'Livros de Registos', 'botao-modulo-livrosRegistros.png', 'bg-modulo-verde.jpg', 'bg-submodulo-verde.jpg', 2, 'A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_MFR_MODULOS_FORMULARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_MFR_MODULOS_FORMULARIOS` (
  `MOD_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  `MFR_Nivel1Descricao` text,
  `MFR_Nivel2Descricao` text,
  `MFR_Nivel3Descricao` text,
  `MFR_Nivel1Ordem` int(11) DEFAULT NULL,
  `MFR_Nivel2Ordem` int(11) DEFAULT NULL,
  `MFR_Nivel3Ordem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_MFR_MODULOS_FORMULARIOS`
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
-- Estrutura para tabela `CAD_MOD_MODULOS`
--

CREATE TABLE IF NOT EXISTS `CAD_MOD_MODULOS` (
`MOD_ID` int(11) NOT NULL,
  `MCT_ID` int(11) NOT NULL,
  `MOD_Descricao` text NOT NULL,
  `MOD_Caminho` text NOT NULL,
  `MOD_Imagem` text NOT NULL,
  `MOD_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_MOD_MODULOS`
--

INSERT INTO `CAD_MOD_MODULOS` (`MOD_ID`, `MCT_ID`, `MOD_Descricao`, `MOD_Caminho`, `MOD_Imagem`, `MOD_Status`) VALUES
(1, 1, 'Gerencial (Cadastros)', 'sistema/gerencial/', 'sistema/sm-gerencial.png', 'A'),
(2, 2, 'Tipos de Linhas dos Livros', 'livroRegistro/tipo-linha-livro/', 'livro-registro/sm-tipo-livro.png', 'A'),
(3, 2, 'Livro Auxiliar', 'livroRegistro/livro-auxiliar/', 'livro-registro/sm-livro-auxiliar.png', 'A'),
(4, 2, 'Livro Prévio', 'livroRegistro/livro-previo/', 'livro-registro/sm-livro-previo.png', 'A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_PAR_PARAMETROS`
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
  `PAR_TotLinhaFolha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_PAR_PARAMETROS`
--

INSERT INTO `CAD_PAR_PARAMETROS` (`PAR_CNPJ`, `PAR_RazaoSocial`, `PAR_NomeFantasia`, `PAR_Denominacao`, `PAR_Site`, `PAR_Pastor`, `PAR_EnderecoLogradouro`, `PAR_EnderecoNumero`, `PAR_EnderecoComplemento`, `PAR_EnderecoBairro`, `PAR_EnderecoCidade`, `PAR_EnderecoUf`, `PAR_EnderecoCep`, `PAR_Logo`, `PAR_TotFolhaLivro`, `PAR_TotLinhaFolha`) VALUES
(0, '', '', '', '', '', '', '', '', '', '', '', '', '', '2', '4');

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_SYS_SYSTEM`
--

CREATE TABLE IF NOT EXISTS `CAD_SYS_SYSTEM` (
  `SYS_Versao` varchar(20) NOT NULL,
  `SYS_QuantidadeMaxMembros` int(11) NOT NULL,
  `SYS_CodigoUnicoCliente` varchar(45) DEFAULT NULL COMMENT 'Atualizado via sistema MS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_UPE_USUARIOS_PERMISSOES`
--

CREATE TABLE IF NOT EXISTS `CAD_UPE_USUARIOS_PERMISSOES` (
  `ACO_ID` int(11) NOT NULL,
  `FRM_ID` int(11) NOT NULL,
  `USU_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_USA_USUARIOS_ACESSOS`
--

CREATE TABLE IF NOT EXISTS `CAD_USA_USUARIOS_ACESSOS` (
`USA_ID` int(11) NOT NULL,
  `USU_ID` int(11) NOT NULL,
  `USA_DataHora` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `CAD_USA_USUARIOS_ACESSOS`
--

INSERT INTO `CAD_USA_USUARIOS_ACESSOS` (`USA_ID`, `USU_ID`, `USA_DataHora`) VALUES
(1, 1, '2015-07-20 20:37:18'),
(2, 1, '2015-07-20 20:38:31'),
(3, 1, '2015-07-22 12:46:23'),
(4, 1, '2015-07-22 22:11:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `CAD_USU_USUARIOS`
--

CREATE TABLE IF NOT EXISTS `CAD_USU_USUARIOS` (
`USU_ID` int(11) NOT NULL,
  `GRU_ID` int(11) NOT NULL,
  `USU_Login` varchar(45) NOT NULL,
  `USU_Senha` text NOT NULL,
  `USU_Email` varchar(45) DEFAULT NULL,
  `USU_Telefone` varchar(20) DEFAULT NULL,
  `USU_DataHoraCadastro` datetime NOT NULL,
  `USU_DataHoraUltimoAcesso` datetime DEFAULT NULL,
  `USU_Status` char(1) NOT NULL DEFAULT 'I' COMMENT 'A => Ativo, I => Inativo',
  `USU_Nome` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Controle dos usuários do sistema.';

--
-- Fazendo dump de dados para tabela `CAD_USU_USUARIOS`
--

INSERT INTO `CAD_USU_USUARIOS` (`USU_ID`, `GRU_ID`, `USU_Login`, `USU_Senha`, `USU_Email`, `USU_Telefone`, `USU_DataHoraCadastro`, `USU_DataHoraUltimoAcesso`, `USU_Status`, `USU_Nome`) VALUES
(1, 1, 'ADMIN', '202cb962ac59075b964b07152d234b70', 'amin@gmail.com', '', '2014-02-25 00:00:00', '2015-07-22 22:11:20', 'A', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_FAU_FOLHA_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_FAU_FOLHA_AUXILIAR` (
`FAU_ID` int(11) NOT NULL,
  `LIA_ID` int(11) NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `FAU_NumeroFolha` varchar(45) NOT NULL,
  `FAU_DataFolha` date NOT NULL,
  `FAU_DataHoraCadastro` datetime NOT NULL,
  `FAU_DataHoraAlteracao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_FAU_FOLHA_AUXILIAR`
--

INSERT INTO `LIR_FAU_FOLHA_AUXILIAR` (`FAU_ID`, `LIA_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `FAU_NumeroFolha`, `FAU_DataFolha`, `FAU_DataHoraCadastro`, `FAU_DataHoraAlteracao`) VALUES
(1, 1, 1, NULL, '1', '2015-07-22', '2015-07-22 23:39:48', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_FPR_FOLHA_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_FPR_FOLHA_PREVIO` (
`FPR_ID` int(11) NOT NULL,
  `LIP_ID` int(11) NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL,
  `FPR_NumeroFolha` varchar(45) NOT NULL,
  `FPR_DataFolha` date NOT NULL,
  `FPR_DataHoraCadastro` datetime NOT NULL,
  `FPR_DataHoraAlteracao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_FPR_FOLHA_PREVIO`
--

INSERT INTO `LIR_FPR_FOLHA_PREVIO` (`FPR_ID`, `LIP_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `FPR_NumeroFolha`, `FPR_DataFolha`, `FPR_DataHoraCadastro`, `FPR_DataHoraAlteracao`) VALUES
(1, 1, 1, NULL, '1', '2015-07-22', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_LAU_LINHA_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_LAU_LINHA_AUXILIAR` (
`LAU_ID` int(11) NOT NULL,
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
  `LAU_DataHoraAlteracao` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_LAU_LINHA_AUXILIAR`
--

INSERT INTO `LIR_LAU_LINHA_AUXILIAR` (`LAU_ID`, `FAU_ID`, `TIL_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `LAU_Descricao`, `LAU_Guia`, `LAU_ProtocoloRecepcao`, `LAU_Quantidade`, `LAU_Cpf`, `LAU_Data`, `LAU_Valor`, `LAU_DataHoraCadastro`, `LAU_DataHoraAlteracao`) VALUES
(4, 1, 1, 1, NULL, 'SDFDSF', 'SDFSDF', 'LINHA PREVIO', 45, '353.454.354-35', '2015-07-30', 345.34, '2015-07-22 23:48:29', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_LIA_LIVRO_AUXILIAR`
--

CREATE TABLE IF NOT EXISTS `LIR_LIA_LIVRO_AUXILIAR` (
`LIA_ID` int(11) NOT NULL,
  `LIA_NumeroLivro` varchar(45) NOT NULL,
  `LIA_DataHoraCadastro` datetime NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_LIA_LIVRO_AUXILIAR`
--

INSERT INTO `LIR_LIA_LIVRO_AUXILIAR` (`LIA_ID`, `LIA_NumeroLivro`, `LIA_DataHoraCadastro`, `USU_UsuarioCadastroID`) VALUES
(1, '1', '2015-07-22 23:39:48', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_LIP_LIVRO_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_LIP_LIVRO_PREVIO` (
`LIP_ID` int(11) NOT NULL,
  `LIP_NumeroLivro` varchar(45) NOT NULL,
  `LIP_DataHoraCadastro` datetime NOT NULL,
  `USU_UsuarioCadastroID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_LIP_LIVRO_PREVIO`
--

INSERT INTO `LIR_LIP_LIVRO_PREVIO` (`LIP_ID`, `LIP_NumeroLivro`, `LIP_DataHoraCadastro`, `USU_UsuarioCadastroID`) VALUES
(1, '1', '2015-07-22 12:54:07', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_LPR_LINHA_PREVIO`
--

CREATE TABLE IF NOT EXISTS `LIR_LPR_LINHA_PREVIO` (
`LPR_ID` int(11) NOT NULL,
  `FPR_ID` int(11) NOT NULL,
  `TIL_ID` int(11) NOT NULL,
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
  `USU_StatusConclusao_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_LPR_LINHA_PREVIO`
--

INSERT INTO `LIR_LPR_LINHA_PREVIO` (`LPR_ID`, `FPR_ID`, `TIL_ID`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`, `LPR_Descricao`, `LPR_Guia`, `LPR_Nome`, `LPR_Cpf`, `LPR_Quantidade`, `LPR_Data`, `LPR_Valor`, `LPR_DataHoraCadastro`, `LPR_DataHoraAlteracao`, `LPR_StatusConclusao`, `LPR_DataHoraStatusConclusao`, `USU_StatusConclusao_ID`) VALUES
(2, 1, 0, 1, NULL, 'ASDASD', 'ASDASD', 'ASDASD', '324.234.234-32', 3, '2015-07-22', 2.34, '2015-07-22 22:15:30', NULL, 'N', NULL, NULL),
(3, 1, 0, 1, NULL, 'RG', 'DFG', 'DFG', '345.345.435-34', 4, '2015-07-22', 23.33, '2015-07-22 22:36:17', NULL, 'N', NULL, NULL),
(4, 1, 0, 1, NULL, 'DFGDG', 'DFGFD', 'DDFG', '345.454.354-35', 3, '2015-07-22', 324.34, '2015-07-22 22:36:32', NULL, 'N', NULL, NULL),
(5, 1, 0, 1, NULL, 'SDFDSF', 'SDFSDF', 'SDFDSF', '353.454.354-35', 45, '2015-07-30', 345.34, '2015-07-22 22:36:46', NULL, 'S', '2015-07-22 23:48:29', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIR_TIL_TIPO_LINHA`
--

CREATE TABLE IF NOT EXISTS `LIR_TIL_TIPO_LINHA` (
`TIL_ID` int(11) NOT NULL,
  `TIL_Descricao` varchar(45) NOT NULL,
  `TIL_Tipo` varchar(1) NOT NULL COMMENT 'D: desepesa\nR: receita',
  `TIL_DataHoraCadastro` datetime NOT NULL,
  `TIL_DataHoraAlteracao` datetime DEFAULT NULL,
  `TIL_Status` varchar(1) NOT NULL COMMENT 'A: ativo\nI: inativo',
  `USU_UsuarioCadastroID` int(11) NOT NULL,
  `USU_UsuarioAlteracaoID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `LIR_TIL_TIPO_LINHA`
--

INSERT INTO `LIR_TIL_TIPO_LINHA` (`TIL_ID`, `TIL_Descricao`, `TIL_Tipo`, `TIL_DataHoraCadastro`, `TIL_DataHoraAlteracao`, `TIL_Status`, `USU_UsuarioCadastroID`, `USU_UsuarioAlteracaoID`) VALUES
(1, 'DESPESA1', 'D', '2015-07-22 23:13:32', NULL, 'A', 1, NULL),
(2, 'RECEITA1', 'R', '2015-07-22 23:13:41', NULL, 'A', 1, NULL);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `CAD_ACO_ACOES`
--
ALTER TABLE `CAD_ACO_ACOES`
 ADD PRIMARY KEY (`ACO_ID`);

--
-- Índices de tabela `CAD_FAC_FORMULARIOS_ACOES`
--
ALTER TABLE `CAD_FAC_FORMULARIOS_ACOES`
 ADD PRIMARY KEY (`ACO_ID`,`FRM_ID`), ADD KEY `FK_CAD_ACO_FRM` (`FRM_ID`), ADD KEY `FK_CAD_FRM_ACO` (`ACO_ID`);

--
-- Índices de tabela `CAD_FRM_FORMULARIOS`
--
ALTER TABLE `CAD_FRM_FORMULARIOS`
 ADD PRIMARY KEY (`FRM_ID`);

--
-- Índices de tabela `CAD_GPE_GRUPOS_PERMISSOES`
--
ALTER TABLE `CAD_GPE_GRUPOS_PERMISSOES`
 ADD PRIMARY KEY (`GRU_ID`,`ACO_ID`,`FRM_ID`), ADD KEY `FK_GPE_FRM_ID_ACO_ID` (`ACO_ID`,`FRM_ID`), ADD KEY `FK_GPE_GRU_ID` (`GRU_ID`);

--
-- Índices de tabela `CAD_GRU_GRUPOS_USUARIOS`
--
ALTER TABLE `CAD_GRU_GRUPOS_USUARIOS`
 ADD PRIMARY KEY (`GRU_ID`);

--
-- Índices de tabela `CAD_LOG_LOGS`
--
ALTER TABLE `CAD_LOG_LOGS`
 ADD PRIMARY KEY (`LOG_ID`), ADD KEY `FK_CAD_USU_LOG` (`USU_ID`);

--
-- Índices de tabela `CAD_MCT_MODULOS_CATEGORIAS`
--
ALTER TABLE `CAD_MCT_MODULOS_CATEGORIAS`
 ADD PRIMARY KEY (`MCT_ID`);

--
-- Índices de tabela `CAD_MFR_MODULOS_FORMULARIOS`
--
ALTER TABLE `CAD_MFR_MODULOS_FORMULARIOS`
 ADD PRIMARY KEY (`MOD_ID`,`FRM_ID`), ADD KEY `FK_CAD_FRM_MOD` (`FRM_ID`), ADD KEY `FK_CAD_MOD_FRM` (`MOD_ID`);

--
-- Índices de tabela `CAD_MOD_MODULOS`
--
ALTER TABLE `CAD_MOD_MODULOS`
 ADD PRIMARY KEY (`MOD_ID`), ADD KEY `FK_CAD_MCT_MOD` (`MCT_ID`);

--
-- Índices de tabela `CAD_PAR_PARAMETROS`
--
ALTER TABLE `CAD_PAR_PARAMETROS`
 ADD PRIMARY KEY (`PAR_CNPJ`);

--
-- Índices de tabela `CAD_UPE_USUARIOS_PERMISSOES`
--
ALTER TABLE `CAD_UPE_USUARIOS_PERMISSOES`
 ADD PRIMARY KEY (`ACO_ID`,`FRM_ID`,`USU_ID`), ADD KEY `FK_CAD_USU_FAC` (`USU_ID`), ADD KEY `FK_CAD_FAC_USU` (`ACO_ID`,`FRM_ID`);

--
-- Índices de tabela `CAD_USA_USUARIOS_ACESSOS`
--
ALTER TABLE `CAD_USA_USUARIOS_ACESSOS`
 ADD PRIMARY KEY (`USA_ID`), ADD KEY `FK_CAD_USU_USA` (`USU_ID`);

--
-- Índices de tabela `CAD_USU_USUARIOS`
--
ALTER TABLE `CAD_USU_USUARIOS`
 ADD PRIMARY KEY (`USU_ID`), ADD UNIQUE KEY `USU_Login_UNIQUE` (`USU_Login`), ADD KEY `FK_CAD_GRU_USU` (`GRU_ID`);

--
-- Índices de tabela `LIR_FAU_FOLHA_AUXILIAR`
--
ALTER TABLE `LIR_FAU_FOLHA_AUXILIAR`
 ADD PRIMARY KEY (`FAU_ID`,`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_LIR_LIA_LIVRO_AUXILIAR1_idx` (`LIA_ID`), ADD KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`);

--
-- Índices de tabela `LIR_FPR_FOLHA_PREVIO`
--
ALTER TABLE `LIR_FPR_FOLHA_PREVIO`
 ADD PRIMARY KEY (`FPR_ID`,`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_LIR_LIP_LIVRO_PREVIO1_idx` (`LIP_ID`), ADD KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`);

--
-- Índices de tabela `LIR_LAU_LINHA_AUXILIAR`
--
ALTER TABLE `LIR_LAU_LINHA_AUXILIAR`
 ADD PRIMARY KEY (`LAU_ID`), ADD KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_LFA_LIVRO_FOLHA_AUXILIA_idx` (`FAU_ID`), ADD KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_TLA_TIPO_LIVRO_AUXILIAR_idx` (`TIL_ID`), ADD KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`);

--
-- Índices de tabela `LIR_LIA_LIVRO_AUXILIAR`
--
ALTER TABLE `LIR_LIA_LIVRO_AUXILIAR`
 ADD PRIMARY KEY (`LIA_ID`,`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LIA_LIVRO_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`);

--
-- Índices de tabela `LIR_LIP_LIVRO_PREVIO`
--
ALTER TABLE `LIR_LIP_LIVRO_PREVIO`
 ADD PRIMARY KEY (`LIP_ID`,`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_LIP_LIVRO_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`);

--
-- Índices de tabela `LIR_LPR_LINHA_PREVIO`
--
ALTER TABLE `LIR_LPR_LINHA_PREVIO`
 ADD PRIMARY KEY (`LPR_ID`), ADD KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_LFP_LIVRO_FOLHA_PREVIO1_idx` (`FPR_ID`), ADD KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`), ADD KEY `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_TIL_TIPO_LINHA1_idx` (`TIL_ID`), ADD KEY `fk_LIR_LPR_LINHA_PREVIO_CAD_USU_USUARIOS1_idx` (`USU_StatusConclusao_ID`);

--
-- Índices de tabela `LIR_TIL_TIPO_LINHA`
--
ALTER TABLE `LIR_TIL_TIPO_LINHA`
 ADD PRIMARY KEY (`TIL_ID`,`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS1_idx` (`USU_UsuarioCadastroID`), ADD KEY `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS2_idx` (`USU_UsuarioAlteracaoID`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `CAD_ACO_ACOES`
--
ALTER TABLE `CAD_ACO_ACOES`
MODIFY `ACO_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de tabela `CAD_FRM_FORMULARIOS`
--
ALTER TABLE `CAD_FRM_FORMULARIOS`
MODIFY `FRM_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de tabela `CAD_GRU_GRUPOS_USUARIOS`
--
ALTER TABLE `CAD_GRU_GRUPOS_USUARIOS`
MODIFY `GRU_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `CAD_LOG_LOGS`
--
ALTER TABLE `CAD_LOG_LOGS`
MODIFY `LOG_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `CAD_MCT_MODULOS_CATEGORIAS`
--
ALTER TABLE `CAD_MCT_MODULOS_CATEGORIAS`
MODIFY `MCT_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `CAD_MOD_MODULOS`
--
ALTER TABLE `CAD_MOD_MODULOS`
MODIFY `MOD_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `CAD_USA_USUARIOS_ACESSOS`
--
ALTER TABLE `CAD_USA_USUARIOS_ACESSOS`
MODIFY `USA_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `CAD_USU_USUARIOS`
--
ALTER TABLE `CAD_USU_USUARIOS`
MODIFY `USU_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `LIR_FAU_FOLHA_AUXILIAR`
--
ALTER TABLE `LIR_FAU_FOLHA_AUXILIAR`
MODIFY `FAU_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `LIR_FPR_FOLHA_PREVIO`
--
ALTER TABLE `LIR_FPR_FOLHA_PREVIO`
MODIFY `FPR_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `LIR_LAU_LINHA_AUXILIAR`
--
ALTER TABLE `LIR_LAU_LINHA_AUXILIAR`
MODIFY `LAU_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `LIR_LIA_LIVRO_AUXILIAR`
--
ALTER TABLE `LIR_LIA_LIVRO_AUXILIAR`
MODIFY `LIA_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `LIR_LIP_LIVRO_PREVIO`
--
ALTER TABLE `LIR_LIP_LIVRO_PREVIO`
MODIFY `LIP_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `LIR_LPR_LINHA_PREVIO`
--
ALTER TABLE `LIR_LPR_LINHA_PREVIO`
MODIFY `LPR_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `LIR_TIL_TIPO_LINHA`
--
ALTER TABLE `LIR_TIL_TIPO_LINHA`
MODIFY `TIL_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `CAD_FAC_FORMULARIOS_ACOES`
--
ALTER TABLE `CAD_FAC_FORMULARIOS_ACOES`
ADD CONSTRAINT `FK_CAD_ACO_FRM` FOREIGN KEY (`ACO_ID`) REFERENCES `CAD_ACO_ACOES` (`ACO_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_CAD_FRM_ACO` FOREIGN KEY (`FRM_ID`) REFERENCES `CAD_FRM_FORMULARIOS` (`FRM_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `CAD_GPE_GRUPOS_PERMISSOES`
--
ALTER TABLE `CAD_GPE_GRUPOS_PERMISSOES`
ADD CONSTRAINT `FK_GPE_FRM_ID_ACO_ID` FOREIGN KEY (`ACO_ID`, `FRM_ID`) REFERENCES `CAD_FAC_FORMULARIOS_ACOES` (`ACO_ID`, `FRM_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `FK_GPE_GRU_ID` FOREIGN KEY (`GRU_ID`) REFERENCES `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `CAD_LOG_LOGS`
--
ALTER TABLE `CAD_LOG_LOGS`
ADD CONSTRAINT `FK_CAD_USU_LOG` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `CAD_MFR_MODULOS_FORMULARIOS`
--
ALTER TABLE `CAD_MFR_MODULOS_FORMULARIOS`
ADD CONSTRAINT `FK_CAD_FRM_MOD` FOREIGN KEY (`MOD_ID`) REFERENCES `CAD_MOD_MODULOS` (`MOD_ID`) ON DELETE NO ACTION,
ADD CONSTRAINT `FK_CAD_MOD_FRM` FOREIGN KEY (`FRM_ID`) REFERENCES `CAD_FRM_FORMULARIOS` (`FRM_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `CAD_MOD_MODULOS`
--
ALTER TABLE `CAD_MOD_MODULOS`
ADD CONSTRAINT `FK_CAD_MCT_MOD` FOREIGN KEY (`MCT_ID`) REFERENCES `CAD_MCT_MODULOS_CATEGORIAS` (`MCT_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `CAD_UPE_USUARIOS_PERMISSOES`
--
ALTER TABLE `CAD_UPE_USUARIOS_PERMISSOES`
ADD CONSTRAINT `FK_CAD_FAC_USU` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION,
ADD CONSTRAINT `FK_CAD_USU_FAC` FOREIGN KEY (`ACO_ID`, `FRM_ID`) REFERENCES `CAD_FAC_FORMULARIOS_ACOES` (`ACO_ID`, `FRM_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `CAD_USA_USUARIOS_ACESSOS`
--
ALTER TABLE `CAD_USA_USUARIOS_ACESSOS`
ADD CONSTRAINT `FK_CAD_USU_USA` FOREIGN KEY (`USU_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `CAD_USU_USUARIOS`
--
ALTER TABLE `CAD_USU_USUARIOS`
ADD CONSTRAINT `FK_USU_GRU_ID` FOREIGN KEY (`GRU_ID`) REFERENCES `CAD_GRU_GRUPOS_USUARIOS` (`GRU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_FAU_FOLHA_AUXILIAR`
--
ALTER TABLE `LIR_FAU_FOLHA_AUXILIAR`
ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_LFA_LIVRO_FOLHA_AUXILIAR_LIR_LIA_LIVRO_AUXILIAR1` FOREIGN KEY (`LIA_ID`) REFERENCES `LIR_LIA_LIVRO_AUXILIAR` (`LIA_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_FPR_FOLHA_PREVIO`
--
ALTER TABLE `LIR_FPR_FOLHA_PREVIO`
ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_LFP_LIVRO_FOLHA_PREVIO_LIR_LIP_LIVRO_PREVIO1` FOREIGN KEY (`LIP_ID`) REFERENCES `LIR_LIP_LIVRO_PREVIO` (`LIP_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_LAU_LINHA_AUXILIAR`
--
ALTER TABLE `LIR_LAU_LINHA_AUXILIAR`
ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_LFA_LIVRO_FOLHA_AUXILIAR1` FOREIGN KEY (`FAU_ID`) REFERENCES `LIR_FAU_FOLHA_AUXILIAR` (`FAU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLA_FOLHA_LINHA_AUXILIAR_LIR_TLA_TIPO_LIVRO_AUXILIAR1` FOREIGN KEY (`TIL_ID`) REFERENCES `LIR_TIL_TIPO_LINHA` (`TIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_LIA_LIVRO_AUXILIAR`
--
ALTER TABLE `LIR_LIA_LIVRO_AUXILIAR`
ADD CONSTRAINT `fk_LIR_LIA_LIVRO_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_LIP_LIVRO_PREVIO`
--
ALTER TABLE `LIR_LIP_LIVRO_PREVIO`
ADD CONSTRAINT `fk_LIR_LIP_LIVRO_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_LPR_LINHA_PREVIO`
--
ALTER TABLE `LIR_LPR_LINHA_PREVIO`
ADD CONSTRAINT `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLP_FOLHA_LINHA_PREVIO_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_LFP_LIVRO_FOLHA_PREVIO1` FOREIGN KEY (`FPR_ID`) REFERENCES `LIR_FPR_FOLHA_PREVIO` (`FPR_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_FLP_FOLHA_LINHA_PREVIO_LIR_TIL_TIPO_LINHA1` FOREIGN KEY (`TIL_ID`) REFERENCES `LIR_TIL_TIPO_LINHA` (`TIL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_LPR_LINHA_PREVIO_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_StatusConclusao_ID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `LIR_TIL_TIPO_LINHA`
--
ALTER TABLE `LIR_TIL_TIPO_LINHA`
ADD CONSTRAINT `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS1` FOREIGN KEY (`USU_UsuarioCadastroID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_LIR_TLA_TIPO_LINHA_AUXILIAR_CAD_USU_USUARIOS2` FOREIGN KEY (`USU_UsuarioAlteracaoID`) REFERENCES `CAD_USU_USUARIOS` (`USU_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
