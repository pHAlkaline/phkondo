<?php $this->Html->script('install', false); ?>
<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-10">
    <div class="row">

        <div class="install index">
            <?php
            $check = true;

            // tmp is writable
            if (is_writable(TMP)) {
                $message = __d('install', 'Your tmp directory is writable.');
                echoMessage($message);
            } else {
                $check = false;
                $message = __d('install', 'Your tmp directory is NOT writable.') . ' --> ' . TMP;
                echoError($message);
            }

            // config is writable
            if (is_writable(APP . 'Config')) {
                $message = __d('install', 'Your Config directory is writable.');
                echoMessage($message);
            } else {
                $check = false;
                $message = __d('install', 'Your Config directory is NOT writable.') . ' --> ' . APP . 'Config';
                echoError($message);
            }


            // php version
            if (version_compare(phpversion(), 7 , '>=') && version_compare(phpversion(), 8.0, '<')) {
                $message = sprintf(__d('install', 'PHP version %s >= 7 and <8.0.0'), phpversion());
                echoMessage($message);
            } else {
                $check = false;
                $message = sprintf(__d('install', 'PHP version %s < 7 or =>8.0.0'), phpversion());
                echoError($message);
            }

            // php version
            $minCakeVersion = '2.10.24';
            $cakeVersion = Configure::version();
            if (version_compare($cakeVersion, $minCakeVersion, '>=')) {
                $message = __d('install', 'CakePhp version %s >= %s', $cakeVersion, $minCakeVersion);
                echoMessage($message);
            } else {
                $check = false;
                $message = __d('install', 'CakePHP version %s < %s', $cakeVersion, $minCakeVersion);
                echoError($message);
            }

           
            ?>
        </div>
    </div>
    <div class="install form">
        <?php echo $this->Form->create('Install', array('id' => 'settingsFrm')); ?>

        <fieldset>
            <legend><?php echo __d('install', 'pHKondo'); ?></legend>
            <div class="form-group">
                <?php
                echo $this->Form->input('mode', array('class' => 'form-control', 'label' => false, 'value' => Configure::read('Application.mode'), 'options' => $packList, 'empty' => '(choose one)'));
                ?>

            </div><!-- .form-group -->
            <legend><?php echo __d('install', 'Language'); ?></legend>
            <div class="form-group">
                <?php
                echo $this->Form->input('language', array('class' => 'form-control', 'label' => false, 'value' => Configure::read('Config.language'), 'options' => Configure::read('Language.list'), 'empty' => '(choose one)'));
                ?>

            </div><!-- .form-group -->

        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="row">
        <div class="install index">
            <?php
            if ($check) {
                $message = $this->Html->link(__d('install', 'Click here to begin installation'), array('action' => 'database'), ['class' => 'alert-link']);
                echoBeginMessage($message);
            } else {
                $message = __d('install', 'Installation cannot continue as minimum requirements are not found.');
                echoError($message);
            }
            ?>
        </div>
    </div>
</div>
<?php

function echoBeginMessage($message)
{
?>
    <div class="alert alert-info" role="alert">
        <?php echo $message; ?>
    </div>

<?php
}

function echoMessage($message)
{
?>
    <div class="alert alert-success" role="alert">
        <?php echo $message; ?>
    </div>
<?php
}

function echoError($message)
{
?>
    <div class="alert alert-error" role="alert">
        <?php echo $message; ?>
    </div> <?php
        }
            ?>