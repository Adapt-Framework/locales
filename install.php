<?php

/* Prevent Direct Access */
defined('ADAPT_STARTED') or die;

$adapt = $GLOBALS['adapt'];

$sql = $adapt->data_source->sql;

$sql->on('adapt.error', function($error){
    print new \frameworks\adapt\html_pre(print_r($error, true));
});

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