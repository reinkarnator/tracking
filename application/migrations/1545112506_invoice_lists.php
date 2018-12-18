<?php defined('SYSPATH') OR die('No direct script access.');
/**
* create_table($table_name, $fields, array('id' => TRUE, 'options' => ''))
* drop_table($table_name)
* rename_table($old_name, $new_name)
* add_column($table_name, $column_name, $params)
* rename_column($table_name, $column_name, $new_column_name)
* change_column($table_name, $column_name, $params)
* remove_column($table_name, $column_name)
* add_index($table_name, $index_name, $columns, $index_type = 'normal')
* remove_index($table_name, $index_name)
*/
class Invoice_Lists extends Migration {

	public function up()
	{
		$this->create_table( "invoice_lists", array(
				'id' => 'primary_key',
				'date' => array('datetime', 'null' => TRUE),
				'location' => array('string', 'null' => TRUE),
				'device' => array('string', 'null' => TRUE),
				'subject' => array('string', 'null' => TRUE),
				'description' => array('text', 'null' => TRUE),
				'mails' => array('text', 'null' => TRUE),
				'pdf' => array('text', 'null' => TRUE),
				'status' => array('integer', 'null' => TRUE, 'default' => '0'),
				'change_date' => array('datetime', 'null' => FALSE),
				'user_added' => array('string', 'null' => FALSE),
				'parent_id' => array('integer', 'null' => TRUE, 'default' => '0'),
			), array(
				'id' => TRUE,
				'options' => 'ENGINE=innoDB CHARSET=utf8'
			)
		);
	}

	public function down()
	{
		$this->drop_table( "invoice_lists");
	}
}
