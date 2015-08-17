<?php 
class FeedbackSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'foreign_model' => array('type' => 'string', 'null' => false, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => false),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'author_ip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'author_name' => array('type' => 'string', 'null' => false, 'length' => 100),
		'author_email' => array('type' => 'string', 'null' => false, 'length' => 100),
		'author_website' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'content' => array('type' => 'text', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ix_comments_foreign_data' => array('column' => array('foreign_id', 'foreign_model'), 'unique' => 0)),
		'tableParameters' => array()
	);
	public $ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'foreign_model' => array('type' => 'string', 'null' => false, 'length' => 100),
		'foreign_id' => array('type' => 'integer', 'null' => false),
		'author_ip' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'rating' => array('type' => 'float', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ix_ratings_foreign_data' => array('column' => array('foreign_id', 'foreign_model'), 'unique' => 0)),
		'tableParameters' => array()
	);
}
