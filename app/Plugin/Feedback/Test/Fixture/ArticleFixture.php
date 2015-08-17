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
 * ArticleFixture
 *
 */
class ArticleFixture extends CakeTestFixture
{

/**
 * Fields
 *
 * @var array
 */
	public $fields = array
		(
			'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
			'title' => array('type' => 'string', 'null' => false, 'length' => 200),
			'content' => array('type' => 'text', 'null' => false),
			'tableParameters' => array()
		);

/**
 * Records
 *
 * @var array
 */
	public $records = array
		(
			array
			(
				'id' => 1,
				'title' => 'This is my title',
				'content' => 'There are many like it, but this one is mine.',
			),
			array
			(
				'id' => 2,
				'title' => 'This is my other title',
				'content' => 'But this one has no references in it. Sorry about that old chap.',
			),
			array
			(
				'id' => 3,
				'title' => 'There is only one God and his name is Chtulhu',
				'content' => 'Yeah, did not continue the theme there..',
			),
		);
}
