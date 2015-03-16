
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">
                <?php if ($this->Form->value('Note.deletable')): ?>
                    <li ><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Note.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Note.id'))); ?></li>
                <?php endif; ?>
                <li ><?php echo $this->Html->link(__('List Notes'), array('action' => 'index')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="notes form">

            <?php echo $this->Form->create('Note', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <h2><?php echo __('Edit Note'); ?></h2>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('note_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('budget_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <!--div class="form-group">
                <?php //echo $this->Form->label('pending_amount', __('Pending Amount'), array('class' => 'control-label')); ?>
                <?php //echo $this->Form->input('pending_amount', array('class' => 'form-control')); ?>
                </div--><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('document_date', array('dateFormat' => 'DMY', 'minYear' => date('Y') - 10,
                        'maxYear' => date('Y') + 50, 'class' => 'form-control'));
                    ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('due_date', array('dateFormat' => 'DMY', 'minYear' => date('Y') - 10,
                        'maxYear' => date('Y') + 50, 'class' => 'form-control'));
                    ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('note_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
<?php echo $this->Form->input('payment_date', array('empty' => '', 'default' => '', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 10, 'maxYear' => date('Y') + 50, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
<div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
<?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
