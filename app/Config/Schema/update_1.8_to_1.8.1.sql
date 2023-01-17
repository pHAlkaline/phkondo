ALTER TABLE `receipts` CHANGE `client_id` `entity_id` INT(11) NOT NULL;
ALTER TABLE `supports` CHANGE `client_id` `entity_id` INT(11) NOT NULL;
UPDATE movement_operations SET `id` = `id` + 1 WHERE `id` > 2 ORDER BY `id` DESC;
INSERT INTO `movement_operations` (`id`, `name`, `active`, `modified`, `created`) VALUES ('3', 'Movimento Interno', '1', NOW(), NOW());
ALTER TABLE `movements` ADD `document_id` INT NULL AFTER `document`;
ALTER TABLE `movements` ADD CONSTRAINT `movements_ibfk_7` FOREIGN KEY (`document_id`) REFERENCES `receipts`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;