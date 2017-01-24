<?php

namespace adapt\locales;

class model_country extends \adapt\model {
    
    protected $_date_data_type;
    protected $_time_data_type;
    protected $_datetime_data_type;
    
    public function __construct($id = null, $data_source = null){
        parent::__construct("country", $id, $data_source);
    }
    
    public function pget_date_data_type(){
        if (!$this->_date_data_type){
            $this->_date_data_type = new model_data_type();
        }
        
        if (!$this->_date_data_type->is_loaded || $this->_date_data_type->data_type_id != $this->date_data_type_id){
            $this->_date_data_type->load($this->date_data_type_id);
        }
        
        return $this->_date_data_type;
    }
    
    public function pget_time_data_type(){
        if (!$this->_time_data_type){
            $this->_time_data_type = new model_data_type();
        }
        
        if (!$this->_time_data_type->is_loaded || $this->_time_data_type->data_type_id != $this->time_data_type_id){
            $this->_time_data_type->load($this->time_data_type_id);
        }
        
        return $this->_time_data_type;
    }
    
    public function pget_datetime_data_type(){
        if (!$this->_datetime_data_type){
            $this->_datetime_data_type = new model_data_type();
        }
        
        if (!$this->_datetime_data_type->is_loaded || $this->_datetime_data_type->data_type_id != $this->datetime_data_type_id){
            $this->_datetime_data_type->load($this->datetime_data_type_id);
        }
        
        return $this->_datetime_data_type;
    }
}
