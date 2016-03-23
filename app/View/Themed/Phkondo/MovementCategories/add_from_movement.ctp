
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php if (isset($movementId) && $movementId != null) { ?>
                    <li ><?php echo $this->Html->link(__('Return'), array('controller' => 'movements', 'action' => 'edit', $movementId,'?'=>$this->request->query),array('class'=>'btn')); ?></li>
                <?php } else { ?>
                    <li ><?php echo $this->Html->link(__('Return'), array('controller' => 'movements', 'action' => 'add','?'=>$this->request->query),array('class'=>'btn')); ?></li>
                <?php } ?>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="movementCategories form">

            <?php echo $this->Form->create('MovementCategory', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('New Movement Category'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo $this->Form->input('active', array('class' => '', 'label' => __('Active'), 'div' => array('class' => 'checkbox'),  'between' => '', 'after' => '')); ?>
                    </div>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
