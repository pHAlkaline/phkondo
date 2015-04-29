<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $theme = "phkondo";
    public $components = array('DebugKit.Toolbar', 'Session', 'Auth','MaintenanceMode');
    public $paginate = array(
        'limit' => 50,
    );

    public function beforeFilter() {
       $this->Auth->authenticate = array(  AuthComponent::ALL => array('userModel' => 'User', 'scope' => array("User.active" => 1)),'Form');
        $this->Auth->loginRedirect= array('controller' => 'condos', 'action' => 'index');
        $this->Auth->logoutRedirect = array('controller' => 'pages', 'action' => 'display', 'home');
        $this->Auth->authorize = array('Controller');
        $this->Auth->allow('display');
        if (Configure::read('Access.open') === true) {
            $this->Auth->allow();
        } 
        if ($this->Session->read('User.language')){
            Configure::write('Config.language', $this->Session->read('User.language'));
        }
    }

    public function isAuthorized($user) {
        //debug($this->request->controller);
        if (isset($user['role'])) {

            switch ($user['role']) {
                case 'admin':
                    return true;
                    break;
                case 'store_admin':
                    return true;
                    break;
                case 'colaborator':
                    return true;
                    break;
            }
        }

        // Default deny
        return false;
    }
    
    public function setFilter($fields){
        $this->set('keyword', __('Search'));
        
        if (isset($this->request->params['named']['keyword'])) {
            $keyword = $this->request->params['named']['keyword'];
        }
        if (isset($this->request->query['keyword'])) {
            $keyword = $this->request->query['keyword'];
        }

        if (isset($keyword) && ($keyword == '' || $keyword == __('Search'))) {
            unset($keyword);
        }

        if (isset($keyword)) {
            $arrayConditions=array();
            foreach ($fields as $field){
                $arrayConditions[$field.' LIKE']="%" . $keyword . "%";
            }
            $this->Paginator->settings =Set::merge($this->Paginator->settings, 
                    array('conditions' => array
                    ("OR" => $arrayConditions
            )));
            
            $this->set('keyword', $keyword);
        }
    }

}
