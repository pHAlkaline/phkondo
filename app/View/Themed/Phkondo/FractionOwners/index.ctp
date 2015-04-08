<div id="page-container" class="row">
    
    <div id="page-content" class="col-sm-12">

        <div class="entities index">

            <h2 class="col-sm-9"><?php echo __n('Owner','Owners',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Owner'), array('action' => 'add'), array('class' => 'btn btn-primary', 'style' => 'margin: 14px 1px; float: right;', 'escape' => false)); ?>
                </div><!-- /.actions -->
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo __('Name'); ?></th>
                            <th><?php echo __('Address'); ?></th>
                            <th><?php echo __n('Contact','Contacts',2); ?></th>
                            <th class="amount"><?php echo __('Owner Percentage').' ( % )'; ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fraction['Entity'] as $entity): ?>
                            <tr>
                                <td><?php echo h($entity['name']); ?>&nbsp;</td>
                                <td><?php echo h($entity['address']); ?>&nbsp;</td>
                                <td><?php echo h($entity['contacts']); ?>&nbsp;</td>
                                <td style="text-align:right;"><?php echo h($entity['EntitiesFraction']['owner_percentage']); ?>&nbsp;&percnt;</td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $entity['id']), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $entity['id']), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'remove', $entity['id']), array('title'=>__('Remove'),'title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false), __('Are you sure you want to remove # %s?', $entity['name'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                <div class="entities form hidden-print">

            <?php echo $this->Form->create('EntitiesFraction', array('url' => array('controller' => 'fraction_owners', 'action' => 'insert'),'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>',
                    ))); ?>
            <fieldset>
                <h2><?php echo __('Insert Owner'); ?></h2>
                <div class="form-group">
                    <?php echo $this->Form->input('entity_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->


            </fieldset>
            <?php echo $this->Form->submit(__('Submit'), array('escape'=>false, 'class' => 'btn btn-large btn-primary')); ?>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
