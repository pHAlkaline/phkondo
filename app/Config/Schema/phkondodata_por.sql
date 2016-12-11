-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: phkondo
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Dumping data for table `budget_statuses`
--

LOCK TABLES `budget_statuses` WRITE;
/*!40000 ALTER TABLE `budget_statuses` DISABLE KEYS */;
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Inactivo',1,NOW(),NOW());
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Activo',1,NOW(),NOW());
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Fechado',1,NOW(),NOW());
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Cancelado',1,NOW(),NOW());
/*!40000 ALTER TABLE `budget_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `budget_types`
--

LOCK TABLES `budget_types` WRITE;
/*!40000 ALTER TABLE `budget_types` DISABLE KEYS */;
INSERT INTO `budget_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Ordinario',1,NOW(),NOW());
INSERT INTO `budget_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Extra',1,NOW(),NOW());
/*!40000 ALTER TABLE `budget_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `entity_types`
--

LOCK TABLES `entity_types` WRITE;
/*!40000 ALTER TABLE `entity_types` DISABLE KEYS */;
INSERT INTO `entity_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Cliente',1,NOW(),NOW());
INSERT INTO `entity_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Fornecedor',1,NOW(),NOW());
/*!40000 ALTER TABLE `entity_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fraction_types`
--
LOCK tables `fraction_types` WRITE;
/*!40000 ALTER TABLE `fraction_types` DISABLE KEYS */;
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Apartamento', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Moradia', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Garagem', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Parqueamento', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Arrecadação', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Sótao', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Sobreloja', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Cave', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (9, 'Sub-Cave', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Escritório', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Condomínio', 1, NOW(), NOW());
/*!40000 ALTER TABLE `fraction_types` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `insurance_types`
--

LOCK TABLES `insurance_types` WRITE;
/*!40000 ALTER TABLE `insurance_types` DISABLE KEYS */;
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Multiriscos Habitação',1,NOW(),NOW());
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Incêncio',1,NOW(),NOW());
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Responsabilidade Civil',1,NOW(),NOW());
/*!40000 ALTER TABLE `insurance_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invoice_conference_statuses`
--

LOCK TABLES `invoice_conference_statuses` WRITE;
/*!40000 ALTER TABLE `invoice_conference_statuses` DISABLE KEYS */;
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Recepção',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Conferência',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Aprovação',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Pagamento',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Pago',1,NOW(),NOW());
/*!40000 ALTER TABLE `invoice_conference_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movement_categories`
--

LOCK TABLES `movement_categories` WRITE;
/*!40000 ALTER TABLE `movement_categories` DISABLE KEYS */;
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Abertura / Fecho',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Limpeza',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Seguros',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Manutenção',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Agua',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (6,'Luz',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (7,'Operações Extraordinárias',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (8,'Quotas',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (9,'CTT',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (10,'Contencioso',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (11,'Administração',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (12,'Elevadores',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (13,'Manutenção de Elevadores ',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (14,'Despesas de Administração',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (15,'Fundo de caixa',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (16,'Despesas Administrativas',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (17,'PT Comunicações',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (18,'Despesas bancárias',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (19,'Liquidação de conta',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (20,'Limpeza LCM',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (21,'Adminstração LCM',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (22,'Juros Bancários',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (23,'Criação fundo comum de reserva',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (24,'Liquidação fundo comum de reserva',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (25,'Abertura de conta bancária',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (26,'Requisição de cheques',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (27,'Conta Poupança',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (28,'Acerto de contas',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (29,'Reuniões Extraordinárias ',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (30,'Reunião Extraordinária',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (31,'Detergentes',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (32,'Limpeza Gestifácil',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (33,'Adiantamento',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (34,'Nacacomunik',1,NOW(),NOW());
/*!40000 ALTER TABLE `movement_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movement_operations`
--

LOCK TABLES `movement_operations` WRITE;
/*!40000 ALTER TABLE `movement_operations` DISABLE KEYS */;
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Abertura Balancete',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Fecho Balancete',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Transferências',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Recebimentos em numerário',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Pagamentos em numerário',1,NOW(),NOW());
/*!40000 ALTER TABLE `movement_operations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movement_types`
--

LOCK TABLES `movement_types` WRITE;
/*!40000 ALTER TABLE `movement_types` DISABLE KEYS */;
INSERT INTO `movement_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Crédito',1,NOW(),NOW());
INSERT INTO `movement_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Débito',1,NOW(),NOW());
/*!40000 ALTER TABLE `movement_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `note_statuses`
--

LOCK TABLES `note_statuses` WRITE;
/*!40000 ALTER TABLE `note_statuses` DISABLE KEYS */;
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Aguarda Pagamento',1,NOW(),NOW());
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Pago Parcial',0,NOW(),NOW());
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Pago',1,NOW(),NOW());
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Cancelado',1,NOW(),NOW());
/*!40000 ALTER TABLE `note_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `note_types`
--

LOCK TABLES `note_types` WRITE;
/*!40000 ALTER TABLE `note_types` DISABLE KEYS */;
INSERT INTO `note_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Credito',1,NOW(),NOW());
INSERT INTO `note_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Debito',1,NOW(),NOW());
/*!40000 ALTER TABLE `note_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `receipt_payment_types`
--

LOCK TABLES `receipt_payment_types` WRITE;
/*!40000 ALTER TABLE `receipt_payment_types` DISABLE KEYS */;
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Numerário',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Multibanco',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Transferência',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Depósito',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Cheque',1,NOW(),NOW());
/*!40000 ALTER TABLE `receipt_payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `receipt_statuses`
--

LOCK TABLES `receipt_statuses` WRITE;
/*!40000 ALTER TABLE `receipt_statuses` DISABLE KEYS */;
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pendente',1,NOW(),NOW());
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Aguarda Pagamento',1,NOW(),NOW());
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Pago',1,NOW(),NOW());
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Anulado',1,NOW(),NOW());
/*!40000 ALTER TABLE `receipt_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `share_distributions`
--

LOCK TABLES `share_distributions` WRITE;
/*!40000 ALTER TABLE `share_distributions` DISABLE KEYS */;
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Igual',1,NOW(),NOW());
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Permilagem',1,NOW(),NOW());
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Manual',1,NOW(),NOW());
/*!40000 ALTER TABLE `share_distributions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `share_periodicities`
--

LOCK TABLES `share_periodicities` WRITE;
/*!40000 ALTER TABLE `share_periodicities` DISABLE KEYS */;
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Unica',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Anual',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Semestral',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Trimestral',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Mensal',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (6,'Semanal',1,NOW(),NOW());
/*!40000 ALTER TABLE `share_periodicities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_statuses`
--

LOCK TABLES `support_statuses` WRITE;
/*!40000 ALTER TABLE `support_statuses` DISABLE KEYS */;
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pendente',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Aberto',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Fechado',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
/*!40000 ALTER TABLE `support_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_categories`
--

LOCK TABLES `support_categories` WRITE;
/*!40000 ALTER TABLE `support_categories` DISABLE KEYS */;
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Incidencia',1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Pedido de Informação',1,'2016-03-12 22:27:32','2016-03-12 00:00:00');
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Reclamação',1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
/*!40000 ALTER TABLE `support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_priorities`
--

LOCK TABLES `support_priorities` WRITE;
/*!40000 ALTER TABLE `support_priorities` DISABLE KEYS */;
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (1,'Alta',1,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (2,'Normal',2,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (3,'Baixa',3,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
/*!40000 ALTER TABLE `support_priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` ( `name`, `username`, `password`, `role`, `active`, `modified`, `created`) VALUES ('Administrador','admin','b8ebe5d64db2e878e267d8b3d0ad4b0753ea9d38','admin',1,NOW(),NOW());

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'phkondo'
--

--
-- Dumping routines for database 'phkondo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-13 14:30:31
