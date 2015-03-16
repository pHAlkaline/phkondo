<?php

App::uses('AppModel', 'Model');

/**
 * Entity Model
 *
 * @property EntityType $EntityType
 */
class Entity extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Order
     *
     * @var string
     */
    public $order = 'Entity.name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'entity_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'EntityType' => array(
            'className' => 'EntityType',
            'foreignKey' => 'entity_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => 'EntityType.name'
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
            $this->noAfterFind = false;
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
        if ($this->hasNotes($this->id)) {
            return false;
        }
        if ($this->hasReceipts($this->id)) {
            return false;
        }
        if ($this->hasFractions($this->id)) {
            return false;
        }
        if ($this->hasFractionManager($this->id)) {
            return false;
        }
        if ($this->hasInvoiceConference($this->id)) {
            return false;
        }
        if ($this->hasAdministrators($this->id)) {
            return false;
        }
        if ($this->hasMaintenance($this->id)) {
            return false;
        }

        return true;
    }

    public function hasNotes($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('Note')->find('count', array('conditions' => array('Note.entity_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasReceipts($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->alias = 'Entity';
        $result = ClassRegistry::init('Receipt')->find('count', array('conditions' => array('Receipt.client_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasFractions($id = null) {


        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->recursive = -1;
        $this->alias = 'Entity';

        $options['joins'] = array(
            array('table' => 'entities_fractions',
                'alias' => 'EntityFraction',
                'type' => 'INNER',
                'conditions' => array(
                    'Entity.id = EntityFraction.entity_id',
                )
        ));

        $options['conditions'] = array(
            'EntityFraction.entity_id' => $id);

        $result = $this->find('count', $options);
        return ($result > 0) ? true : false;
    }

    public function hasFractionManager($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        $this->Fraction = ClassRegistry::init('Fraction');
        $this->Fraction->recursive = -1;
        $result = $this->Fraction->find('count', array('conditions' => array('Fraction.manager_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasInvoiceConference($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('InvoiceConference')->find('count', array('conditions' => array('InvoiceConference.supplier_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasAdministrators($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('Administrator')->find('count', array('conditions' => array('Administrator.entity_id' => $id)));
        return ($result > 0) ? true : false;
    }

    public function hasMaintenance($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $result = ClassRegistry::init('Maintenance')->find('count', array('conditions' => array('Maintenance.supplier_id' => $id)));
        return ($result > 0) ? true : false;
    }

}
