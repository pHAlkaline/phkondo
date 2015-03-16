<?php

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
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.phalkaline.eu
 */
class MaintenanceModeComponent extends Component {

    /**
     * Other components utilized by MaintenanceModeComponent
     *
     * @var array
     * @access public
     */
    public $components = array('Session');

    /**
     * The name of the element used for SessionComponent::setFlash
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
            $this->Session->setFlash(__('This application will be on maintenance mode at  %s ', Configure::read('MaintenanceMode.start')), $this->flashElement);
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