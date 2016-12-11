<div class="login-box">
    <div class="login-logo">
        <b><?php echo Configure::read('Theme.owner_name'); ?>&nbsp;</b>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <?php echo $this->Flash->render(); ?>
        <p class="login-box-msg"><?php echo __('Start Session'); ?></p>
        <?php
        echo $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'login'),
            'role' => 'form',
        ));
        ?>
        <?php if (Configure::read('Application.mode') == 'demo') { ?>
        <p>Username: demo , Password: demo1234</p>
        <?php } ?>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('username', array('div' => null, 'class' => 'form-control', 'placeholder' => 'username', 'type' => 'username')); ?>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo $this->Form->input('password', array('div' => null, 'class' => 'form-control', 'placeholder' => 'password', 'type' => 'password')); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">

            <?php echo $this->Form->input('language', array('div' => null, 'class' => 'form-control', 'placeholder' => 'language', 'options' => Configure::read('Language.list'))); ?>
            <span class="glyphicon glyphicon-flag form-control-feedback"></span>
        </div><!-- .form-group -->
        <div class="form-group has-feedback">

            <?php echo $this->Form->input('theme', array('div' => null, 'class' => 'form-control', 'placeholder' => 'theme', 'options' => Configure::read('Theme.list'))); ?>
            <span class="glyphicon glyphicon-flag form-control-feedback"></span>
        </div><!-- .form-group -->
        
        <div class="form-group">
            <div class="col-md-6 checkbox required">
                <input type="checkbox" name="data[User][rememberMe]" id="UserRememberMe">
                <label for="rememberme"><?php echo ' '.__('Remember Me'); ?></label>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->button(__('Sign In'), array('type' => 'submit', 'class' => 'btn btn-primary pull-right')); ?>

            </div><!-- /.col -->
        </div>

        <?php echo $this->Form->end(); ?>
        <div class="clearfix"></div>
        <!--div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div--><!-- /.social-auth-links -->

        <!--a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a-->

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->