<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

$sql = $adapt->data_source->sql;

$sql->on('adapt.error', function($error){
    print new \frameworks\adapt\html_pre(print_r($error, true));
});


/* Add locales data types */
$data_types = array(
    array(
        'bundle_name' => 'locales',
        'name' => 'locales_date',
        'based_on_data_type' => 'date',
        'validator' => 'date',
        'formatter' => 'locales_date',
        'unformatter' => 'locales_date',
        'datetime_format' => null,
        'max_length' => null,
        'date_created' => null
    ),
    array(
        'bundle_name' => 'locales',
        'name' => 'locales_time',
        'based_on_data_type' => 'time',
        'validator' => 'time',
        'formatter' => 'locales_time',
        'unformatter' => 'locales_time',
        'datetime_format' => null,
        'max_length' => null,
        'date_created' => null
    ),
    array(
        'bundle_name' => 'locales',
        'name' => 'locales_datetime',
        'based_on_data_type' => 'datetime',
        'validator' => 'datetime',
        'formatter' => 'locales_datetime',
        'unformatter' => 'locales_datetime',
        'datetime_format' => null,
        'max_length' => null,
        'date_created' => null
    )
);

/* Set the data types */
$adapt->data_source->data_types = array_merge($adapt->data_source->data_types, $data_types);

/* Add the new types to the data_type table */
foreach($data_types as &$data_type){
    $keys = array_keys($data_type);
    foreach($keys as $key){
        if ($key == 'date_created'){
            $data_type['date_created'] = new \frameworks\adapt\sql('now()');
        }elseif(is_null($data_type[$key])){
            $data_type[$key] = new \frameworks\adapt\sql('null');
        }
    }
}

$sql->insert_into('data_type', array_keys($data_types[0]));
foreach($data_types as $type) $sql->values(array_values($type));
$sql->execute();

/*
 * We need to set the data sources' data types to
 * null to force it to reload them because the
 * current copy is missing the ids
 */
$this->data_source->data_types = null;

/* Create the tables */
$sql->create_table('country')
    ->add('country_id', 'bigint')
    ->add('bundle_name', 'varchar(128)', false)
    ->add('label', 'varchar(128)', false)
    ->add('date_data_type_id', 'bigint')
    ->add('time_data_type_id', 'bigint')
    ->add('datetime_data_type_id', 'bigint')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('country_id')
    ->foreign_key('date_data_type_id', 'data_type', 'data_type_id')
    ->foreign_key('time_data_type_id', 'data_type', 'data_type_id')
    ->foreign_key('datetime_data_type_id', 'data_type', 'data_type_id')
    ->execute();

$sql->create_table('country_phone_data_type')
    ->add('country_phone_data_type_id', 'bigint')
    ->add('country_id', 'bigint')
    ->add('label', 'varchar(64)', false) // <<< Eg, Home, Mobile, etc...
    ->add('data_type_id', 'bigint')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('country_phone_data_type_id')
    ->foreign_key('country_id', 'country', 'country_id')
    ->foreign_key('data_type_id', 'data_type', 'data_type_id')
    ->execute();

$sql->create_table('country_address_format')
    ->add('country_address_format_id', 'bigint')
    ->add('country_id', 'bigint')
    ->add('priority', 'int', false, '1')
    ->add('name', 'varchar(64)', false)
    ->add('label', 'varchar(128)', false)
    ->add('data_type_id', 'bigint')
    ->add('max_length', 'int')
    ->add('date_created', 'datetime')
    ->add('date_modified', 'timestamp')
    ->add('date_deleted', 'datetime')
    ->primary_key('country_address_format_id')
    ->foreign_key('country_id', 'country', 'country_id')
    ->foreign_key('data_type_id', 'data_type', 'data_type_id')
    ->execute();



?>