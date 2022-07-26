<div class="login-box ">
    <div class="login-box-body">
        <div class="animate__animated animate__fadeIn">
        <?php echo $this->Html->image('logo_phkondo_flat.svg', array('alt' => 'pHKondo', 'class' => 'img-responsive center-block')); ?>
        </div>
        <p class="login-box-msg"></p>
       <?php echo $this->Flash->render(); ?>

        <?php
        echo $this->Form->create('User', array(
            'url' => array('controller' => 'users', 'action' => 'login'),
            'role' => 'form',
        ));
        ?>
        <?php if (Configure::read('Application.mode') == 'demo') { ?>
        <p class="login-box-msg"><strong>Username:</strong> demo<br/><strong>Password:</strong> demo00000</p>
        <p class="login-box-msg"></p>
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
            <?php echo $this->Form->input('language', array('div' => null, 'class' => 'form-control', 'placeholder' => 'language', 'options' => Configure::read('Language.list'), 'value' => Configure::read('Config.language'))); ?>
            <span class="glyphicon glyphicon-flag form-control-feedback"></span>
        </div><!-- .form-group -->
        <div class="form-group has-feedback">

            <?php echo $this->Form->input('theme', array('div' => null, 'class' => 'form-control', 'placeholder' => 'theme', 'options' => Configure::read('Theme.list'))); ?>
            <span class="glyphicon glyphicon-flag form-control-feedback"></span>
        </div><!-- .form-group -->

        <div class="form-group">
            <div class="col-md-6 checkbox checkbox-success required">
                <input type="checkbox" name="data[User][rememberMe]" id="UserRememberMe" class="styled">
                <label for="rememberme"><?php echo ' '.__('Remember Me'); ?></label>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->button(__('Start Session'), array('type' => 'submit', 'class' => 'btn btn-primary pull-right')); ?>

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