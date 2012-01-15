<?php
class AppModel extends Model {
 	
	 var $actsAs = array('Containable', 'ExtendAssociations');
 	 
	  // in test mode set this to "test", in production mode comment it out
	  var $useDbConfig = 'test';
 	
    function validateUnique($value, $params = array()) {
        if (!empty($this->id)) {
            $conditions = array($this->primaryKey.' !=' => $this->id, $params['field'] => $value);
        } else {
            $conditions = array($params['field'] => $value);
        }
        return !$this->field($this->primaryKey, $conditions);
    } 
}
?>