<?php $this->Html->script('support_add', false); ?>

<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('List Supports'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="supports form">

            <?php
            echo $this->Form->create('Support', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>'
                )
                    )
            );
            ?>
            <?php echo $this->Form->hidden('change_filter'); ?>
            <fieldset>
                <legend><?php echo __('Add Support'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('client_id',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('subject',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('description',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('notes',  array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('support_category_id',  array('label' => array('text'=>__('Category'),'class' => 'col-sm-2 control-label'),'class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('support_status_id',  array('label' => array('text'=>__('Status'),'class' => 'col-sm-2 control-label'),'class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('support_priority_id',  array('label' => array('text'=>__('Priority'),'class' => 'col-sm-2 control-label'),'class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('assigned_user_id',  array('label' => array('text'=>__('Assigned To'),'class' => 'col-sm-2 control-label'),'class' => 'form-control')); ?>
                </div>

            </fieldset>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
