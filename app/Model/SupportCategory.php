<?php
App::uses('AppModel', 'Model');
/**
 * SupportCategory Model
 *
 */
class SupportCategory extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
        
        /**
     * afterFind callback
     * 
     * @param array $results
     * @param boolean $primary
     * @access public
     * @return array
     */
    public function afterFind($results, $primary = false) {
        if ($this->noAfterFind) {
            $this->noAfterFind=false;
            return $results;
        }
       if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['active'])) {
                    $results[$key][$this->alias]['active_string'] = ($results[$key][$this->alias]['active']) ? __('Active') : null;
                }
                if (isset($results[$key][$this->alias]['id'])) {
                    $results[$key][$this->alias]['deletable'] = $this->deletable($results[$key][$this->alias]['id']);
                }
            }
        }
        if (isset($results['active'])) {
            $results['active_string'] = ($results['active']) ? __('Active') : null;
        }
       
        if (isset($results['id'])) {
            $results['deletable'] = $this->deletable($results['id']);
        }
        return $results;
    }
    
    
    function deletable($id = null) {
        $this->noAfterFind = true;

        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        return $this->beforeDelete(false);
    }
    
    function beforeDelete($cascade = true) {
       return parent::beforeDelete();
    }
}
