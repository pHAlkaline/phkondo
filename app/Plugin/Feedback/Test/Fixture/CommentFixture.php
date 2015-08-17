<?php
/**
	CakePHP Feedback Plugin

	Copyright (C) 2012-3827 dr. Hannibal Lecter / lecterror
	<http://lecterror.com/>

	Multi-licensed under:
		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
		LGPL <http://www.gnu.org/licenses/lgpl.html>
		GPL <http://www.gnu.org/licenses/gpl.html>
*/

/**
 * CommentFixture
 *
 */
class CommentFixture extends CakeTestFixture
{

/**
 * Fields
 *
 * @var array
 */
	public $fields = array
		(
			'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
			'foreign_model' => array('type' => 'string', 'null' => false, 'length' => 100),
			'foreign_id' => array('type' => 'integer', 'null' => false),
			'user_id' => array('type' => 'integer', 'null' => true),
			'author_ip' => array('type' => 'string', 'null' => true, 'length' => 20),
			'author_name' => array('type' => 'string', 'null' => false, 'length' => 100),
			'author_email' => array('type' => 'string', 'null' => false, 'length' => 100),
			'author_website' => array('type' => 'string', 'null' => true, 'length' => 200),
			'content' => array('type' => 'text', 'null' => false),
			'created' => array('type' => 'datetime', 'null' => true),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'ix_comments_foreign_data' => array('column' => array('foreign_id', 'foreign_model'), 'unique' => 0)),
			'tableParameters' => array()
		);

/**
 * Records
 *
 * @var array
 */
	public $records = array
		(
			array(
				'id' => '1',
				'foreign_model' => 'Article',
				'foreign_id' => '1',
				'user_id' => NULL,
				'author_ip' => NULL,
				'author_name' => 'Testis',
				'author_email' => 'testicle@example.com',
				'author_website' => NULL,
				'content' => 'Well, this sucks...

	and this is some html: <a href="http://lecterror.com/">feck</a>

	<script type="text/javascript">alert(\'feck\');
	</script>',
				'created' => '2011-11-20 23:55:27.000'
			),
			array(
				'id' => '2',
				'foreign_model' => 'Article',
				'foreign_id' => '1',
				'user_id' => '2',
				'author_ip' => '127.0.0.1',
				'author_name' => 'name',
				'author_email' => 'mail@shite.com',
				'author_website' => '',
				'content' => 'koment',
				'created' => '2012-04-15 23:26:58'
			),
			array(
				'id' => '3',
				'foreign_model' => 'Article',
				'foreign_id' => '2',
				'user_id' => NULL,
				'author_ip' => '127.0.0.1',
				'author_name' => 'newjm',
				'author_email' => 'nejmich@example.com',
				'author_website' => 'www.example.com',
				'content' => 'zis iz ze komment..',
				'created' => '2012-04-18 22:10:54'
			),
//			array(
//				'id' => '4',
//				'foreign_model' => 'Download',
//				'foreign_id' => '1',
//				'user_id' => NULL,
//				'author_ip' => '127.0.0.1',
//				'author_name' => 'smee',
//				'author_email' => 'smee@la.arse',
//				'author_website' => 'la.arse',
//				'content' => 'This really sucks ya know',
//				'created' => '2012-04-18 22:16:26'
//			),
//			array(
//				'id' => '5',
//				'foreign_model' => 'Download',
//				'foreign_id' => '2',
//				'user_id' => NULL,
//				'author_ip' => '127.0.0.1',
//				'author_name' => 'guzonjin sin',
//				'author_email' => 'sin@guzonja.com',
//				'author_website' => 'guzonjin-sin.com',
//				'content' => 'jer ja sam guzonjin siiiiiiiiiiiiiiiiiiiiiiiin',
//				'created' => '2012-04-19 00:30:20'
//			),
//			array(
//				'id' => '6',
//				'foreign_model' => 'Article',
//				'foreign_id' => '1',
//				'user_id' => NULL,
//				'author_ip' => '127.0.0.1',
//				'author_name' => 'idemo',
//				'author_email' => 'nasi@gmalj.kom',
//				'author_website' => 'I\'m not telling',
//				'content' => 'this is horrible, oh lala chachacha',
//				'created' => '2012-06-03 19:03:07'
//			),
//			array(
//				'id' => '7',
//				'foreign_model' => 'Article',
//				'foreign_id' => '1',
//				'user_id' => NULL,
//				'author_ip' => '127.0.0.1',
//				'author_name' => 'Cave Johnson',
//				'author_email' => 'cj@aperture.com',
//				'author_website' => '',
//				'content' => 'I\'m paying for it!',
//				'created' => '2012-06-03 19:20:34'
//			),
//			array(
//				'id' => '8',
//				'foreign_model' => 'Article',
//				'foreign_id' => '1',
//				'user_id' => NULL,
//				'author_ip' => '127.0.0.1',
//				'author_name' => 'lecterror',
//				'author_email' => 'neutrinocms@gmail.com',
//				'author_website' => '',
//				'content' => 'FECK! ARSE! DRINK! GIRLS!',
//				'created' => '2012-06-03 19:25:16'
//			),
		);
}
