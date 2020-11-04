<?php
$this->layout = 'welcome';
?>
<div class="row">

    <div class="centered text-center col-12">
        <a href="<?php echo Router::url(array('controller' => 'condos', 'action' => 'index')); ?>">
            <?php echo $this->Html->image('logo_phkondo_flat.svg', array('alt' => 'pHKondo', 'class' => 'img-responsive center-block animate__animated animate__zoomInDown animate__delay-1s')); ?>
        </a> 
        <h4 class="animate__animated animate__fadeIn animate__delay-2s"><?php echo __('Condominium / HOA Management'); ?></h4>
        <!--h5 class="animate__animated animate__fadeIn animate__delay-2s"><?php //echo __('Welcome'); ?></h5--> 
    </div>

</div>


