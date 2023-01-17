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
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Pending',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Active',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Closed',1,NOW() ,NOW());
INSERT INTO `budget_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Canceled',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `budget_statuses` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `budget_types`
--

LOCK tables `budget_types` WRITE;
/*!40000 ALTER TABLE `budget_types` DISABLE KEYS */;
INSERT INTO `budget_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Ordinary',1,NOW() ,NOW());
INSERT INTO `budget_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Extra',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `budget_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `entity_types`
--

LOCK tables `entity_types` WRITE;
/*!40000 ALTER TABLE `entity_types` DISABLE KEYS */;
INSERT INTO `entity_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Customer',1,NOW() ,NOW());
INSERT INTO `entity_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Supplier',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `entity_types` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `fraction_types`
--
LOCK tables `fraction_types` WRITE;
/*!40000 ALTER TABLE `fraction_types` DISABLE KEYS */;
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Apartment', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Home', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Garage', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Parking', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Collection', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Attic', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Store', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Basement', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (9, 'Cellar', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Office', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Condominium', 1, NOW(), NOW());
/*!40000 ALTER TABLE `fraction_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `insurance_types`
--

LOCK tables `insurance_types` WRITE;
/*!40000 ALTER TABLE `insurance_types` DISABLE KEYS */;
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Multirisk Home',1,NOW() ,NOW());
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Fire Insurance',1,NOW() ,NOW());
INSERT INTO `insurance_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Liability',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `insurance_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `invoice_conference_statuses`
--

LOCK tables `invoice_conference_statuses` WRITE;
/*!40000 ALTER TABLE `invoice_conference_statuses` DISABLE KEYS */;
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Reception',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Conference',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Approval',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Payment',1,NOW() ,NOW());
INSERT INTO `invoice_conference_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Paid',1,NOW() ,NOW()); 
/*!40000  ALTER TABLE `invoice_conference_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_categories`
--

LOCK tables `movement_categories` WRITE;
/*!40000 ALTER TABLE `movement_categories` DISABLE KEYS */;
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Opening / Closing',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Cleaning',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Insurance', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Maintenance',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Water',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Electricity',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Extraordinary Operations',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Notes',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (9, 'PostOffice',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Litigation',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Administration',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (12, 'Elevators', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (13, 'Elevators Maintenance',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (14, 'Cash',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (15, 'Administrative costs',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (16, 'Phone',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (17, 'Bank charges',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (18, 'Settlement of account',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (19, 'Bank Interest',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (20, 'Creation common fund of reserve',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (21, 'Liquidation common fund of reserve',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (22, 'Opening of bank account',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (23, 'Requisition checks',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (24, 'Savings account',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (25, 'Settlement of payments',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (26, 'Extraordinary meeting', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (27, 'Cleaning Products', 1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (28, 'Advance',1,NOW() ,NOW());
INSERT INTO `movement_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (29, 'Others',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_categories` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_operations`
--

LOCK tables `movement_operations` WRITE;
/*!40000 ALTER TABLE `movement_operations` DISABLE KEYS */;
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Opening Balance',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Closing Balance',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Internal Operation',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Transfers',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Cash',1,NOW() ,NOW());
INSERT INTO `movement_operations` ( `id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Check',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_operations` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `movement_types`
--

LOCK tables `movement_types` WRITE;
/*!40000 ALTER TABLE `movement_types` DISABLE KEYS */;
INSERT INTO `movement_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Credit',1,NOW() ,NOW());
INSERT INTO `movement_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Debit',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `movement_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `note_statuses`
--

LOCK tables `note_statuses` WRITE;
/*!40000 ALTER TABLE `note_statuses` DISABLE KEYS */;
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Awaiting Payment',1,NOW() ,NOW());
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Paid Partial',0,NOW() ,NOW());
INSERT INTO `note_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Paid',1,NOW() ,NOW());
INSERT INTO `note_statuses` ( `ID`, `name`, `active`, `modified`, `created`) VALUES (4, 'Canceled',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `note_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `note_types`
--

LOCK tables `note_types` WRITE;
/*!40000 ALTER TABLE `note_types` DISABLE KEYS */;
INSERT INTO `note_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Credit',1,NOW() ,NOW());
INSERT INTO `note_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Debit',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `note_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `receipt_payment_types`
--

LOCK tables `receipt_payment_types` WRITE ;
/*!40000 ALTER TABLE `receipt_payment_types` DISABLE KEYS */;
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Cash',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'ATM',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Transfer',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Deposit',1,NOW() ,NOW());
INSERT INTO `receipt_payment_types` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Check',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `receipt_payment_types` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `receipt_statuses`
--

LOCK tables `receipt_statuses` WRITE;
/*!40000 ALTER TABLE `receipt_statuses` DISABLE KEYS */;
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Draft',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Awaiting Payment',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Paid',1,NOW() ,NOW());
INSERT INTO `receipt_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Canceled',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `receipt_statuses` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `share_distributions`
--

LOCK tables `share_distributions` WRITE;
/*!40000 ALTER TABLE `share_distributions` DISABLE KEYS */;
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Equal',1,NOW() ,NOW());
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Percentage',1,NOW() ,NOW());
INSERT INTO `share_distributions` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Manual',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `share_distributions` ENABLE KEYS */;
UNLOCK tables;

-- 
-- Dumping data for table `share_periodicities`
--

LOCK tables `share_periodicities` WRITE;
/*!40000 ALTER TABLE `share_periodicities` DISABLE KEYS */;
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Unique',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES ( 2, 'Annual',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Biannual',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Quarterly',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Monthly',1,NOW() ,NOW());
INSERT INTO `share_periodicities` ( `id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Weekly',1,NOW() ,NOW()); 
/*!40000 ALTER TABLE `share_periodicities` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `support_statuses`
--

LOCK TABLES `support_statuses` WRITE;
/*!40000 ALTER TABLE `support_statuses` DISABLE KEYS */;
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pending',1,NOW(),NOW());
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Open',1,NOW(),NOW());
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Closed',1,NOW(),NOW());
/*!40000 ALTER TABLE `support_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_categories`
--

LOCK TABLES `support_categories` WRITE;
/*!40000 ALTER TABLE `support_categories` DISABLE KEYS */;
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Incidence',1,NOW(),NOW());
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Information Request',1,NOW(),NOW());
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Reclaim',1,NOW(),NOW());
/*!40000 ALTER TABLE `support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_priorities`
--

LOCK TABLES `support_priorities` WRITE;
/*!40000 ALTER TABLE `support_priorities` DISABLE KEYS */;
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (1,'High',1,1,NOW(),NOW());
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (2,'Normal',2,1,NOW(),NOW());
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (3,'Low',3,1,NOW(),NOW());
/*!40000 ALTER TABLE `support_priorities` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2022-12-21 2:30:31 PM
