<?php $this->Html->script('install', false); ?>
<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-12 col-md-10">

    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'install', 'action' => 'adminuser')));
        ?>
        <fieldset>
            <legend><?php echo __d('install', 'Administrator Account'); ?></legend>
            <div class="form-group">
                    <?php echo $this->Form->input('User.username', array('class' => 'form-control','maxLength' => '40', 'label' => __('Username'), 'value' => 'admin')); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                <?php
                echo $this->Form->input('User.password', array('class' => 'form-control', 'minlength' => '8', 'maxlength' => '40', 'label' => __('Password'), 'value' => ''));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('User.verify_password', array('class' => 'form-control', 'minlength' => '8', 'maxlength' => '40', 'label' => __d('install', 'Verify Password'), 'type' => 'password', 'value' => ''));
                ?>
            </div>

        </fieldset>
        <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary')); ?>  
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

</div>