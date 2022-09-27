<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-10">

    <div class="install form">
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'install', 'action' => 'email')));
        ?>
        <fieldset>
            <legend><?php echo __d('install', 'Setup notification email'); ?></legend>
            <div class="form-group">
                <p>USING GOOGLE ACCOUNT?</p>
                <p>
                    You will need to have access for less secure apps enabled in your Google account for this to work:
                    <a target="_blank" class="reference external" href="https://support.google.com/accounts/answer/6010255">
                        Allowing less secure apps to access your account</a>.
                </p>
            </div>
            <hr/>
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