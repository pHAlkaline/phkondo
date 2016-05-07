
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('List Owners'), array('action' => 'index','?'=>$this->request->query)); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="entities form">

            <?php echo $this->Form->create('Entity', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('New Owner'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('vat_number', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('EntitiesFraction.owner_percentage', array('class' => 'form-control', 'min' => '0.00', 'max' => '100.00')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('representative', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('address', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('contacts', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('bank', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('nib', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('comments', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
