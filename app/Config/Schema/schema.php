<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $accounts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'bank' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'balcony' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'contacts' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'account_number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'nib' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'iban' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'swift' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'main_account' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'balance' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $accounts_fiscal_years = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'account_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'balance' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '11,2', 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ENTITY' => array('column' => 'account_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fiscal_year_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $administrators = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'functions' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'ENTITY' => array('column' => 'entity_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => true, 'key' => 'primary'),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'attachment' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'dir' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'size' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $budget_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $budget_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $budgets = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'budget_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'budget_status_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'budget_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'requested_amount' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'common_reserve_fund' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '5,2', 'unsigned' => false),
		'begin_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'shares' => array('type' => 'smallinteger', 'null' => false, 'default' => null, 'unsigned' => false),
		'share_periodicity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'share_distribution_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'due_days' => array('type' => 'smallinteger', 'null' => false, 'default' => null, 'unsigned' => false),
		'meeting_draft' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0),
			'BUDGETYPE' => array('column' => 'budget_type_id', 'unique' => 0),
			'BUDGETSTATUS' => array('column' => 'budget_status_id', 'unique' => 0),
			'SHAREPERIODICITY' => array('column' => 'share_periodicity_id', 'unique' => 0),
			'SHAREDISTRIBUTION' => array('column' => 'share_distribution_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'foreign_model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'author_ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'author_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'author_email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'author_website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ix_comments_foreign_data' => array('column' => array('foreign_id', 'foreign_model'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $condos = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'taxpayer_number' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 9, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'address' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'land_registry_year' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'matrix_registration' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'land_registry' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $drafts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'content' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'content_model' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $entities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'vat_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 9, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'representative' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'address' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'contacts' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'bank' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'nib' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 24, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $entities_fractions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'owner_percentage' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '5,2', 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ENTITY' => array('column' => 'entity_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $entity_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $fiscal_years = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'open_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'close_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $fraction_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $fractions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'manager_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'fraction_type_id' => array('type' => 'integer', 'null' => false, 'default' => '1', 'unsigned' => false, 'key' => 'index'),
		'location' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'permillage' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '6,2', 'unsigned' => false),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'MANAGER' => array('column' => 'manager_id', 'unique' => 0),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'FRACTIONTYPE' => array('column' => 'fraction_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $insurance_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $insurances = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'expiration_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'insurance_company' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'policy' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'insurance_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'insurance_amount' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'insurance_premium' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'INSURANCETYPE' => array('column' => 'insurance_type_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $invoice_conference_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $invoice_conferences = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'supplier_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'document_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'payment_due_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'invoice_conference_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0),
			'STATUS' => array('column' => 'invoice_conference_status_id', 'unique' => 0),
			'SUPPLIER' => array('column' => 'supplier_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $maintenances = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'client_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'contract_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'start_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'renewal_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'last_inspection' => array('type' => 'date', 'null' => true, 'default' => null),
		'next_inspection' => array('type' => 'date', 'null' => true, 'default' => null),
		'supplier_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'SUPPLIER' => array('column' => 'supplier_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $movement_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $movement_operations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $movement_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $movements = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'movement_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'account_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'movement_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'movement_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'movement_operation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'document_model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'MOVEMENTTYPE' => array('column' => 'movement_type_id', 'unique' => 0),
			'ACCOUNT' => array('column' => 'account_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0),
			'MOVEMENTCATEGORY' => array('column' => 'movement_category_id', 'unique' => 0),
			'MOVEMENTOPERATION' => array('column' => 'movement_operation_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $note_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $note_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $notes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'note_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'fraction_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'budget_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'pending_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'due_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'note_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'receipt_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'payment_advice_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'NOTETYPE' => array('column' => 'note_type_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'ENTITY' => array('column' => 'entity_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0),
			'BUDGET' => array('column' => 'budget_id', 'unique' => 0),
			'NOTESTATUS' => array('column' => 'note_status_id', 'unique' => 0),
			'RECEIPT' => array('column' => 'receipt_id', 'unique' => 0),
			'notes_ibfk_8' => array('column' => 'payment_advice_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $payment_advices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'due_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'observations' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'total_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'payment_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'receipt_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'CLIENT' => array('column' => 'entity_id', 'unique' => 0),
			'PAYMENTTYPE' => array('column' => 'payment_type_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'payment_advices_ibfk_5' => array('column' => 'receipt_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'foreign_model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'foreign_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'author_ip' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'rating' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ix_ratings_foreign_data' => array('column' => array('foreign_id', 'foreign_model'), 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $receipt_counters = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'counter' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $receipt_notes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'note_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'fraction_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fiscal_year_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'budget_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'pending_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'due_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'note_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'receipt_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'NOTETYPE' => array('column' => 'note_type_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'ENTITY' => array('column' => 'entity_id', 'unique' => 0),
			'FISCALYEAR' => array('column' => 'fiscal_year_id', 'unique' => 0),
			'BUDGET' => array('column' => 'budget_id', 'unique' => 0),
			'NOTESTATUS' => array('column' => 'note_status_id', 'unique' => 0),
			'RECEIPT' => array('column' => 'receipt_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $receipt_payment_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $receipt_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $receipts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'document' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'document_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'receipt_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'payment_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'receipt_payment_type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'total_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0.00', 'length' => '10,2', 'unsigned' => false),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'address' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'observations' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'cancel_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'cancel_motive' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'CLIENT' => array('column' => 'entity_id', 'unique' => 0),
			'RECEIPTSTATUS' => array('column' => 'receipt_status_id', 'unique' => 0),
			'PAYMENTUSER' => array('column' => 'payment_user_id', 'unique' => 0),
			'PAYMENTTYPE' => array('column' => 'receipt_payment_type_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'CANCELUSER' => array('column' => 'cancel_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $schema_migrations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'class' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $share_distributions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $share_periodicities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $suppliers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'vat_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 9, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'representative' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'address' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'contacts' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'bank' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'nib' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 24, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'comments' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $support_categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $support_priorities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'order' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $support_statuses = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $supports = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'condo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'fraction_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'subject' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'support_category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'support_priority_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'support_status_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'assigned_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'SUPPORTCATEGORY' => array('column' => 'support_category_id', 'unique' => 0),
			'SUPPORTPRIORITY' => array('column' => 'support_priority_id', 'unique' => 0),
			'SUPPORTSTATUS' => array('column' => 'support_status_id', 'unique' => 0),
			'CONDO' => array('column' => 'condo_id', 'unique' => 0),
			'FRACTION' => array('column' => 'fraction_id', 'unique' => 0),
			'ENTITY' => array('column' => 'entity_id', 'unique' => 0),
			'ASSIGNEDUSER' => array('column' => 'assigned_user_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 40, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'role' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'key' => 'unique', 'collate' => 'utf8mb3_general_ci', 'charset' => 'utf8mb3'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'EMAIL' => array('column' => 'email', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb3', 'collate' => 'utf8mb3_general_ci', 'engine' => 'InnoDB')
	);

}
