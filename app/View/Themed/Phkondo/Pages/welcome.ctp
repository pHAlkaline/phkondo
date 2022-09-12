<?php

$this->layout = 'welcome';
$url= AuthComponent::user('id') ? array('controller' => 'condos', 'action' => 'index') : array('controller' => 'users', 'action'=>'login');
if (!file_exists(TMP . 'installed.txt') || Configure::read('installed_key') == 'xyz') {
    $url= array('controller' => 'install', 'action' => 'index');
}
?>
<div class="row">
    <div class="centered text-center col-12">
        <a href="<?php echo Router::url($url); ?>" id="go-pHKondo">
            <?php echo $this->Html->image('logo_phkondo_flat.png', array('alt' => 'pHKondo', 'class' => 'img-responsive center-block animate__animated animate__zoomInDown animate__delay-1s')); ?>
        </a> 
        <h4 class="animate__animated animate__fadeIn animate__delay-2s"><?php echo __('Condominium / HOA Management'); ?></h4>
        <!--h5 class="animate__animated animate__fadeIn animate__delay-2s"><?php //echo __('Welcome'); ?></h5--> 
    </div>
</div>


