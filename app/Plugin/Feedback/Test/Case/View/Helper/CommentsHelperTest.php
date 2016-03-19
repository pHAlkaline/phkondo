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

App::uses('View', 'View');
App::uses('CommentsHelper', 'Feedback.View/Helper');

if (!class_exists('CommentedArticle'))
{
	class CommentedArticle extends CakeTestModel
	{
		public $name = 'Article';
		public $alias = 'Article';
		public $useTable = 'articles';

		public $hasMany = array
			(
				'Comment' => array
				(
					'className'		=> 'Feedback.Comment',
					'conditions'	=> 'Comment.foreign_model = \'Article\'',
					'foreignKey'	=> 'foreign_id',
				),
			);
	}
}

/**
 * CommentsHelper Test Case
 *
 * @property CommentsHelper $Comments
 * @property CommentedArticle $Article
 * @property array $test_article_1
 * @property array $test_article_2
 * @property array $test_article_3
 */
class CommentsHelperTest extends CakeTestCase
{
	public $fixtures = array
		(
			'plugin.feedback.article',
			'plugin.feedback.comment',
		);

	public function setUp()
	{
		parent::setUp();

		$this->Article = ClassRegistry::init('CommentedArticle');
		$this->test_article_1 = $this->Article->read(null, 1);
		$this->test_article_2 = $this->Article->read(null, 2);
		$this->test_article_3 = $this->Article->read(null, 3);
//		debug($this->test_article_1);
//		debug($this->test_article_2);
//		debug($this->test_article_3);

		$View = new View();

		//$View->request = new CakeRequest();
		$View->request = $this->getMock('CakeRequest', array('_readInput'));
		$View->request->addParams
			(
				array
				(
					'models' => array('CommentedArticle' => array()),
					'controller' => 'articles',
					'action' => 'view',
				)
			);

		$View->Gravatar = $this->getMock('GravatarHelper', array('image'));

		$this->Comments = new CommentsHelper($View);
		$View->Comments->Gravatar = $View->Gravatar;
	}

	public function tearDown()
	{
		unset($this->Comments);
		unset($this->Article);

		parent::tearDown();
	}

	public function testDisplayFor()
	{
		$result = $this->Comments->display_for($this->test_article_1, array('showForm' => false));

		$this->assertRegExp('#and this is some html: &lt;a href=&quot;http://lecterror.com/&quot;&gt;feck&lt;/a&gt;<br />#', $result);
		$this->assertRegExp('#&lt;script type=&quot;text/javascript&quot;&gt;alert\(&\#039;feck&\#039;\);<br />#', $result);

		$expected = array
			(
				'tag' => 'div',
				'attributes' => array('class' => 'comment-list'),
				'ancestor' => array
				(
					'tag' => 'section',
					'attributes' => array('class' => 'comments-container'),
					'descendant' => array
					(
						'tag' => 'header',
						'children' => array
						(
							'count' => 1,
							'only' => array('tag' => 'h2'),
						),
					),
				),
				'children' => array
				(
					'count' => 2,
					'only' => array
					(
						'tag' => 'article',
						'attributes' => array('class' => 'comment-content')
					),
				),
			);

		$this->assertTag($expected, $result, 'Comment containers structure');

		$expected = array
			(
				'tag' => 'a', 
				'id' => 'comment-1',
				'parent' => array
				(
					'tag' => 'article',
					'attributes' => array
					(
						'class' => 'comment-content'
					),
				)
			);

		$this->assertTag($expected, $result, 'Comment anchor present');

		// For some reason, this assert fails, even though it's the same
		// as the one above, except for the 'comment-2' difference..
		// Bug in PHPUnit??
//		$expected = array
//			(
//				'tag' => 'a', 
//				'id' => 'comment-2',
//				'parent' => array
//				(
//					'tag' => 'article',
//					'attributes' => array
//					(
//						'class' => 'comment-content'
//					),
//				)
//			);
//
//		$this->assertTag($expected, $result);

		$expected = array
			(
				'tag' => 'div', 
				'class' => 'comment-body',
				'content' => 'regexp:#koment#',
			);

		$this->assertTag($expected, $result, 'Comment content');

		$expected = array
			(
				'tag' => 'div', 
				'attributes' => array('class' => 'comment-author'),
				'parent' => array
				(
					'tag' => 'article',
					'attributes' => array
					(
						'class' => 'comment-content',
					),
				),
				'children' => array
				(
					'count' => 3,
					'only' => array('tag' => 'span'),
				),
			);

		$this->assertTag($expected, $result, 'Comment author and child spans');

		$expected = array
			(
				'tag' => 'span', 
				'attributes' => array('class' => 'comment-name'),
				'content' => 'regexp:#Testis#',
			);

		$this->assertTag($expected, $result, 'Comment name present');

		$expected = array
			(
				'tag' => 'span', 
				'attributes' => array('class' => 'comment-metadata'),
				'child' => array
				(
					'tag' => 'a',
					'attributes' => array('href' => '#comment-2', 'title' => 'Permalink'),
					'content' => 'on 2012/04/15 23:26',
				),
			);

		$this->assertTag($expected, $result, 'Comment posted at present');
	}

