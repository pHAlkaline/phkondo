<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * Licensed under The MIT License
 *
 * Copyright (c) La Pâtisserie, Inc. (http://patisserie.keensoftware.com/)
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('FormHelper', 'View/Helper');
class BootstrapFormHelper extends FormHelper
{

    /**
     * Default input values with bootstrap classes
     * Changed order of error and after to be able to display validation error messages inline
     */
    protected $_inputDefaults = array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => 'form-group',
        'label' => array('class' => 'control-label col-lg-2'),
        'between' => '<div class="col-lg-10">',
        'after' => '</div>',
        'class' => 'form-control',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline text-danger'))
    );

    /**
     * Added an array_merge_recursive for labels to combine $_inputDefaults with specific view markup for labels like custom text.
     * Also removed null array for options existing in $_inputDefaults.
     */
    protected function _parseOptions($options)
    {
        if (!empty($options['label'])) {
            //manage case 'label' => 'your label' as well as 'label' => array('text' => 'your label') before array_merge()
            if (!is_array($options['label'])) {
                $options['label'] = array('text' => $options['label']);
            }
            $options['label'] = array_merge_recursive($options['label'], $this->_inputDefaults['label']);
        }

        $options = array_merge(
            array('before' => null),
            $this->_inputDefaults,
            $options
        );
        return parent::_parseOptions($options);
    }

    /**
     * adds the default class 'form-horizontal to the <form>
     *
     */
    public function create($model = null, $options = array())
    {
        if (isset($this->request['language']) && !empty($options['url'])) {
            if (is_array($options['url'])) {
                $options['url']['language'] = Configure::read('Config.langCode');
            } else {
                $options['url'] = '/' . $this->request['language'] . $options['url'];
            }
        }

        $class = array(
            'class' => 'form-horizontal',
        );
        $options = array_merge($class, $options);
        return parent::create($model, $options);
    }

    /**
     * modified the first condition with a more general empty() otherwise if $default is an empty array
     * !is_null() returns true and $this->_inputDefaults is erased
     */
    public function inputDefaults($defaults = null, $merge = false)
    {
        if (!empty($defaults)) {
            if ($merge) {
                $this->_inputDefaults = array_merge($this->_inputDefaults, (array)$defaults);
            } else {
                $this->_inputDefaults = (array)$defaults;
            }
        }
        return $this->_inputDefaults;
    }

    public function input($fieldName, $options = array()) {
        $this->setEntity($fieldName);
        $options = $this->_parseOptions($options);

        $divOptions = $this->_divOptions($options);
        unset($options['div']);

        if ($options['type'] === 'radio' && isset($options['options'])) {
            $radioOptions = (array)$options['options'];
            unset($options['options']);
        }

        $label = $this->_getLabel($fieldName, $options);
        if ($options['type'] !== 'radio') {
            unset($options['label']);
        }

        $error = $this->_extractOption('error', $options, null);
        unset($options['error']);

        $errorMessage = $this->_extractOption('errorMessage', $options, true);
        unset($options['errorMessage']);

        $selected = $this->_extractOption('selected', $options, null);
        unset($options['selected']);

        if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
            $dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
            $timeFormat = $this->_extractOption('timeFormat', $options, 12);
            unset($options['dateFormat'], $options['timeFormat']);
        }

        $type = $options['type'];
        $out = array('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after']);
        $format = $this->_getFormat($options);

        unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);

        $out['error'] = null;
        if ($type !== 'hidden' && $error !== false) {
            $errMsg = $this->error($fieldName, $error);
            if ($errMsg) {
                $divOptions = $this->addClass($divOptions, 'has-error');
                if ($errorMessage) {
                    $out['error'] = $errMsg;
                }
            }
        }

        if ($type === 'radio' && isset($out['between'])) {
            $options['between'] = $out['between'];
            $out['between'] = null;
        }
        $out['input'] = $this->_getInput(compact('type', 'fieldName', 'options', 'radioOptions', 'selected', 'dateFormat', 'timeFormat'));

        $output = '';
        foreach ($format as $element) {
            $output .= $out[$element];
        }

        if (!empty($divOptions['tag'])) {
            $tag = $divOptions['tag'];
            unset($divOptions['tag']);
            $output = $this->Html->tag($tag, $output, $divOptions);
        }
        return $output;
    }

}