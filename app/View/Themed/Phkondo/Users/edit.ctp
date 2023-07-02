<?php

$this->Html->script('user_edit', false); ?>
<?php
$role_options=Configure::read('User.role');
foreach ($role_options as $key => $value){
    $role_options[$key]=__($value);
}

?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __('User')), array('action' => 'view', $this->Form->value('User.id')),array('class'=>'btn')); ?></li>
                <li ><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $this->Form->value('User.id')), array('class'=>'btn','confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('User.name')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

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
                <legend><?php echo __('Edit User'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('name', array('autocomplete'=>'off','class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('role', array('options' => $role_options, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('email', array('class' => 'form-control','autocomplete'=>'off')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('username', array('autocomplete'=>'off','class' => 'form-control','maxLength' => '40')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        <?php echo $this->Form->input('edpassword', array('class' => 'checkbox styled', 'label' => __('Enable password change'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '', 'type' => 'checkbox')); ?>
                    </div>

                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('password', array('autocomplete'=>'new-password','disabled' => 'disabled', 'class' => 'form-control','minlength'=>'8', 'maxLength' => '40', 'type' => 'password')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('verify_password', array('autocomplete'=>'new-password','disabled' => 'disabled', 'class' => 'form-control','minlength'=>'8', 'maxLength' => '40', 'type' => 'password')); ?>
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
