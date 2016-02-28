
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Movement', 'Movements', 1)), array('action' => 'view', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Form->postLink(__('Delete Movement'), array('action' => 'delete', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Movement.description')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Movements'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('New Movement Category'), array('controller' => 'movement_categories', 'action' => 'addFromMovement', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?> </li>
                <li ><?php echo $this->Html->link(__('New Movement Operation'), array('controller' => 'movement_operations', 'action' => 'addFromMovement', $this->Form->value('Movement.id'),'?'=>$this->request->query), array('class' => 'btn')); ?> </li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="movements form">

            <?php echo $this->Form->create('Movement', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <h2><?php echo __('Edit Movement'); ?></h2>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('account_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fiscal_year_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('movement_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

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
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
