<?php
App::uses('Model', 'Model');
class AppModel extends Model{
  var $name= 'AppModel';
  
  function beforeSave($options = Array()){
    App::import('Sanitize');
    $this->Sanitize = new Sanitize();
    $strippedTags = array();
		foreach($this->data as $key=>$value)
		{
    			foreach($value as $k=>$v)
    			{
				if(is_array($v) && !empty($v))
				{
					$strippedTags[$key][$k] = $v;
				}else{
						$newValue = $this->Sanitize->stripScripts($v);
						$strippedTags[$key][$k]=trim($newValue);
				}
    			}
		}
		$this->data = $strippedTags;
		return $this->data;
  }//ef
}//ec
?>