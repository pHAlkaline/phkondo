
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('New Insurance'), array('action' => 'add','?'=>$this->request->query),array('class'=>'btn')); ?></li>
                <li ><?php echo $this->Form->postLink(__('Delete Insurance'), array('action' => 'delete', $this->Form->value('Insurance.id'),'?'=>$this->request->query), array('class'=>'btn','confirm'=> __('Are you sure you want to delete # %s?', $this->Form->value('Insurance.title')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Insurances'), array('action' => 'index','?'=>$this->request->query),array('class'=>'btn')); ?></li>
               
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="insurances form">

            <?php echo $this->Form->create('Insurance', array('class' => 'form-horizontal',                 'role' => 'form',                 'inputDefaults' => array(                     'class' => 'form-control',                     'label' => array('class' => 'col-sm-2 control-label'),                     'between' => '<div class="col-sm-6">',                     'after' => '</div>',                     ))); ?>
            <fieldset>
                <legend><?php echo __('Edit Insurance'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id', array('empty'=>'','class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('expiration_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('insurance_company', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('policy', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('insurance_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('insurance_amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('insurance_premium', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
<?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
