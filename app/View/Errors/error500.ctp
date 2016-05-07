<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<h2><?php echo $message; ?></h2>
<p class="warning">
	<strong><?php echo __d('error_page', 'You have experienced a technical error, We apologize.'); ?></strong><br/>
	<?php echo __d('error_page', 'Our Support Team has been notified and is working to correct this issue.'); ?>
</p>
<?php echo $this->Html->link('Back to pHKondo',array('plugin'=>null,'controller'=>'pages','action'=>'home')); ?>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