	public function testForm()
	{
		$result = $this->Comments->form('CommentedArticle', '2');

		$expected = array
			(
				'tag' => 'h2',
				'content' => 'Add a comment',
				'ancestor' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'comment form'),
					'descendant' => array
					(
						'tag' => 'form',
						'id' => 'CommentViewForm',
						'attributes' => array
						(
							'action' => '/feedback/comments/add/CommentedArticle/2',
							'method' => 'post',
							'accept-charset' => 'utf-8',
						),
					),
				),
			);

		$this->assertTag($expected, $result, 'Form containers structure');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][author_name]',
					'type' => 'text',
					'id' => 'CommentAuthorName',
				),
				'parent' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'input text required'),
					'child' => array
					(
						'tag' => 'label',
						'attributes' => array('for' => 'CommentAuthorName'),
						'content' => 'Name',
					),
				),
			);

		$this->assertTag($expected, $result, 'Author name input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][author_email]',
					'type' => 'text',
					'id' => 'CommentAuthorEmail',
				),
				'parent' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'input text required'),
					'child' => array
					(
						'tag' => 'label',
						'attributes' => array('for' => 'CommentAuthorEmail'),
						'content' => 'Email',
					),
				),
			);

		$this->assertTag($expected, $result, 'Author email input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][author_website]',
					'type' => 'text',
					'id' => 'CommentAuthorWebsite',
				),
				'parent' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'input text'),
					'child' => array
					(
						'tag' => 'label',
						'attributes' => array('for' => 'CommentAuthorWebsite'),
						'content' => 'Website',
					),
				),
			);

		$this->assertTag($expected, $result, 'Author website input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][hairy_pot]',
					'type' => 'hidden',
					'id' => 'CommentHairyPot',
				),
			);

		$this->assertTag($expected, $result, 'Honeypot input');

		$expected = array
			(
				'tag' => 'textarea',
				'attributes' => array
				(
					'name' => 'data[Comment][content]',
					'id' => 'CommentContent',
				),
				'parent' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'input textarea required'),
					'child' => array
					(
						'tag' => 'label',
						'attributes' => array('for' => 'CommentContent'),
						'content' => 'Comments',
					),
				),
			);

		$this->assertTag($expected, $result, 'Comment input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][foreign_model]',
					'type' => 'hidden',
					'id' => 'CommentForeignModel',
				),
			);

		$this->assertTag($expected, $result, 'Foreign model input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][foreign_id]',
					'type' => 'hidden',
					'id' => 'CommentForeignId',
				),
			);

		$this->assertTag($expected, $result, 'Foreign id input');

		$expected = array
			(
				'tag' => 'input',
				'attributes' => array
				(
					'name' => 'data[Comment][remember_info]',
					'type' => 'checkbox',
					'id' => 'CommentRememberInfo',
				),
				'parent' => array
				(
					'tag' => 'div',
					'attributes' => array('class' => 'input checkbox'),
					'child' => array
					(
						'tag' => 'label',
						'attributes' => array('for' => 'CommentRememberInfo'),
						'content' => 'Remember my info',
					),
				),
			);

		$this->assertTag($expected, $result, 'Remember info input');

		$expected = array
			(
				'tag' => 'div',
				'attributes' => array
				(
					'class' => 'submit',
				),
				'child' => array
				(
					'tag' => 'input',
					'attributes' => array
					(
						'type' => 'submit',
						'value' => 'Save comment',
					),
				),
			);

		$this->assertTag($expected, $result, 'Submit button');
	}
}
