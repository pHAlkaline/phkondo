<?php
/**
 *
 * pHKondo : pHKondo software for condominium property managers (https://www.phalkaline.net)
 * Copyright (c) pHAlkaline . (https://www.phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://www.phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Controller
 * @since         pHKondo v 1.7.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

App::uses('Component', 'Controller');


class SubscriptionManagerComponent extends Component {

    /**
     * Other components utilized by SubscriptionManagerComponent
     *
     * @var array
     * @access public
     */
    public $components = array('Session','Flash','Cookie');

    /**
     * The name of the element used for FlashComponent::flash
     *
     * @var string
     * @access public
     */
    public $flashElement = 'flash/warning';

    /**
     * Message to display when app is on subscription mode.  For security purposes.
     *
     * @var string
     * @access public
     */
    public $subscriptionMessage = null;

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
        $isON=$this->isOn();
        // Subscription is ON by at offline page -> redirect to root url
        if ($isON && $controller->here==Configure::read('SubscriptionManager.site_offline_url')) {
            $controller->redirect(Router::url('/',true));
            return;
        }
        
        // Subscription is OFF user logoout allowed
        if (!$isON && $controller->here=='users/logout') {
            return;
        }

        // Subscription is OFF but not in offline page  - > redirect to offline page
        if (!$isON && $controller->here!==Configure::read('SubscriptionManager.site_offline_url')) {
            
            // All users auto logged off if setting is true
            if(Configure::read('SubscriptionManager.offline_destroy_session')){
                $this->Session->destroy();
            }
            
            $controller->redirect(Router::url(Configure::read('SubscriptionManager.site_offline_url'),true));
            return;
        }
        
        
        // SubscriptionManager mode scheduled show message!!
        if ($this->isExpiring() && !$this->Cookie->read('subscription_warning')) {
            $tzNow = new DateTime();
            $tzNow->setTimezone(new DateTimeZone(Configure::read('Config.timezone')));
            $date = $tzNow->format('d-m-Y H:i:s');
            $now = strtotime($date);
            $subscription = strtotime(Configure::read('SubscriptionManager.start').' +'.Configure::read('SubscriptionManager.duration').' days');
            $interval = (int)(($subscription-$now) / (60 * 60 * 24));
            $this->Flash->warning(__('This subscription will expire in %s days', $interval));
            $this->Cookie->write('subscription_warning', 'isExpiring', false, '1 hour');
        }
    }

    /**
     * isOn
     * is subscription on / off
     * 
     * @access public
     * @return boolean
     * 
     */
    public static function isOn() {
        if ((Configure::read('SubscriptionManager.start') != '') && (Configure::read('SubscriptionManager.duration') != '')) {

            $tzNow = new DateTime();
            $tzNow->setTimezone(new DateTimeZone(Configure::read('Config.timezone')));
            $date = $tzNow->format('d-m-Y H:i:s');
            $now = strtotime($date);
            $subscription = strtotime(Configure::read('SubscriptionManager.start'));
            $interval = (int)(($now - $subscription) / (60 * 60 * 24))+1;
            if ($interval < 0 || ($interval >= 0 && $interval <= Configure::read('SubscriptionManager.duration'))){
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * isExpiring
     * is subscription expiring
     * 
     * @return boolean
     * @access public
     */
    public function isExpiring() {
        if ($this->isOn() && Configure::read('SubscriptionManager.start') != '' && Configure::read('SubscriptionManager.duration') != '') {
            $tzNow = new DateTime();
            $tzNow->setTimezone(new DateTimeZone(Configure::read('Config.timezone')));
            $date = $tzNow->format('d-m-Y H:i:s');
            $now = strtotime($date);
            $subscription = strtotime(Configure::read('SubscriptionManager.start'));
            $interval = (int)(($now - $subscription) / (60 * 60 * 24))+1;
            if ($interval > 0 && ($interval+15) >= Configure::read('SubscriptionManager.duration')){
                return true;
            }
        }
        return false;
    }

    /**
     * start
     * subscription start date
     * 
     * @access public
     * @return string
     */
    public function start() {
        return Configure::read('SubscriptionManager.start');
    }

    /**
     * end
     * subscription end date
     * 
     * @return string
     * @access public
     */
    public function end() {
        return Configure::read('SubscriptionManager.duration');
    }

}

?>