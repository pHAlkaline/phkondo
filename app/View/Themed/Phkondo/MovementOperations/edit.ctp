
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s',__('Operation')), array('action' => 'view', $this->Form->value('MovementOperation.id')), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled = '';
                if (!$this->Form->value('MovementOperation.deletable')) {
                    $deleteDisabled = ' disabled';
                }
                ?>
                <li ><?php echo $this->Form->postLink(__('Delete %s',__('Operation')), array('action' => 'delete', $this->Form->value('MovementOperation.id')), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('MovementOperation.name')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Movement Operations'), array('class' => 'btn', 'action' => 'index')); ?></li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

        <div class="movementOperations form">

            <?php echo $this->Form->create('MovementOperation', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('Edit Movement Operation'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <div class="form-group">
                        <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <?php if ($this->Form->value('MovementOperation.id') > 2) { ?> 
                        <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo $this->Form->input('active', array('class' => 'checkbox styled', 'label' => __('Active'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '')); ?>
                    </div>
                </div><!-- .form-group -->
                    <?php } ?>
            </fieldset>
            <div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
