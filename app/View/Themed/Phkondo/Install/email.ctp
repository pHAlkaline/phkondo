<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-9">

    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'install', 'action' => 'email')));
        ?>
        <fieldset>
            <legend><?php echo __d('install', 'Setup notification email'); ?></legend>
            <div class="form-group">

                <?php
                echo $this->Form->input('email', array('class' => 'form-control', 'label' => __d('install', 'From Email'), 'default' => 'no-reply@yourhost.net'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array('class' => 'form-control', 'label' => __d('install', 'From Name'), 'default' => 'Your Site pHKondo Notification'));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('subject', array('class' => 'form-control', 'label' => __d('install', 'Subject'), 'default' => 'New pHKondo Notification!!'));
                ?>
            </div>

        </fieldset>
        <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary')); ?>  
        </div>
        <?php echo $this->Form->end(); ?>

    </div>
</div>