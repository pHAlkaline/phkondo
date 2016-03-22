<?php

$this->Html->script('fraction_owner_index', false); ?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Owner', 'Owners', 2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Owner'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo __('Name'); ?></th>
                            <th><?php echo __('Address'); ?></th>
                            <th><?php echo __n('Contact', 'Contacts', 2); ?></th>
                            <th class="amount"><?php echo __('Owner Percentage') . ' ( % )'; ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions');    ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fraction['Entity'] as $entity): ?>
                        <tr>
                            <td><?php echo h($entity['name']); ?>&nbsp;</td>
                            <td><?php echo nl2br(h($entity['address'])); ?>&nbsp;</td>
                            <td><?php echo h($entity['contacts']); ?>&nbsp;</td>
                            <td style="text-align:right;"><?php echo h($entity['EntitiesFraction']['owner_percentage']); ?>&nbsp;&percnt;</td>
                            <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $entity['id'],'?'=>$this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $entity['id'],'?'=>$this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'remove', $entity['id'],'?'=>$this->request->query), array('title' => __('Remove'), 'title' => __('Remove'), 'class' => 'btn btn-default btn-xs', 'escape' => false), __('Are you sure you want to remove # %s?', $entity['name'])); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"><strong><?php echo __('Add Owner'); ?></strong></div>
                <div class="panel-body">
                    <div class="entities form hidden-print">

                <?php
                echo $this->Form->create('EntitiesFraction', array('url' => array('controller' => 'fraction_owners', 'action' => 'insert','?'=>$this->request->query), 'class' => 'form-horizontal',
                    'role' => 'form',
                    'inputDefaults' => array(
                        'class' => 'form-control',
                        'label' => array('class' => 'col-sm-2 control-label'),
                        'between' => '<div class="col-sm-6">',
                        'after' => '</div>',
                )));
                echo $this->Form->hidden('fraction_id', array('class' => 'form-control','value'=>$phkRequestData['fraction_id']));
                ?>
                        <fieldset>

                            <div class="form-group">
                        <?php echo $this->Form->input('client', array('label' => array('text'=>__('Owner'),'class' => 'col-sm-2 control-label'),'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                        <?php echo $this->Form->input('owner_percentage', array('min' => '0.00', 'max' => '100.00')); ?>
                            </div><!-- .form-group -->


                        </fieldset>
                        <div class="form-group col-sm-8">
                        <?php echo $this->Form->submit(__('Submit'), array('escape' => false, 'class' => 'btn btn-large btn-primary pull-right')); ?>
                        </div>
                <?php echo $this->Form->end(); ?>

                    </div><!-- /.form -->
                </div>
            </div>
        </div><!-- /#page-content .col-sm-9 -->

    </div><!-- /#page-container .row-fluid -->
</div>
