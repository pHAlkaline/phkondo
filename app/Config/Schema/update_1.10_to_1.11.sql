-- phkondo.payment_advices definition

-- phkondo_agenciafatima.payment_advices definition
SET FOREIGN_KEY_CHECKS=0;
CREATE TABLE `payment_advices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(25) DEFAULT NULL,
  `document_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `condo_id` int(11) NOT NULL,
  `fraction_id` int(11) DEFAULT NULL,
  `entity_id` int(11) NOT NULL,
  `observations` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONDO` (`condo_id`),
  KEY `CLIENT` (`entity_id`),
  KEY `PAYMENTTYPE` (`payment_type_id`),
  KEY `FRACTION` (`fraction_id`),
  KEY `RECEIPT` (`receipt_id`),
  CONSTRAINT `payment_advices_ibfk_1` FOREIGN KEY (`condo_id`) REFERENCES `condos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_advices_ibfk_2` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `payment_advices_ibfk_3` FOREIGN KEY (`payment_type_id`) REFERENCES `receipt_payment_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `payment_advices_ibfk_4` FOREIGN KEY (`fraction_id`) REFERENCES `fractions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `payment_advices_ibfk_5` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

ALTER TABLE `notes` ADD `payment_advice_id` int(11) NULL;
ALTER TABLE `notes` ADD CONSTRAINT `notes_ibfk_8` FOREIGN KEY (`payment_advice_id`) REFERENCES `payment_advices`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `notes` DROP FOREIGN KEY `notes_ibfk_7`; 
ALTER TABLE `notes` ADD CONSTRAINT `notes_ibfk_7` FOREIGN KEY (`receipt_id`) REFERENCES `receipts`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `drafts` CHANGE `content` `content` LONGTEXT NOT NULL;
ALTER TABLE `drafts` CHANGE `content_model` `content_model` LONGTEXT NOT NULL;

-- eng
UPDATE `receipt_statuses` SET `name` = 'Issued' WHERE `receipt_statuses`.`id` = 2;
-- ita
UPDATE `receipt_statuses` SET `name` = 'Emesso' WHERE `receipt_statuses`.`id` = 2;
-- spa
UPDATE `receipt_statuses` SET `name` = 'Emitido' WHERE `receipt_statuses`.`id` = 2;
-- por
UPDATE `receipt_statuses` SET `name` = 'Emitido' WHERE `receipt_statuses`.`id` = 2;
-- pt_br
UPDATE `receipt_statuses` SET `name` = 'Emitido' WHERE `receipt_statuses`.`id` = 2;

-- suggestion ( Danger be very careful )
-- set DEFAULT CHARSET=utf8mb4_general_ci to database , all tables and all fields 

SET FOREIGN_KEY_CHECKS=1;