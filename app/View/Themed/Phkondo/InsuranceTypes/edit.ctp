<?php
$deleteDisabled = '';
if (!$this->Form->value('InsuranceType.deletable')) {
    $deleteDisabled = ' disabled';
}
?>


<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __('Insurance Type')), array('action' => 'view', $this->Form->value('InsuranceType.id')), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete %s', __('Insurance Type')), array('action' => 'delete', $this->Form->value('InsuranceType.id')), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('InsuranceType.name')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Insurance Types'), array('action' => 'index'), array('class' => 'btn ')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="fractio-type form">

            <?php
            echo $this->Form->create('InsuranceType', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>')));
            ?>
            <fieldset>
                <legend><?php echo __('Edit Insurance Type'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo $this->Form->input('active', array('class' => '', 'label' => __('Active'), 'div' => array('class' => 'checkbox'), 'between' => '', 'after' => '')); ?>
                    </div>
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
