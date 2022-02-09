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
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pendiente',1,NOW(),NOW());
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Activo',1,NOW(),NOW());
INSERT INTO `budget_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Cerrado',1,NOW(),NOW());
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
INSERT INTO `entity_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Proveedor',1,NOW(),NOW());
/*!40000 ALTER TABLE `entity_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `fraction_types`
--
LOCK tables `fraction_types` WRITE;
/*!40000 ALTER TABLE `fraction_types` DISABLE KEYS */;
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1, 'Apartamento', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2, 'Casa', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3, 'Garage', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (4, 'Estacionamiento', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (5, 'Alquiler', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (6, 'Ático', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (7, 'Mezanine', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (8, 'Sótano', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (9, 'Sub-Sótano', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (10, 'Oficina', 1, NOW(), NOW());
INSERT INTO `fraction_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (11, 'Condominio', 1, NOW(), NOW());
/*!40000 ALTER TABLE `fraction_types` ENABLE KEYS */;
UNLOCK tables;

--
-- Dumping data for table `insurance_types`
--

LOCK TABLES `insurance_types` WRITE;
/*!40000 ALTER TABLE `insurance_types` DISABLE KEYS */;
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Hogar Multiriesgos',1,NOW(),NOW());
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Seguro de incendio',1,NOW(),NOW());
INSERT INTO `insurance_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Responsabilidad Civil',1,NOW(),NOW());
/*!40000 ALTER TABLE `insurance_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invoice_conference_statuses`
--

LOCK TABLES `invoice_conference_statuses` WRITE;
/*!40000 ALTER TABLE `invoice_conference_statuses` DISABLE KEYS */;
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Recepción',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Conferência',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Aprobación',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Pago',1,NOW(),NOW());
INSERT INTO `invoice_conference_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Pagado',1,NOW(),NOW());
/*!40000 ALTER TABLE `invoice_conference_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movement_categories`
--

LOCK TABLES `movement_categories` WRITE;
/*!40000 ALTER TABLE `movement_categories` DISABLE KEYS */;
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Apertura / Cierre',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Limpieza',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Seguros',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Mantenimiento',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Agua',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (6,'Luz',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (7,'Operaciones Extraordinarios',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (8,'Cuotas',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (9,'Oficina de Correos',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (10,'Litigio',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (11,'Administración',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (12,'Ascensores',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (13,'Mantenimiento de ascensores ',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (14,'Dinero en efectivo',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (15,'Costos administrativos',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (16,'Llamadas telefónica',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (17,'Costos Bancarios',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (18,'Asientos contables',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (19,'Intereses Bancarios',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (20,'Creación de un fondo de reserva común',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (21,'Liquidación de un fondo de reserva común',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (22,'Apertura de cuenta bancaria',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (23,'Solicitud de cheques',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (24,'Cuenta de ahorrros',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (25,'Ajsutes de cuentas',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (26,'Reunión Extraordinaria',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (27,'Detergentes',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (28,'Avances',1,NOW(),NOW());
INSERT INTO `movement_categories` (`id`, `name`, `active`, `modified`, `created`) VALUES (29,'Otros',1,NOW(),NOW());
/*!40000 ALTER TABLE `movement_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `movement_operations`
--

LOCK TABLES `movement_operations` WRITE;
/*!40000 ALTER TABLE `movement_operations` DISABLE KEYS */;
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Saldos de apertura',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Saldos de cierre',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Transferencias',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Efectivo',1,NOW(),NOW());
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Cheque',1,NOW(),NOW());
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
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pago Pendiente',1,NOW(),NOW());
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Pago Parcial',0,NOW(),NOW());
INSERT INTO `note_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Pagado',1,NOW(),NOW());
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
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Efectivo',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'ATM',1,NOW(),NOW());
INSERT INTO `receipt_payment_types` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Transferencia',1,NOW(),NOW());
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
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Pendiente de Pago',1,NOW(),NOW());
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Pagado',1,NOW(),NOW());
INSERT INTO `receipt_statuses` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Anulado',1,NOW(),NOW());
/*!40000 ALTER TABLE `receipt_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `share_distributions`
--

LOCK TABLES `share_distributions` WRITE;
/*!40000 ALTER TABLE `share_distributions` DISABLE KEYS */;
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Igual',1,NOW(),NOW());
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Porcentaje',1,NOW(),NOW());
INSERT INTO `share_distributions` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Manual',1,NOW(),NOW());
/*!40000 ALTER TABLE `share_distributions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `share_periodicities`
--

LOCK TABLES `share_periodicities` WRITE;
/*!40000 ALTER TABLE `share_periodicities` DISABLE KEYS */;
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (1,'Única',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (2,'Anual',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (3,'Semestral',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (4,'Trimestral',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (5,'Mensual',1,NOW(),NOW());
INSERT INTO `share_periodicities` (`id`, `name`, `active`, `modified`, `created`) VALUES (6,'Semanal',1,NOW(),NOW());
/*!40000 ALTER TABLE `share_periodicities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_statuses`
--

LOCK TABLES `support_statuses` WRITE;
/*!40000 ALTER TABLE `support_statuses` DISABLE KEYS */;
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Pendiente',1,NOW(),NOW());
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Abierto',1,NOW(),NOW());
INSERT INTO `support_statuses` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Cerrado',1,NOW(),NOW());
/*!40000 ALTER TABLE `support_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_categories`
--

LOCK TABLES `support_categories` WRITE;
/*!40000 ALTER TABLE `support_categories` DISABLE KEYS */;
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (1,'Incidencia',1,NOW(),NOW());
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (2,'Solicitud de información',1,NOW(),NOW());
INSERT INTO `support_categories` ( `id`, `name`, `active`, `modified`, `created`) VALUES (3,'Reclamo',1,NOW(),NOW());
/*!40000 ALTER TABLE `support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `support_priorities`
--

LOCK TABLES `support_priorities` WRITE;
/*!40000 ALTER TABLE `support_priorities` DISABLE KEYS */;
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (1,'Alta',1,1,NOW(),NOW());
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (2,'Normal',2,1,NOW(),NOW());
INSERT INTO `support_priorities` ( `id`, `name`, `order`, `active`, `modified`, `created`) VALUES (3,'Baja',3,1,NOW(),NOW());
/*!40000 ALTER TABLE `support_priorities` ENABLE KEYS */;
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

-- Dump completed on 2021-03-07 22:25:31
