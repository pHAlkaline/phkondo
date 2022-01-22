<div id="page-content" class="col-sm-9">
    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'email', 'action' => 'config')),['autocomplete'=>'off']);
        ?>
        <fieldset>
            <legend><?php echo __('Setup notification email'); ?></legend>
            <div class="alert alert-info">
                    <?php echo  __('Using SMTP with TLS delivery enabled'); ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('host', array('class' => 'form-control', 'label' => __('Host'), 'default' => $config['host']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('port', array('class' => 'form-control', 'label' => __('Port'), 'default' => $config['port']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('username', array('autocomplete'=>'off','class' => 'form-control', 'label' => __('Username'), 'default' => $config['username']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('password', array('autocomplete'=>'new-password', 'class' => 'form-control', 'label' => __('Password'), 'default' => $config['password']));
                ?>
            </div>
            <hr/>
            <div class="form-group">

                <?php
                echo $this->Form->input('email', array('type'=>'email', 'class' => 'form-control', 'label' => __('From Email'), 'default' => key($config['from'])));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array('class' => 'form-control', 'label' => __('From Name'), 'default' => $config['from']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('subject', array('class' => 'form-control', 'label' => __('Subject'), 'default' => $config['subject']));
                ?>
            </div>
            <hr/>
            <div class="form-group">
                                <?php echo $this->Form->input('receipt_subject', array('label' => __('Receipt Subject'), 'class' => 'form-control', 'default' => $config['receipt_subject']!=''?$config['receipt_subject']:$config['subject'])); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                                <?php echo $this->Form->input('receipt_message', array('label' => __('Receipt Message'), 'type'=>'textarea', 'label' => __('Receipt Message'), 'class' => 'form-control', 'default' => $config['receipt_message'])); ?>
            </div><!-- .form-group -->


        </fieldset>
        <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary')); ?>  
        </div>
        <?php echo $this->Form->end(); ?>

    </div>
</div>