
**pHKondo** , Condominium management software. 
It provides effective mechanism to condominium management, released under [GNU GLP V2]

Official website**: [http://phkondo.net](http://phkondo.net)

##Manual install
Unzip pHKondo to your directory

## Git install 
( pHKondo and submodule cakephp )

git clone --recursive https://github.com/pHAlkaline/phkondo.git

or

git clone https://github.com/pHAlkaline/phkondo.git

git submodule init

git submodule update

## Setup
Pre-requisites

To install pHKondo, a web server is required, Apache with “`mod_rewrite` or similar” and must have PHP 5.3 (or better) and MySQL 5.1 (or better) installed.
If you are unsure whether your server meets these requirements, please check with your host or webmaster before proceeding with the installation.
You will need one MySQL database with (`utf8_general_ci` collation) , a valid user, password and hostname handy during installation.
MySQL user must have FULL privileges on the database. If you are unsure whether you have these details or if the user has sufficient permissions, please consult your host or database admin before proceeding.

Install
Upload the content to your server, Extract the archive.
Create a new MySQL database (`utf8_general_ci` collation), and run these two SQL dump files in given order:
app/Config/Schema/phkondo.sql
app/Config/Schema/phkondodata.sql

Edit `app/Config/database.php.install`, change the details for your database connection and save as `database.php`

Change permitions to app/tmp folder and subfolders including files to 777 ( Enable Read , Write and Execute )

For database data translation edit app/Config/Schema/phkondodata.sql before install

start session default username is admin and default password is admin

## Other Settings
Database

edit app/Config/database.php file for database settings.

Email

edit app/Config/email.php file for email settings.

## More app settings

Edit app/Config/bootstrap_phapp.php file for some settings like language, date format, site maintenance and other.

Language

Your default language is defined at
Configure::write('Config.language', 'eng');
Use 'eng' for English , 'por' for Portuguese, 'deu' for german , 'spa' for german ….

Time Zone

Your selected timezone is defined at
Configure::write('Config.timezone', 'Europe/Lisbon'); settings for Europe/Lisbon.
This setting is used on dates and time fields and database records.
If your server is set with a different time zone, you can use this setting to inform pHKondo to use your local timezone.
list of time zones supported http://php.net/manual/en/timezones.php

Date Format

pHKondo has many fields that are “Dates” , configure 'dateFormat' and 'dateFormatSimple' to change the data format for pHKondo. 
Configure::write('dateFormat', 'd-m-Y H:i:s'); 
Configure::write('dateFormatSimple', 'd-m-Y'); 
more about date format http://php.net/manual/en/function.date.php

Maintenance

pHKondo has a maintenance mode, just set. 
Configure::write('maintenance.start', '10-04-2015 19:20'); change '10-04-2015 19:20' to the start date 
Configure::write('maintenance.duration', '2'); and '2' with duration in hours 
Configure::write('Maintenance.offline_destroy_session', true); true or false , with true - Offline will destroy user sessions 
When your server reaches 10-04-2015 19:20 the pHKondo app will go to Maintenance mode for 2 hours and automatically logout all users. 
This is useful when you are updating your pHKondo for some reason. 

## Translate 

The i18n features of pHKondo use po files as their translation source.
This makes them easily to integrate with tools like poedit and other common translation tools.
One of the best ways for applications to reach a larger audience is to cater for multiple languages.
This can often prove to be a daunting task, but the internationalization and localization features in pHKondo make it much easier.
First, it’s important to understand some terminology.
Internationalization refers to the ability of an application to be localized.
The term localization refers to the adaptation of an application to meet specific language (or culture) requirements (i.e., a “locale”).
Internationalization and localization are often abbreviated as i18n and l10n respectively; 18 and 10 are the number of characters between the first and last character.
pHKondo will look for your po files in the following locations:
/app/Locale/<locale>/LC_MESSAGES/<domain>.po 
/app/Plugin/<pluginame>/Locale/<locale>/LC_MESSAGES/<domain>.po 
The default domain is ‘default’, therefore your locale folder would look something like this: 
/app/Locale/eng/LC_MESSAGES/default.po (English)
/app/Locale/fra/LC_MESSAGES/default.po (French)
/app/Locale/por/LC_MESSAGES/default.po (Portuguese)
So if you need to translate pHKondo just create these po files files for your language.
To create or edit your po files it’s recommended that you do not use your favorite editor.
To create a po file for the first time for your language you should copy the entire folder to the correct location and change the the contents on default.po and cake.po files.
Example → create Spanish this way: 
copy /app/Locale/eng/ contents to /app/Locale/spa/ 
copy /app/Plugin/<pluginame>/Locale/eng/ contents to /app/Plugin/<pluginame>/Locale/spa/ 
Edit LC_MESSAGES/*.po files, 
translating only msgstr fields to your language
msgid “July” , msgid stays the same 
msgstr “Julio” , msgstr is traslation of msgid ( English ) to your language ( Spanish ) 
After translation please send us your translation so that we can include on next pHKondo versions.

Unless you’re familiar with po file format, it’s quite easy to create an invalid po file or to save it as the wrong charset (if you’re editing manually, use UTF-8 to avoid problems). 
There are free tools such as PoEdit which make editing and updating your po files an easy task; especially for updating an existing po files.
The three-character locale codes ( eng , por , spa ) conform to the ISO 639-2 standard.

For database translation edit app/Config/Schema/phkondodata.sql before install


## Troubleshooting And Debug Having trouble??

We can help install and configure pHKondo to your needs. Please contact about installation services.

Self-Help Troubleshooting
If you are looking for PHP Errors and Warnings, you can enable the “Debug” flags located in app/Config/core.php
Debug
edit `app/Config/core.php` at line - Configure::write('debug', 1)
Production Mode:
Configure::write('debug', 0) : No error messages, errors, or warnings shown. Flash messages redirect.
Development Mode:
Configure::write('debug', 1) : Errors and warnings shown, model caches refreshed, flash messages halted.
Configure::write('debug', 2) : As in 1, but also with full debug messages and SQL output.
Then errors should be displayed either in your web browser or in your server's error.log file. 
