-- MySQL dump 10.13  Distrib 5.6.24, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: CARTORIO_ANTIGO
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `liv_folha`
--

DROP TABLE IF EXISTS `liv_folha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_folha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_folha` varchar(45) COLLATE utf8_bin NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `liv_livro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`liv_livro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_folha`
--

LOCK TABLES `liv_folha` WRITE;
/*!40000 ALTER TABLE `liv_folha` DISABLE KEYS */;
INSERT INTO `liv_folha` VALUES (1,'1','2015-01-06 11:52:00',1),(2,'2','2015-07-27 00:00:00',1),(3,'3','2015-07-27 00:00:00',1);
/*!40000 ALTER TABLE `liv_folha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_folha_previo`
--

DROP TABLE IF EXISTS `liv_folha_previo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_folha_previo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_folha` varchar(45) COLLATE utf8_bin NOT NULL,
  `liv_livro_previo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`liv_livro_previo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_folha_previo`
--

LOCK TABLES `liv_folha_previo` WRITE;
/*!40000 ALTER TABLE `liv_folha_previo` DISABLE KEYS */;
INSERT INTO `liv_folha_previo` VALUES (1,'1',1);
/*!40000 ALTER TABLE `liv_folha_previo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_linha_auxiliar`
--

DROP TABLE IF EXISTS `liv_linha_auxiliar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_linha_auxiliar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8_bin,
  `valor` double NOT NULL,
  `excluido` int(11) NOT NULL,
  `cpf` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `guia` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `protocolo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `liv_tipos_receita_id` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  `liv_folha_id` int(11) NOT NULL,
  `liv_folha_liv_livro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`liv_tipos_receita_id`,`sis_usuario_id`,`liv_folha_id`,`liv_folha_liv_livro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_linha_auxiliar`
--

LOCK TABLES `liv_linha_auxiliar` WRITE;
/*!40000 ALTER TABLE `liv_linha_auxiliar` DISABLE KEYS */;
INSERT INTO `liv_linha_auxiliar` VALUES (1,'DESCRICAO1',50,0,'','','',0,1,1,2,1),(2,'QWEQWE',3.24,0,'23423432432','342','234',234,1,1,2,1),(3,'ASD',3.33,0,'23432432423','ASD','ASD',234,1,1,2,1),(4,'QWEQW',3.24,0,'32432432423','QWEQW','EQWEQWE',23142423,1,1,3,1);
/*!40000 ALTER TABLE `liv_linha_auxiliar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_linha_despesa`
--

DROP TABLE IF EXISTS `liv_linha_despesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_linha_despesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8_bin,
  `valor` double NOT NULL,
  `excluido` int(11) NOT NULL,
  `liv_tipo_despesa_id` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  `liv_folha_id` int(11) NOT NULL,
  `liv_folha_liv_livro_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`liv_tipo_despesa_id`,`sis_usuario_id`,`liv_folha_id`,`liv_folha_liv_livro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_linha_despesa`
--

LOCK TABLES `liv_linha_despesa` WRITE;
/*!40000 ALTER TABLE `liv_linha_despesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `liv_linha_despesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_linha_previo`
--

DROP TABLE IF EXISTS `liv_linha_previo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_linha_previo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8_bin,
  `valor` double NOT NULL,
  `excluido` int(11) NOT NULL,
  `cpf` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `guia` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `nome` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `status_conclusao` int(11) NOT NULL COMMENT 'status conclusao é pra definir quando o documento é encerrado\n\nao se concluir o evento gravar em livro\nauxiliar os dados do livro previo\n',
  `quantidade` int(11) DEFAULT NULL,
  `liv_tipos_receita_id` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  `liv_linha_auxiliar_id` int(11) DEFAULT NULL,
  `liv_folha_previo_id` int(11) NOT NULL,
  `liv_livro_previo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`liv_tipos_receita_id`,`sis_usuario_id`,`liv_folha_previo_id`,`liv_livro_previo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_linha_previo`
--

LOCK TABLES `liv_linha_previo` WRITE;
/*!40000 ALTER TABLE `liv_linha_previo` DISABLE KEYS */;
/*!40000 ALTER TABLE `liv_linha_previo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_livro`
--

DROP TABLE IF EXISTS `liv_livro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_livro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_livro` varchar(45) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_livro`
--

LOCK TABLES `liv_livro` WRITE;
/*!40000 ALTER TABLE `liv_livro` DISABLE KEYS */;
INSERT INTO `liv_livro` VALUES (1,'3');
/*!40000 ALTER TABLE `liv_livro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_livro_previo`
--

DROP TABLE IF EXISTS `liv_livro_previo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_livro_previo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_livro` varchar(45) COLLATE utf8_bin NOT NULL,
  `data_cadastro` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_livro_previo`
--

LOCK TABLES `liv_livro_previo` WRITE;
/*!40000 ALTER TABLE `liv_livro_previo` DISABLE KEYS */;
INSERT INTO `liv_livro_previo` VALUES (1,'3','2015-01-06');
/*!40000 ALTER TABLE `liv_livro_previo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_tipo_despesa`
--

DROP TABLE IF EXISTS `liv_tipo_despesa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_tipo_despesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE utf8_bin NOT NULL,
  `excluido` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`sis_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_tipo_despesa`
--

LOCK TABLES `liv_tipo_despesa` WRITE;
/*!40000 ALTER TABLE `liv_tipo_despesa` DISABLE KEYS */;
INSERT INTO `liv_tipo_despesa` VALUES (1,'DESPESA 1',0,1);
/*!40000 ALTER TABLE `liv_tipo_despesa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liv_tipos_receita`
--

DROP TABLE IF EXISTS `liv_tipos_receita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liv_tipos_receita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE utf8_bin NOT NULL,
  `excluido` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`sis_usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liv_tipos_receita`
--

LOCK TABLES `liv_tipos_receita` WRITE;
/*!40000 ALTER TABLE `liv_tipos_receita` DISABLE KEYS */;
INSERT INTO `liv_tipos_receita` VALUES (1,'RECEITA1',0,1);
/*!40000 ALTER TABLE `liv_tipos_receita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_acoes_formulario`
--

DROP TABLE IF EXISTS `sis_acoes_formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_acoes_formulario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE utf8_bin NOT NULL,
  `excluido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_acoes_formulario`
--

LOCK TABLES `sis_acoes_formulario` WRITE;
/*!40000 ALTER TABLE `sis_acoes_formulario` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_acoes_formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_acoes_usuario`
--

DROP TABLE IF EXISTS `sis_acoes_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_acoes_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sis_formulario_acoes_id` int(11) NOT NULL,
  `sis_formulario_acoes_sis_formulario_id` int(11) NOT NULL,
  `sis_formulario_acoes_sis_acoes_formulario_id` int(11) NOT NULL,
  `sis_usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`sis_formulario_acoes_id`,`sis_formulario_acoes_sis_formulario_id`,`sis_formulario_acoes_sis_acoes_formulario_id`,`sis_usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_acoes_usuario`
--

LOCK TABLES `sis_acoes_usuario` WRITE;
/*!40000 ALTER TABLE `sis_acoes_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_acoes_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_formulario`
--

DROP TABLE IF EXISTS `sis_formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_formulario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE utf8_bin NOT NULL,
  `caminho` varchar(45) COLLATE utf8_bin NOT NULL,
  `excluido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_formulario`
--

LOCK TABLES `sis_formulario` WRITE;
/*!40000 ALTER TABLE `sis_formulario` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_formulario_acoes`
--

DROP TABLE IF EXISTS `sis_formulario_acoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_formulario_acoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sis_formulario_id` int(11) NOT NULL,
  `sis_acoes_formulario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`sis_formulario_id`,`sis_acoes_formulario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_formulario_acoes`
--

LOCK TABLES `sis_formulario_acoes` WRITE;
/*!40000 ALTER TABLE `sis_formulario_acoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_formulario_acoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_modulo`
--

DROP TABLE IF EXISTS `sis_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE utf8_bin NOT NULL,
  `caminho` varchar(45) COLLATE utf8_bin NOT NULL,
  `ordem` int(11) NOT NULL,
  `excluido` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_modulo`
--

LOCK TABLES `sis_modulo` WRITE;
/*!40000 ALTER TABLE `sis_modulo` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_modulo_formulario_menu`
--

DROP TABLE IF EXISTS `sis_modulo_formulario_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_modulo_formulario_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sis_modulo_id` int(11) NOT NULL,
  `sis_formulario_id` int(11) NOT NULL,
  `menu_nivel_1` text COLLATE utf8_bin NOT NULL,
  `menu_nivel_2` text COLLATE utf8_bin,
  `menu_nivel_3` text COLLATE utf8_bin,
  PRIMARY KEY (`id`,`sis_modulo_id`,`sis_formulario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_modulo_formulario_menu`
--

LOCK TABLES `sis_modulo_formulario_menu` WRITE;
/*!40000 ALTER TABLE `sis_modulo_formulario_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `sis_modulo_formulario_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sis_usuario`
--

DROP TABLE IF EXISTS `sis_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sis_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) COLLATE utf8_bin NOT NULL,
  `senha` varchar(45) COLLATE utf8_bin NOT NULL,
  `email` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `telefone` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_ultimo_login` datetime DEFAULT NULL,
  `excluido` int(11) NOT NULL,
  `tipo` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'define se e: \nadminsitrador\nauxiliar\nprévio\ndespesa\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sis_usuario`
--

LOCK TABLES `sis_usuario` WRITE;
/*!40000 ALTER TABLE `sis_usuario` DISABLE KEYS */;
INSERT INTO `sis_usuario` VALUES (1,'lucas','202cb962ac59075b964b07152d234b70',NULL,NULL,'2014-01-01 00:00:00','2015-08-15 08:57:13',0,'ADMINISTRADOR'),(2,'diego','63a9f0ea7bb98050796b649e85481845','','','2014-04-30 11:35:06','2015-01-05 14:55:27',0,'ADMINISTRADOR'),(4,'claudia','03c7c0ace395d80182db07ae2c30f034','','','2014-04-30 11:38:07','2014-04-30 14:03:29',0,'ADMINISTRADOR'),(5,'leo','202cb962ac59075b964b07152d234b70','','','2014-05-12 14:22:31','2014-05-22 09:17:02',0,'ADMINISTRADOR'),(6,'claudia','03c7c0ace395d80182db07ae2c30f034','','','2014-05-19 11:58:02',NULL,1,'ADMINISTRADOR'),(7,'diego','63a9f0ea7bb98050796b649e85481845','','','2014-05-22 09:17:18',NULL,1,'ADMINISTRADOR');
/*!40000 ALTER TABLE `sis_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-24 19:43:19
