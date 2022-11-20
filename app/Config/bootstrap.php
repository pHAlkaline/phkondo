<?php

/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); // Loads a single plugin named DebugKit
 */
//CakePlugin::load('DebugKit');
/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */


/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter . By Default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'File',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'File',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));
App::uses('AppExceptionHandler', 'Lib');


/*
* pHkondo Plugins
*/
CakePlugin::load('DebugKit');
CakePlugin::load('ClearCache');
CakePlugin::load('Feedback');
CakePlugin::load('Migrations');
CakePlugin::load('CakePdf', array('bootstrap' => true, 'routes' => true));
try {
    CakePlugin::load('Drafts', array('bootstrap' => true));
    CakePlugin::load('PrintReceipt', array('bootstrap' => true));
    CakePlugin::load('Reports', array('bootstrap' => true));
    CakePlugin::load('Attachments', array('bootstrap' => true));
    Configure::write('Application.isFullPack', true);
} catch (\Exception $e) {
    Configure::write('Application.isFullPack', false);
}

/*
 * CakePdf Plugin
 * Requires wkhtmltopdf engine at your system
 * https://wkhtmltopdf.org/
 */

Configure::write('CakePdf', array(
    // Requires wkhtmltopdf engine
    // https://wkhtmltopdf.org/
    'binary' => 'C:\xampp7427\wkhtmltopdf\bin\wkhtmltopdf.exe',
    // windows: C:\xampp7427\wkhtmltopdf\bin\wkhtmltopdf.exe
    // linux: /usr/local/bin/wkhtmltopdf
    'engine' => 'CakePdf.WkHtmlToPdf',
    'orientation' => 'portrait',
    'download' => false,
    'options' => [
        'disable-javascript' => true,
        'print-media-type' => true,
        'enable-local-file-access' => true
    ],
    'phkondo' => [
        'active' => false, // Requires CakePdf Plugin
        'cssPath' => APP . 'View' . DS . 'Themed' . DS . 'Phkondo' . DS . WEBROOT_DIR . DS . 'css' . DS,
        'imgPath' => APP . 'View' . DS . 'Themed' . DS . 'Phkondo' . DS . WEBROOT_DIR . DS . 'img' . DS,
    ]
));

/*
 * Attachment Plugin
 */
Configure::write('Attachment.attachment', array(
    'path' => '{ROOT}files{DS}{model}{DS}{field}{DS}',
    'pathMethod' => 'foreignKey',
    'nameCallback' => 'fileRename',
    'thumbnails' => false,
    'thumbnailMethod' => 'php',
    'thumbnailSizes' => array(
        'xvga' => '1024x768',
        'vga' => '640x480',
        'thumb' => '80x80',
    ),
    'maxSize' => '200000',
    'extensions' => array('pdf', 'txt', 'png', 'gif', 'jpg')
));

if (!file_exists(APP . 'Config' . DS . 'bootstrap_app.ini')) {
    copy(APP . 'Config' . DS . 'bootstrap_app.ini.default', APP . 'Config' . DS . 'bootstrap_app.ini');
}

App::uses('IniReader', 'Configure');
Configure::config('BootstrapApp', new IniReader());
Configure::load('bootstrap_app', 'BootstrapApp');
$allows_keys = [
    'installed_key',
    'Config.server_timezone',
    'Config.timezone',
    'Application.stage',
    'Application.mode',
    'Application.databaseDateFormat',
    'Application.dateFormat',
    'Application.dateFormatSimple',
    'Application.calendarDateFormat',
    'Application.currencySign',
    'Application.languageDefault',
    'Application.theme',
    'Attachment.attachment.maxSize',
    'Attachment.attachment.extensions',
    'CakePdf.phkondo.active',
    'CakePdf.binary',
    'MaintenanceManager.start',
    'MaintenanceManager.duration',
    'MaintenanceManager.site_offline_url',
    'MaintenanceManager.offline_destroy_session',
    'SubscriptionManager.start',
    'SubscriptionManager.duration',
    'SubscriptionManager.site_offline_url',
    'SubscriptionManager.offline_destroy_session'
];
foreach ($allows_keys as $value) {
     Configure::write($value, Configure::read('BootstrapApp.' . $value));
}


if (!file_exists(APP . 'Config' . DS . 'database.php')) {
    copy(APP . 'Config' . DS . 'database.php.default', APP . 'Config' . DS . 'database.php');
}
if (!file_exists(APP . 'Config' . DS . 'email.php')) {
    copy(APP . 'Config' . DS . 'email.php.default', APP . 'Config' . DS . 'email.php');
}
if (!file_exists(APP . 'Config' . DS . 'email_notifications.php')) {
    copy(APP . 'Config' . DS . 'email_notifications.php.default', APP . 'Config' . DS . 'email_notifications.php');
    Configure::load('email_notifications');
    $emailNotifications = Configure::read('EmailNotifications.default');
    Configure::write('EmailNotifications', $emailNotifications);
    Configure::write('EmailNotifications.active', false);
    Configure::dump('email_notifications.php', 'default', array('EmailNotifications'));
}
Configure::load('email_notifications');

if (!file_exists(APP . 'Config' . DS . 'organization.php')) {
    copy(APP . 'Config' . DS . 'organization.php.default', APP . 'Config' . DS . 'organization.php');
}