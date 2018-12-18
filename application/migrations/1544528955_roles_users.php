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
class Roles_Users extends Migration {

	public function up()
	{
		$this->create_table( "roles_users", array(
			'user_id' => array('integer','unsigned' => TRUE),
			'role_id' => array('integer','unsigned' => TRUE),
			), array (
				'id' => FALSE,
				'options' => 'ENGINE=innoDB CHARSET=utf8'
			)
		);

		$this->add_index("roles_users", "primy", array('user_id', 'role_id'), "primary");
		$this->add_index("roles_users", "fk_role_id", "role_id", "normal");

		$this->execute(
			"INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES('1', '1');
			INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES('1', '2');"
		);		
	}

	public function down()
	{
	}
}
