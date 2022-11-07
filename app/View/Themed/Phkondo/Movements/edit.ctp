
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Movement', 'Movements', 1)), array('action' => 'view', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?></li>
                 <?php if ($deletable) { ?>
                <li ><?php echo $this->Form->postLink(__('Delete Movement'), array('action' => 'delete', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Movement.description')))); ?></li>
                 <?php } ?>
                <li ><?php echo $this->Html->link(__('List Movements'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('New Movement Category'), array('controller' => 'movement_categories', 'action' => 'addFromMovement', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?> </li>
                <li ><?php echo $this->Html->link(__('New Movement Operation'), array('controller' => 'movement_operations', 'action' => 'addFromMovement', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?> </li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

        <div class="movements form">

            <?php echo $this->Form->create('Movement', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('Edit Movement'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('account_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fiscal_year_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <?php if ($openMovement){ ?>
                 <div class="form-group">
                    <?php echo $this->Form->input('movement_date', array(
                        'type' => 'text',
                        'value'=>$fiscalYearData['FiscalYear']['open_date'],
                        'class' => 'form-control',
                        'readonly')); ?>
                </div><!-- .form-group -->
                <?php } else { ?>
                <div class="form-group">
                    <?php echo $this->Form->input('movement_date', array(
                        'type' => 'text', 
                        'class' => 'form-control datefield',
                        'data-date-start-date'=>$fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date'=>$fiscalYearData['FiscalYear']['close_date'],
                        )); ?>
                </div><!-- .form-group -->
                <?php } ?>
                

                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('movement_category_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('movement_operation_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('movement_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('document', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
