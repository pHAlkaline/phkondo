<div class="supports form">
<?php echo $this->Form->create('Support'); ?>
	<fieldset>
		<legend><?php echo __('Add Support'); ?></legend>
	<?php
		echo $this->Form->input('condo_id');
		echo $this->Form->input('fraction_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('notes');
		echo $this->Form->input('support_category_id');
		echo $this->Form->input('support_priority_id');
		echo $this->Form->input('support_status_id');
		echo $this->Form->input('entity_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Supports'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Condos'), array('controller' => 'condos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Condo'), array('controller' => 'condos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Fractions'), array('controller' => 'fractions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fraction'), array('controller' => 'fractions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Support Categories'), array('controller' => 'support_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Support Category'), array('controller' => 'support_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Support Priorities'), array('controller' => 'support_priorities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Support Priority'), array('controller' => 'support_priorities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Support Statuses'), array('controller' => 'support_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Support Status'), array('controller' => 'support_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entities'), array('controller' => 'entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Request Entity'), array('controller' => 'entities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Assigned User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
