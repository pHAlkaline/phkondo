<?php $this->Html->script('install', false); ?>

<div id="page-content" class="col-sm-12 col-md-10">
    <div class="install form">
        <?php echo $this->Form->create(false);
        ?>
        <fieldset>
            <legend><?php echo __d('install', 'Reinstall'); ?></legend>
            <div class="form-group">
                <p><?php echo __d('install', 'You required to reinstall.'); ?></p>
                <p><?php echo __d('install', 'Are you sure you want to reinstall # %s?', 'pHKondo'); ?></p>
                <p><?php echo __d('install', 'Required validation key was sent to your user email.'); ?></p>
                <p><?php echo __d('install', 'We need to validate your action, please enter your validation key'); ?></p>
            </div><!-- .form-group -->
            <div class="form-group col-sm-6">
                <?php echo $this->Form->input('installed_key', array('class' => 'form-control', 'maxLength' => '40', 'label' =>  __d('install', 'Installed Key'), 'value' => null)); ?>
            </div><!-- .form-group -->
        </fieldset>
        <div class="form-group">
            <div class="col-sm-6">
                <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

</div>