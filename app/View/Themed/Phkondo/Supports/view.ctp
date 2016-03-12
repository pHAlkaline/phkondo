<div class="supports view">
    <h2><?php echo __('Support'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($support['Support']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Condo'); ?></dt>
        <dd>
            <?php echo $support['Condo']['title']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Fraction'); ?></dt>
        <dd>
            <?php echo $support['Fraction']['description']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Title'); ?></dt>
        <dd>
            <?php echo h($support['Support']['title']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Description'); ?></dt>
        <dd>
            <?php echo h($support['Support']['description']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Notes'); ?></dt>
        <dd>
            <?php echo h($support['Support']['notes']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Support Category'); ?></dt>
        <dd>
            <?php echo $support['SupportCategory']['name']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Support Priority'); ?></dt>
        <dd>
            <?php echo $support['SupportPriority']['name']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Support Status'); ?></dt>
        <dd>
            <?php echo $support['SupportStatus']['name']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Request Entity'); ?></dt>
        <dd>
            <?php echo $support['Entity']['name']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Assigned User'); ?></dt>
        <dd>
            <?php echo $support['User']['name']; ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($support['Support']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($support['Support']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Support'), array('action' => 'edit', $support['Support']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Support'), array('action' => 'delete', $support['Support']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $support['Support']['id']))); ?> </li>
        <li><?php echo $this->Html->link(__('List Supports'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Support'), array('action' => 'add')); ?> </li>
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
