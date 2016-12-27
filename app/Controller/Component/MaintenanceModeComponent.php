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
 * @package       app.Controller.Component
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */
App::uses('Component', 'Controller');

/**
 * pHAlkaline Component
 *
 * PHP version 5
 *
 * @category Component
 * @package  pHAlkaline
 * @version  V1.1
 * @author   Paulo Homem <contact@phalkaline.eu>
 * @license  http://opensource.org/licenses/GPL-2.0 The GNU GPL-2.0
 * @link     http://www.phalkaline.eu
 */
class MaintenanceModeComponent extends Component {

    /**
     * Other components utilized by MaintenanceModeComponent
     *
     * @var array
     * @access public
     */
    public $components = array('Session','Flash');

    /**
     * The name of the element used for FlashComponent::flash
     *
     * @var string
     * @access public
     */
    public $flashElement = 'flash/warning';

    /**
     * Message to display when app is on maintenance mode.  For security purposes.
     *
     * @var string
     * @access public
     */
    public $maintenanceMessage = null;

    /**
     * Parameter data from Controller::$params
     *
     * @var array
     * @access public
     */
    public $params = array();

    /**
     * startup
     * called after Controller::beforeFilter()
     * 
     * @param object $controller instance of controller
     * @return void
     * @access public
     */
    public function startup(Controller $controller) {
        
        // Maintenance mode OFF but on offline page -> redirect to root url    
        if (!$this->isOn() && strpos($controller->here, Configure::read('MaintenanceMode.site_offline_url'))!==false) {
            $controller->redirect(Router::url('/',true));
            return;
        }
        
        // Maintenance mode ON user logoout allowed
        if ($this->isOn() && strpos($controller->here, 'users/logout') !== false) {
            return;
        }

        // Maintenance mode ON but not in offline page requested - > redirect to offline page
        if ($this->isOn() && strpos($controller->here, Configure::read('MaintenanceMode.site_offline_url')) === false) {
            
            // All users auto logged off if setting is true
            if(Configure::read('Maintenance.offline_destroy_session')){
                $this->Session->destroy();
            }
            
            $controller->redirect(Router::url(Configure::read('MaintenanceMode.site_offline_url'),true));
            return;
        }
        
        
        // Maintenance mode scheduled show message!!    
        if ($this->hasSchedule()) {
            $this->Flash->warning(__('This application will be on maintenance mode at  %s ', Configure::read('MaintenanceMode.start')));
        }
    }

    /**
     * isOn
     * is maintenance on
     * 
     * @access public
     * @return boolean
     * 
     */
    public static function isOn() {
        if ((Configure::read('MaintenanceMode.start') != '') && (Configure::read('MaintenanceMode.duration') != '')) {

            $tzNow = new DateTime();
            $tzNow->setTimezone(new DateTimeZone(Configure::read('Config.timezone')));
            $date = $tzNow->format('d-m-Y H:i:s');
            $date1 = strtotime($date);
            $date2 = strtotime(Configure::read('MaintenanceMode.start'));
            $interval = ($date1 - $date2) / (60 * 60);
            if ($interval > 0 && $interval < Configure::read('MaintenanceMode.duration')){
                return true;
            }
        }
        return false;
    }

    /**
     * hasSchedule
     * has maintenance schedule
     * 
     * @return boolean
     * @access public
     */
    public function hasSchedule() {
        if ((Configure::read('MaintenanceMode.start') != '') && (Configure::read('MaintenanceMode.duration') != '')) {
            $date1 = time();
            $date2 = strtotime(Configure::read('MaintenanceMode.start'));
            $interval = ($date1 - $date2) / (60 * 60);
            if ($interval < 0)
                return true;
        }
        return false;
    }

    /**
     * start
     * maintenance start date
     * 
     * @access public
     * @return string
     */
    public function start() {
        return Configure::read('MaintenanceMode.start');
    }

    /**
     * end
     * maintenance end date
     * 
     * @return string
     * @access public
     */
    public function end() {
        return Configure::read('MaintenanceMode.duration');
    }

}

?>