<?php
/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.Config
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

CakePlugin::load('DebugKit');
//CakePlugin::load('ClearCache');
//CakePlugin::load('Migrations');
//CakePlugin::load('PrintReceipt',array('bootstrap'=>true));
//CakePlugin::load('Reports',array('bootstrap'=>true));
//CakePlugin::load('Drafts',array('bootstrap'=>true));
//CakePlugin::load('Attachments',array('bootstrap'=>true));


/** Theme Settings
 * 
 */
Configure::write('Theme.name', 'phkondo');
Configure::write('Theme.list', array(
    'Phkondo' => 'pHKondo',
        //'GreenAdm'=>'GreenAdm',
        //'SBAdmin'=>'SBAdmin',
));
Configure::write('Theme.owner_name', 'pHKondo');
Configure::write('Theme.owner_name_abbrv', 'PHK');
Configure::write('Theme.owner_description', 'Condominium Management');
Configure::write('Theme.owner_title', 'Administração ao cuidado de XXXXXX');
Configure::write('Theme.owner_address', 'Avenida XX de XXXXX NXX Loja A XXXX-XXX XXXXX , Telef: XXXXXXXXX / XXXXXXXXX');
Configure::write('Theme.base_color', '#428bca');

/**
 * Default app settings
 */
/**
 * Languages available
 */
Configure::write('Config.language', 'ita');
Configure::write('Language.list', array(
    'eng' => 'English',
    'por' => 'Português',
		'ita' => 'Italiano',
));

Configure::write('Config.timezone', 'Europe/Rome'); // Europe/Lisbon
Configure::write('databaseDateFormat', 'Y-m-d'); // database dateformat
Configure::write('dateFormat', 'd-m-Y H:i:s'); // phkondo dateformat with time
Configure::write('dateFormatSimple', 'd-m-Y'); // phkondo dateformat
Configure::write('calendarDateFormat', 'dd-mm-yyyy'); // input date fields date format
Configure::write('currencySign', '&euro;'); // more at http://www.w3schools.com/html/html_entities.asp
Configure::write('Application.mode', 'app'); // app, demo -> use demo for demo mode;

/**
 * The settings for maintenance component 
 */
Configure::write('MaintenanceMode.start', '01-01-2000 00:00:00');
Configure::write('MaintenanceMode.duration', '48'); // Duration in hours
Configure::write('MaintenanceMode.site_offline_url', '/pages/offline');

/**
 * The settings below can be used to open access to pHKondo.
 * - set to true / false
 * - true will open pHKondo to all access. 
 */
Configure::write('Access.open', false); // For SECURITY keep this FALSE , use only on emergency.

/**
 * User role settings , do not change unless you know what you are doing 
 */
Configure::write('User.role', array(
    'admin' => __('App Administrator'),
    'store_admin' => __n('Manager', 'Managers', 1),
    'colaborator' => __('Employee')
        )
);

