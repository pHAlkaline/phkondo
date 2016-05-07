<?php
$role_options = Configure::read('User.role');
foreach ($role_options as $key => $value) {
    $role_options[$key] = __($value);
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('List Users'), array('action' => 'index'), array('class' => 'btn')); ?></li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="users form">

            <?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('New User'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('username', array('class' => 'form-control', 'maxLength' => '40')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('password', array('class' => 'form-control', 'maxLength' => '40', 'type' => 'password')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('verify_password', array('class' => 'form-control', 'maxLength' => '40', 'type' => 'password')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('role', array('options' => $role_options, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="col-sm-offset-2 col-sm-10">
                    <?php echo $this->Form->input('active', array('class' => '', 'label' => __('Active'), 'div' => array('class' => 'checkbox'),  'between' => '', 'after' => '')); ?>
                </div>

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
