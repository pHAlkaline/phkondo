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
?>
<?php $this->layout = 'comment.error'; ?>
<div id="validation-errors">
	<?php foreach ($validation_errors as $field): ?>
		<?php foreach ($field as $index => $error): ?>
			<p><?php echo $error; ?></p>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>
<p><?php echo __('Please go back and try again'); ?></p>