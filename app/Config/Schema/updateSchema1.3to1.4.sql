/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  paulo
 * Created: 23/mar/2016
 */
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
SET foreign_key_checks = 0;

ALTER TABLE `support` 
RENAME TO  `supports`;

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `vat_number` VARCHAR(9) NULL DEFAULT NULL,
  `representative` VARCHAR(50) NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `contacts` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(50) NULL DEFAULT NULL,
  `bank` VARCHAR(50) NULL DEFAULT NULL,
  `nib` VARCHAR(24) NULL DEFAULT NULL,
  `comments` TEXT NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

INSERT INTO `suppliers` (id,name,vat_number,representative,address,contacts,email,bank,nib,comments,modified,created)
  SELECT id,name,vat_number,representative,address,contacts,email,bank,nib,comments,modified,created
  FROM `entities` WHERE entity_type_id = 2;

ALTER TABLE `maintenances` 
ADD INDEX `supplier_id` (`supplier_id` ASC),
DROP INDEX `SUPPLIER`;
ALTER TABLE `maintenances` 
DROP FOREIGN KEY `maintenances_ibfk_2`;
ALTER TABLE `maintenances` ADD CONSTRAINT `maintenances_ibfk_2`
  FOREIGN KEY (`supplier_id`)
  REFERENCES `suppliers` (`id`)
  ON UPDATE CASCADE;

ALTER TABLE `invoice_conferences` 
ADD INDEX `status_id` (`invoice_conference_status_id` ASC),
ADD INDEX `supplier_id` (`supplier_id` ASC),
DROP INDEX `entity_id` ,
DROP INDEX `invoice_conference_status_id`; 
ALTER TABLE `invoice_conferences` 
DROP FOREIGN KEY `invoice_conferences_ibfk_4`;
ALTER TABLE `invoice_conferences` ADD CONSTRAINT `invoice_conferences_ibfk_4`
  FOREIGN KEY (`supplier_id`)
  REFERENCES `suppliers` (`id`)
  ON UPDATE CASCADE;


DELETE FROM `entities` WHERE entity_type_id = 2;

ALTER TABLE `entities` 
DROP FOREIGN KEY `entities_ibfk_1`;
ALTER TABLE `entities` 
DROP COLUMN `entity_type_id`,
DROP INDEX `ENTITYTYPE`; 

ALTER TABLE `administrators` 
DROP FOREIGN KEY `administrators_ibfk_3`;

ALTER TABLE `accounts_fiscal_years` 
DROP FOREIGN KEY `accounts_fiscal_years_ibfk_2`;

ALTER TABLE `accounts_fiscal_years` ADD CONSTRAINT `accounts_fiscal_years_ibfk_2`
  FOREIGN KEY (`fiscal_year_id`)
  REFERENCES `fiscal_years` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `administrators` 
DROP FOREIGN KEY `administrators_ibfk_2`;

ALTER TABLE `administrators` ADD CONSTRAINT `administrators_ibfk_2`
  FOREIGN KEY (`entity_id`)
  REFERENCES `entities` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `administrators_ibfk_3`
  FOREIGN KEY (`fiscal_year_id`)
  REFERENCES `fiscal_years` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `budgets` 
DROP FOREIGN KEY `budgets_ibfk_2`;

ALTER TABLE `budgets` ADD CONSTRAINT `budgets_ibfk_2`
  FOREIGN KEY (`fiscal_year_id`)
  REFERENCES `fiscal_years` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `supports` 
DROP FOREIGN KEY `fk_support_4`,
DROP FOREIGN KEY `fk_support_5`,
DROP FOREIGN KEY `fk_support_6`;

ALTER TABLE `supports` ADD CONSTRAINT `fk_support_4`
  FOREIGN KEY (`condo_id`)
  REFERENCES `condos` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_support_5`
  FOREIGN KEY (`fraction_id`)
  REFERENCES `fractions` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `fk_support_6`
  FOREIGN KEY (`client_id`)
  REFERENCES `entities` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

SET foreign_key_checks = 1;

