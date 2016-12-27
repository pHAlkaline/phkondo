<?php $this->Html->script('note_edit', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Note', 'Notes', 1)), array('action' => 'view', $this->Form->value('Note.id'), '?' => $this->request->query), array('class' => 'btn')); ?></li>
                <?php
                $deleteDisabled = '';
                if (!$this->Form->value('Note.deletable')) {
                    $deleteDisabled = 'disabled';
                }
                ?>
                <li ><?php echo $this->Form->postLink(__('Delete Note'), array('action' => 'delete', $this->Form->value('Note.id'), '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Note.title')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Notes'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="fraction_notes form">

            <?php
            echo $this->Form->create('Note', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array(
                        'class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>')
                    )
            );
            ?>
            <fieldset>
                <legend><?php echo __('Edit Note'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('note_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <!--div class="form-group">
                <?php //echo $this->Form->label('pending_amount', __('Pending Amount'), array('class' => 'control-label'));  ?>
                <?php //echo $this->Form->input('pending_amount', array('class' => 'form-control'));  ?>
                </div--><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('document_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('due_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('note_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <?php
                $hidden = "hidden";
                $disabled = "disabled";

                if ($this->Form->value('note_status_id') == '3') {
                    $hidden = null;
                    $disabled = null;
                }
                ?>
                <div class="form-group <?php echo $hidden; ?>" id="elem_payment_date">
                    <?php echo $this->Form->input('payment_date', array('type' => 'text', 'class' => 'form-control datefield', 'disabled' => $disabled)); ?>
                </div><!-- .form-group -->

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
