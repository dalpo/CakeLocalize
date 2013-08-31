<?php

class FieldBehavior extends ModelBehavior {

  protected $_Model = null;

  protected $_defaultFieldOptions = array();

  protected $_options = array();

  public function setup(Model $Model, $fields = array()) {
    $this->_Model =& $Model;

    if(!is_array($fields)) {
      $fields = array($fields);
    }

    if($Model->useTable) {
      foreach ($fields as $field => $options) {
        if(is_array($options)) {
          $this->_options[$Model->alias][$field] = array_merge($this->_defaultFieldOptions, $options);
        } else {
          $field = $options;
          $this->_options[$Model->alias][$field] = $this->_defaultFieldOptions;
        }
        $this->initI18nField($field, $options);
      }
    }
  }

  public function currentLocale() {
    return substr(Configure::read('Config.language'), 0, 2);
  }

  public function localizedField($field) {
    return $this->_Model->alias . "." . $field . "_" . $this->currentLocale();
  }

  public function initI18nField($field = null) {
    return $this->_Model->virtualFields[$field] = $this->localizedField($field);
  }

}
