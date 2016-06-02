<?php

namespace adapt\locales{
    
    /* Prevent Direct Access */
    defined('ADAPT_STARTED') or die;
    
    class bundle_locales extends \adapt\bundle{
        
        public function __construct($data){
            parent::__construct('locales', $data);
        }
        
        public function boot(){
            if (parent::boot()){
                    $adapt = $this;
                    
                    $adapt->sanitize->add_format(
                        'locales_date',
                        function($value){
                            /*
                             * INPUT: Y-m-d
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_date_format'))){
                                return $adapt->sanitize->format($adapt->setting('locales.default_date_format'), $value);
                            }
                            
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_date_format') != null){
                                return adapt.sanitize.format(adapt.setting('locales.default_date_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    $adapt->sanitize->add_format(
                        'locales_time',
                        function($value){
                            /*
                             * INPUT: H:i:s
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_time_format'))){
                                return $adapt->sanitize->format($adapt->setting('locales.default_time_format'), $value);
                            }
                            
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_time_format') != null){
                                return adapt.sanitize.format(adapt.setting('locales.default_time_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    $adapt->sanitize->add_format(
                        'locales_datetime',
                        function($value){
                            /*
                             * INPUT: Y-m-d H:i:s
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_datetime_format'))){
                                return $adapt->sanitize->format($adapt->setting('locales.default_datetime_format'), $value);
                            }
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_datetime_format') != null){
                                return adapt.sanitize.format(adapt.setting('locales.default_datetime_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    
                    
                    $adapt->sanitize->add_unformat(
                        'locales_date',
                        function($value){
                            /*
                             * INPUT: Y-m-d
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_date_format'))){
                                return $adapt->sanitize->unformat($adapt->setting('locales.default_date_format'), $value);
                            }
                            
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_date_format') != null){
                                return adapt.sanitize.unformat(adapt.setting('locales.default_date_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    $adapt->sanitize->add_unformat(
                        'locales_time',
                        function($value){
                            /*
                             * INPUT: H:i:s
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_time_format'))){
                                return $adapt->sanitize->unformat($adapt->setting('locales.default_time_format'), $value);
                            }
                            
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_time_format') != null){
                                return adapt.sanitize.unformat(adapt.setting('locales.default_time_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    $adapt->sanitize->add_unformat(
                        'locales_datetime',
                        function($value){
                            /*
                             * INPUT: Y-m-d H:i:s
                             */
                            $adapt = $GLOBALS['adapt'];
                            if (!is_null($adapt->setting('locales.default_datetime_format'))){
                                return $adapt->sanitize->unformat($adapt->setting('locales.default_datetime_format'), $value);
                            }
                            
                            return $value;
                        }, "function(value){
                            if (adapt.setting('locales.default_datetime_format') != null){
                                return adapt.sanitize.unformat(adapt.setting('locales.default_datetime_format'), value);
                            }
                            
                            return value;
                        }"
                    );
                    
                    
                    
                    $adapt->sanitize->add_unformat('phone', function($value){
                        return preg_replace("/[\d+]/", "", $value);
                    }, "function(value){
                        value = value.replace(/[^0-9]/g, '');
                        return value;
                    }");
                    
                    
                    /*
                     * Add an event listener and listen
                     * for the adapt ready event so that we
                     * can add settings to the page
                     */
                    $global_adapt = $GLOBALS['adapt'];
                    $global_adapt->on(
                        \adapt\base::EVENT_READY,
                        function($event){
                            $adapt = $GLOBALS['adapt'];
                            if ($adapt->dom && $adapt->dom instanceof \adapt\page){
                                
                                $datetime = $adapt->data_source->get_data_type($adapt->setting('locales.default_datetime_format'));
                                $date = $adapt->data_source->get_data_type($adapt->setting('locales.default_date_format'));
                                $time = $adapt->data_source->get_data_type($adapt->setting('locales.default_time_format'));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_date_format', 'content' => $date['name'])));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_time_format', 'content' => $time['name'])));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_datetime_format', 'content' => $datetime['name'])));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_date_pattern', 'content' => $date['datetime_format'])));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_time_pattern', 'content' => $time['datetime_format'])));
                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_datetime_pattern', 'content' => $datetime['datetime_format'])));
                            }
                        }
                    );
                
                
                return true;
            }
            
            return false;
        }
        
    }
    
    
}

?>