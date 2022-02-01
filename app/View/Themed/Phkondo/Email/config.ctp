<div id="page-content" class="col-sm-10">
    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'email', 'action' => 'config')),['autocomplete'=>'off']);
        ?>
        <fieldset>
            <legend><?php echo __d('email','Setup notification email'); ?></legend>
            <div class="alert alert-info">
                    <?php echo  __d('email','Using SMTP with TLS delivery enabled'); ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('host', array('class' => 'form-control', 'label' => __d('email','Host'), 'default' => $config['host']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('port', array('class' => 'form-control', 'label' => __d('email','Port'), 'default' => $config['port']));
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
            <h2><?php echo __d('email','Default'); ?></h2>
            <div class="form-group">

                <?php
                echo $this->Form->input('email', array('type'=>'email', 'class' => 'form-control', 'label' => __d('email','From Email'), 'default' => key($config['from'])));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array('class' => 'form-control', 'label' => __d('email','From Name'), 'default' => $config['from']));
                ?>
            </div>
            <div class="form-group">
                <?php
                echo $this->Form->input('subject', array('class' => 'form-control', 'label' => __d('email','Subject'), 'default' => $config['subject']));
                ?>
            </div>
            <hr/>
            <h2><?php echo __d('email','Receipt'); ?></h2>
            <div class="form-group">
                                <?php echo $this->Form->input('receipt_subject', array('label' => __d('email','Subject'), 'class' => 'form-control', 'default' => $config['receipt_subject']!=''?$config['receipt_subject']:$config['subject'])); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                                <?php echo $this->Form->input('receipt_message', array('label' => __d('email','Message'), 'type'=>'textarea', 'class' => 'form-control', 'default' => $config['receipt_message'])); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                     <?php echo $this->Form->input('receipt_attachment_format', ['type'=>'select','label' => __d('email','Format'), 'class' => 'form-control select2-phkondo', 'options' => ['pdf'=>__d('email','PDF'), 'html'=>__d('html','HTML')], 'value' => $config['receipt_attachment_format'], 'required'=>'required']); ?>
            </div>
             <hr/>
             <h2><?php echo __d('email','Current Account'); ?></h2>
             <div class="form-group">
                                <?php echo $this->Form->input('current_account_subject', array('label' => __d('email','Subject'), 'class' => 'form-control', 'default' => $config['current_account_subject']!=''?$config['current_account_subject']:$config['subject'])); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                                <?php echo $this->Form->input('current_account_message', array('label' => __d('email','Message'), 'type'=>'textarea', 'class' => 'form-control', 'default' => $config['current_account_message'])); ?>
            </div><!-- .form-group -->

            <div class="form-group">
                     <?php echo $this->Form->input('current_account_attachment_format', ['type'=>'select','label' => __d('email','Format'), 'class' => 'form-control select2-phkondo', 'options' => ['pdf'=>__d('email','PDF'), 'html'=>__d('html','HTML')], 'value' => $config['current_account_attachment_format'], 'required'=>'required']); ?>
            </div>


        </fieldset>
        <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary pull-right')); ?>  
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>