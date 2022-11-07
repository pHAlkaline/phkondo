
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('List Maintenances'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('New Supplier'), array('controller' => 'suppliers', 'action' => 'addFromMaintenance', $this->Form->value('Maintenance.id'),'?'=>$this->request->query), array('class' => 'btn')); ?> </li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

        <div class="maintenances form">

            <?php echo $this->Form->create('Maintenance', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('New Maintenance'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('supplier_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('client_number', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('contract_number', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('start_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('renewal_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('last_inspection', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('next_inspection', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('comments', ['label'=>['text'=>__('Observations'),'class'=>'col-sm-2 control-label'],'class' => 'form-control']); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo $this->Form->input('active', array('class' => 'checkbox styled', 'label' => __('Active'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '')); ?>
                    </div>
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
