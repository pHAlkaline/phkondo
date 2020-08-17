<?php
$this->layout = 'welcome';
?>
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        /* bring your own prefixes */
        transform: translate(-50%, -50%);
    }
</style>

<div class="centered text-center">
    <a href="<?php echo Router::url(array('controller' => 'condos', 'action' => 'index')); ?>">
        <?php echo $this->Html->image('logo_phkondo_flat.svg', array('alt' => 'pHKondo', 'class' => 'animate__animated animate__zoomInDown animate__delay-1s')); ?>
    </a> 
    <h1 class="animate__animated animate__fadeIn animate__delay-2s"><?php echo __('Condominium Management Software'); ?></H1>
    <h2 class="animate__animated animate__fadeIn animate__delay-2s"><?php echo __('Welcome'); ?></h2> 
</div>


