<?php

$this->Html->script('email', false); ?>
<div id="page-content" class="col-sm-10">
    <div class="install form">

        <legend><?php echo __d('email','Config Email Client'); ?></legend>
        <section>
              <?php echo $this->Form->create(false, 
                      array('url' => array('controller' => 'email', 'action' => 'config')),
                      ['autocomplete'=>'off'],
                      array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>'))); ?>

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#connection" aria-controls="details" role="tab" data-toggle="tab"><?= __d('email','Connection'); ?></a>
                </li>
                <li role="presentation">
                    <a href="#receipt" aria-controls="receipt" role="tab" data-toggle="tab"><?= __('Receipts'); ?></a>
                </li>
                <li role="presentation">
                    <a href="#current-account" aria-controls="current-account" role="tab" data-toggle="tab"><?= __('Current Account'); ?></a>
                </li>

            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="connection" aria-labelledby="connection-tab">
                    <h2>&nbsp;</h2>


                    <fieldset>

                        <div class="form-group">
                <?php
                echo $this->Form->input('host', array('class' => 'form-control', 'label' => __d('email','Host'), 'default' => $emailClient['host']));
                ?>
                        </div>
                        <div class="alert alert-info">
                    <?php echo  __d('email','Requires SMTP host account with TLS delivery enabled'); ?>
                        </div>


                        <div class="form-group">
                <?php
                echo $this->Form->input('port', array('class' => 'form-control', 'label' => __d('email','Port'), 'default' => $emailClient['port']));
                ?>
                        </div>
                        <div class="form-group">
                <?php
                echo $this->Form->input('username', array('autocomplete'=>'off','class' => 'form-control', 'label' => __('Username'), 'default' => $emailClient['username']));
                ?>
                        </div>
                        <div class="form-group">
                <?php
                echo $this->Form->input('password', array('autocomplete'=>'new-password', 'class' => 'form-control', 'label' => __('Password'), 'default' => $emailClient['password']));
                ?>
                        </div>
                        <hr/>
                        <div class="form-group">

                <?php
                echo $this->Form->input('email', array('type'=>'email', 'class' => 'form-control', 'label' => __d('email','From Email'), 'default' => key($emailClient['from'])));
                ?>
                        </div>
                        <div class="form-group">
                <?php
                $fromKey=$emailClient['sender'][0];
                echo $this->Form->input('name', array('class' => 'form-control', 'label' => __d('email','From Name'), 'default' => $emailClient['from'][$fromKey]));
                ?>
                        </div>
                        <div class="form-group">
                <?php
                echo $this->Form->input('subject', array('class' => 'form-control', 'label' => __d('email','Subject'), 'default' => $emailClient['subject']));
                ?>
                        </div>
                        <div class="form-group">

                       <?php echo $this->Form->input('test', array('type'=>'checkbox', 'class' => 'checkbox styled', 'label' => __d('email','Send Test'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '')); ?>
                        </div><!-- .form-group -->

                    </fieldset>
                </div>
                <div role="tabpanel" class="tab-pane" id="receipt" aria-labelledby="receipt-tab">
                    <h2>&nbsp;</h2>

                    <div class="form-group">
                                <?php echo $this->Form->input('receipt_subject', array('label' => __d('email','Subject'), 'class' => 'form-control', 'default' => $emailNotifications['receipt_subject'])); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                                <?php echo $this->Form->input('receipt_message', array('label' => __d('email','Message'), 'type'=>'textarea', 'class' => 'form-control', 'default' => $emailNotifications['receipt_message'])); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                     <?php echo $this->Form->input('receipt_attachment_format', ['type'=>'select','label' => __d('email','Format'), 'class' => 'form-control select2-phkondo', 'options' => ['pdf'=>__d('email','PDF'), 'html'=>__d('html','HTML')], 'value' => $emailNotifications['receipt_attachment_format'], 'required'=>'required']); ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="current-account" aria-labelledby="curren-account-tab">
                    <h2>&nbsp;</h2>

                    <div class="form-group">
                                <?php echo $this->Form->input('current_account_subject', array('label' => __d('email','Subject'), 'class' => 'form-control', 'default' => $emailNotifications['current_account_subject'])); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                                <?php echo $this->Form->input('current_account_message', array('label' => __d('email','Message'), 'type'=>'textarea', 'class' => 'form-control', 'default' => $emailNotifications['current_account_message'])); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                     <?php echo $this->Form->input('current_account_attachment_format', ['type'=>'select','label' => __d('email','Format'), 'class' => 'form-control select2-phkondo', 'options' => ['pdf'=>__d('email','PDF'), 'html'=>__d('html','HTML')], 'value' => $emailNotifications['current_account_attachment_format'], 'required'=>'required']); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">                
            <?php echo $this->Form->button(__('Submit'), array('type'=>'submit','class' => 'btn btn-large btn-primary pull-right')); ?>&nbsp;  

            </div>
        <?php echo $this->Form->end(); ?>

        </section>

    </div>
</div>