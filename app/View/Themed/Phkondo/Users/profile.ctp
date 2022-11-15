<?php
$this->Html->script('user_edit', false);

$role_options = Configure::read('User.role');
foreach ($role_options as $key => $value) {
    $role_options[$key] = __($value);
}

?>

<div id="page-content" class="col-sm-12 col-md-10">

    <div class="users form">

        <?php echo $this->Form->create('User', array(
            'class' => 'form-horizontal',
            'role' => 'form',
            'inputDefaults' => array(
                'class' => 'form-control',
                'label' => array('class' => 'col-sm-2 control-label'),
                'between' => '<div class="col-sm-6">', 'after' => '</div>',
            )
        )); ?>
        <fieldset>
            <legend><?php echo __('Reserved area'); ?></legend>
            <div class="form-group">
                <?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
            </div><!-- .form-group -->
            <div class="form-group">
                <?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
            </div><!-- .form-group -->
            <div class="form-group">
                <?php echo $this->Form->input('username', array('class' => 'form-control', 'maxLength' => '40')); ?>
            </div><!-- .form-group -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?php echo $this->Form->input('edpassword', array('class' => 'checkbox styled', 'label' => __('Enable password change'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '', 'type' => 'checkbox')); ?>
                </div>
            </div><!-- .form-group -->
            <div class="form-group">
                <?php echo $this->Form->input('password', array('disabled' => 'disabled', 'class' => 'form-control', 'minlength' => '8', 'maxLength' => '40', 'type' => 'password')); ?>
            </div><!-- .form-group -->
            <div class="form-group">
                <?php echo $this->Form->input('verify_password', array('disabled' => 'disabled', 'class' => 'form-control', 'minlength' => '8', 'maxLength' => '40', 'type' => 'password')); ?>
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