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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->format($adapt->country->date_data_type->name, $value);
                        }elseif ($value && !is_null($adapt->setting('locales.default_date_format'))){
                            return $adapt->sanitize->format($adapt->setting('locales.default_date_format'), $value);
                        }

                        return $value;
                    }, "function(value){
                        if (value && adapt.setting('locales.default_date_format') != null){
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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->format($adapt->country->time_data_type->name, $value);
                        }elseif ($value && !is_null($adapt->setting('locales.default_time_format'))){
                            return $adapt->sanitize->format($adapt->setting('locales.default_time_format'), $value);
                        }

                        return $value;
                    }, "function(value){
                        if (value && adapt.setting('locales.default_time_format') != null){
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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->format($adapt->country->datetime_data_type->name, $value);
                        }elseif ($value){
                            if (!is_null($adapt->setting('locales.default_datetime_format'))){
                                return $adapt->sanitize->format($adapt->setting('locales.default_datetime_format'), $value);
                            }
                        }      
                        return $value;
                    }, "function(value){
                        if (value && adapt.setting('locales.default_datetime_format') != null){
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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->unformat($adapt->country->date_data_type->name, $value);
                        }elseif (!is_null($adapt->setting('locales.default_date_format'))){
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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->unformat($adapt->country->time_data_type->name, $value);
                        }elseif (!is_null($adapt->setting('locales.default_time_format'))){
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
                        if ($adapt->country instanceof \adapt\model && $adapt->country->table_name == 'country'){
                            return $adapt->sanitize->unformat($adapt->country->datetime_data_type->name, $value);
                        }elseif (!is_null($adapt->setting('locales.default_datetime_format'))){
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
                
                /**
                 * Add country to base so that locales information is easily accessible
                 */
                \adapt\base::extend(
                    'pget_country',
                    function($_this){
                        $country = $_this->store('locales.country');
                        if (!$country instanceof \adapt\model && $country->table_name != 'country'){
                            $country = new model_country();
                        }
                        
                        if ($country->name != $_this->setting('locales.default_country')){
                            $country->load_by_name($_this->setting('locales.default_country'));
                        }
                        
                        $_this->store('locales.country', $country);
                        
                        return $country;
                    }
                );
                
                /**
                 * Add an event listener to the DOM and
                 * append locales information on render
                 */
                if ($this->dom instanceof \adapt\page && $this->dom->tag == 'html'){
                    $this->dom->listen(
                        \adapt\page::EVENT_RENDER, 
                        function($event){
                            if ($event['object']->country->is_loaded){
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_date_format', 'content' => $event['object']->country->date_data_type->name]));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_time_format', 'content' => $event['object']->country->time_data_type->name]));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_datetime_format', 'content' => $event['object']->country->datetime_data_type->name]));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_date_pattern', 'content' => $event['object']->country->date_data_type->datetime_format]));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_time_pattern', 'content' => $event['object']->country->time_data_type->datetime_format]));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_datetime_pattern', 'content' => $event['object']->country->datetime_data_type->datetime_format]));
                            }else{
                                // Set defaults
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_date_format', 'content' => 'date']));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_time_format', 'content' => 'time']));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_datetime_format', 'content' => 'datetime']));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_date_pattern', 'content' => 'Y-m-d']));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_time_pattern', 'content' => 'H:i:s']));
                                $event['object']->head->add(new html_meta(['class' => 'setting', 'name' => 'locales.default_datetime_pattern', 'content' => 'Y-m-d H:i:s']));
                            }
                        }
                    );
                }

                /*
                 * Add an event listener and listen
                 * for the adapt ready event so that we
                 * can add settings to the page
                 */
//                $global_adapt = $GLOBALS['adapt'];
//                $global_adapt->on(
//                    \adapt\base::EVENT_READY,
//                    function($event){
//                        if (!$this->setting("added_locale_to_head")) {
//                            $adapt = $GLOBALS['adapt'];
//                            if ($adapt->dom && $adapt->dom instanceof \adapt\page){
//
//                                $datetime = $adapt->data_source->get_data_type($adapt->setting('locales.default_datetime_format'));
//                                $date = $adapt->data_source->get_data_type($adapt->setting('locales.default_date_format'));
//                                $time = $adapt->data_source->get_data_type($adapt->setting('locales.default_time_format'));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_date_format', 'content' => $date['name'])));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_time_format', 'content' => $time['name'])));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_datetime_format', 'content' => $datetime['name'])));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_date_pattern', 'content' => $date['datetime_format'])));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_time_pattern', 'content' => $time['datetime_format'])));
//                                $adapt->dom->head->add(new html_meta(array('class' => 'setting', 'name' => 'locales.default_datetime_pattern', 'content' => $datetime['datetime_format'])));
//                                $this->setting("added_locale_to_head", true);
//                            }
//                        }
//                    }
//                );
                
                    
                
                
                return true;
            }
            
            return false;
        }

        public function install()
        {
            if (parent::install()) {

                $this->data_source->sql(
                    'create index language_long_code
                      on language (long_code(5));'
                )->execute();

                return true;
            }
            return false;
        }
        
    }
    
    
}

?>