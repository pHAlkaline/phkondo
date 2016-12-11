-- MySQL dump 10.13 Distrib 5.5.41 , is debian-linux-gnu (x86_64)
-- 
-- Host: localhost Database: phkondo
-- ------------------------------------------------------
-- Server version 5.5.41 -0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE= `+00:00` */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE= `NO_AUTO_VALUE_ON_ZERO` */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `budget_statuses`
--

LOCK tables `budget_statuses` WRITE;
/*!40000 ALTER TABLE `budget_statuses` DISABLE KEYS */;
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Inattivo',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Attivo',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Chiuso',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Cancellato',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `budget_statuses` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `budget_types`
--

LOCK tables `budget_types` WRITE;
/*!40000 ALTER TABLE `budget_types` DISABLE KEYS */;
INSERT INTO `budget_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Ordinario',1,NOW() ,NOW());
INSERT INTO `budget_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Extra',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `budget_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `entity_types`
--

LOCK tables `entity_types` WRITE;
/*!40000 ALTER TABLE `entity_types` DISABLE KEYS */;
INSERT INTO `entity_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Cliente',1,NOW() ,NOW());
INSERT INTO `entity_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Fornitore',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `entity_types` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `fraction_types`
--
LOCK tables `fraction_types` WRITE;
/*!40000 ALTER TABLE `fraction_types` DISABLE KEYS */;
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Appartamento', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Casa', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Garage', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Parcheggio', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Collezione', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Attico', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Negozio', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Cave', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (9, 'Sub-Cave', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Ufficio', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Condominio', 1, NOW(), NOW());
/*!40000 ALTER TABLE `fraction_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `insurance_types`
--

LOCK tables `insurance_types` WRITE;
/*!40000 ALTER TABLE `insurance_types` DISABLE KEYS */;
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Multirischio Casa',1,NOW() ,NOW());
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Assicurazione Incendio',1,NOW() ,NOW());
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Responsabilita Civile',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `insurance_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `invoice_conference_statuses`
--

LOCK tables `invoice_conference_statuses` WRITE;
/*!40000 ALTER TABLE `invoice_conference_statuses` DISABLE KEYS */;
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Ricezione',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Conferenza',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Approvazione',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Pagamento',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Pagato',1,NOW() ,NOW()); 
/*!40000  ALTER TABLE `invoice_conference_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_categories`
--

LOCK tables `movement_categories` WRITE;
/*!40000 ALTER TABLE `movement_categories` DISABLE KEYS */;
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Apertura / Chiusura',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Pulizia',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Assicurazione', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Manutenzione',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Acqua',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Elettricita',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Operazioni Straordinarie',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Quote',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (9, 'Ufficio Postale',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Contenzioso',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Amministrazione',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (12, 'Ascensore', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (13, 'Manutenzione Ascensore',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (14, 'Spese di Amministrazione',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (15, 'Fondo Cassa',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (16, 'Costi di Amministrazione',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (17, 'Telefono',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (18, 'Costi Bancari',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (19, 'Liquidazione dei conti',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (20, 'Pulizia',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (21, 'Amministrazione',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (22, 'Interessi bancari',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (23, 'Creazione del fondo cassa',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (24, 'Liquidazione del fondo cassa',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (25, 'Apertura conto corrente',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (26, 'Requisizione assegni',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (27, 'Conto corrente',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (28, 'Liquidazione pagamenti',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (29, 'Riunioni straordinarie',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (30, 'Riunione straordinaria', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (31, 'Prodotti per pulizie', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (32, 'Societa di pulizie',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (33, 'Disavanzo',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (34, 'loro',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_categories` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_operations`
--

LOCK tables `movement_operations` WRITE;
/*!40000 ALTER TABLE `movement_operations` DISABLE KEYS */;
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Saldo Apertura',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Saldo Chiusura',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Trasferimenti',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Contante',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `ID`, `name`, `active`, `modified`, `created`) VALUES (5, 'Pagamenti in contanti',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_operations` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_types`
--

LOCK tables `movement_types` WRITE;
/*!40000 ALTER TABLE `movement_types` DISABLE KEYS */;
INSERT INTO `movement_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Dare',1,NOW() ,NOW());
INSERT INTO `movement_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Avere',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `note_statuses`
--

LOCK tables `note_statuses` WRITE;
/*!40000 ALTER TABLE `note_statuses` DISABLE KEYS */;
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'In attesa di pagamento',1,NOW() ,NOW());
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Pagato parzialmente',0,NOW() ,NOW());
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Pagato',1,NOW() ,NOW());
INSERT INTO `note_statuses` ( `ID`, `name`, `active`, `modified`, `created`) VALUES (4, 'Cancellato',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `note_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `note_types`
--

LOCK tables `note_types` WRITE;
/*!40000 ALTER TABLE `note_types` DISABLE KEYS */;
INSERT INTO `note_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Dare',1,NOW() ,NOW());
INSERT INTO `note_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Avere',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `note_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `receipt_payment_types`
--

LOCK tables `receipt_payment_types` WRITE ;
/*!40000 ALTER TABLE `receipt_payment_types` DISABLE KEYS */;
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Contante',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Bancomat',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Bonifico',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Deposito',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Assegno',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `receipt_payment_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `receipt_statuses`
--

LOCK tables `receipt_statuses` WRITE;
/*!40000 ALTER TABLE `receipt_statuses` DISABLE KEYS */;
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Pendente',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'In attesa di pagamento',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Pagato',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Cancellato',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `receipt_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `share_distributions`
--

LOCK tables `share_distributions` WRITE;
/*!40000 ALTER TABLE `share_distributions` DISABLE KEYS */;
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'In parti uguali',1,NOW() ,NOW());
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'In percentuale',1,NOW() ,NOW());
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Manuale',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `share_distributions` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `share_periodicities`
--

LOCK tables `share_periodicities` WRITE;
/*!40000 ALTER TABLE `share_periodicities` DISABLE KEYS */;
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Unica soluzione',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES ( 2, 'Annuale',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Semestrale',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Quadrimestrale',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Mensile',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Settimanale',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `share_periodicities` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `support_statuses`
--

LOCK TABLES `support_statuses` WRITE;
/*!40000 ALTER TABLE `support_statuses` DISABLE KEYS */;
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pendente',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Aperto',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Chiuso',1,'2014-02-27 16:17:09','2014-02-27 16:17:09');
/*!40000 ALTER TABLE `support_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_categories`
--

LOCK TABLES `support_categories` WRITE;
/*!40000 ALTER TABLE `support_categories` DISABLE KEYS */;
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Avvenimento',1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Richiesta di informazioni',1,'2016-03-12 22:27:32','2016-03-12 00:00:00');
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Reclamo',1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
/*!40000 ALTER TABLE `support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_priorities`
--

LOCK TABLES `support_priorities` WRITE;
/*!40000 ALTER TABLE `support_priorities` DISABLE KEYS */;
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (1,'Alta',1,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (2,'Normale',2,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (3,'Bassa',3,1,'2016-03-12 00:00:00','2016-03-12 00:00:00');
/*!40000 ALTER TABLE `support_priorities` ENABLE KEYS */;
UNLOCK TABLES;

-- 
-- Dumping Date is table `users`
--

LOCK tables `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` ( `name`, `username`, `password`, `role`, `active`, `modified`, `created`) VALUES ( 'Admin' , 'admin' , 'b8sbs5d64db2e878e267d8b3d0ad4b0753ea9d38' , 'admin',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping events is database `phkondo`
-- 

-- 
-- Dumping routines for database `phkondo`
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-11 2:30:31 PM
