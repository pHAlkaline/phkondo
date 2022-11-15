ALTER TABLE `users` ADD `email` varchar(50) NULL;
ALTER TABLE `users` ADD UNIQUE(`email`);