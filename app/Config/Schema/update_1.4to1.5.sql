SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `entities_fractions` 
DROP FOREIGN KEY `entities_fractions_ibfk_1`;

ALTER TABLE `notes` 
DROP FOREIGN KEY `notes_ibfk_2`,
DROP FOREIGN KEY `notes_ibfk_4`,
DROP FOREIGN KEY `notes_ibfk_5`,
DROP FOREIGN KEY `notes_ibfk_7`;

ALTER TABLE `receipts` 
DROP FOREIGN KEY `fk_receipts_1`,
DROP FOREIGN KEY `receipts_ibfk_2`;

ALTER TABLE `users` 
ADD COLUMN `model` VARCHAR(45) NULL DEFAULT NULL AFTER `created`,
ADD COLUMN `foreign_key` INT(11) NULL DEFAULT NULL AFTER `model`;

ALTER TABLE `entities_fractions` 
ADD CONSTRAINT `entities_fractions_ibfk_1`
  FOREIGN KEY (`entity_id`)
  REFERENCES `entities` (`id`)
  ON UPDATE CASCADE;

ALTER TABLE `notes` 
ADD CONSTRAINT `notes_ibfk_2`
  FOREIGN KEY (`fraction_id`)
  REFERENCES `fractions` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `notes_ibfk_4`
  FOREIGN KEY (`fiscal_year_id`)
  REFERENCES `fiscal_years` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `notes_ibfk_5`
  FOREIGN KEY (`budget_id`)
  REFERENCES `budgets` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `notes_ibfk_7`
  FOREIGN KEY (`receipt_id`)
  REFERENCES `receipts` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `receipts` 
ADD CONSTRAINT `fk_receipts_1`
  FOREIGN KEY (`fraction_id`)
  REFERENCES `fractions` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `receipts_ibfk_2`
  FOREIGN KEY (`client_id`)
  REFERENCES `entities` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
