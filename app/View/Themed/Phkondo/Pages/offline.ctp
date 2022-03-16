<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">
        <div class="display home text-center" >
            <?php if (MaintenanceModeComponent::isOn()) { ?>
                <span class="glyphicon glyphicon-tower" style="font-size: 1000%"></span>
                <h1><?php echo __('Application Offline'); ?></h1>
                <div class="alert alert-warning offline form">
                    <p><?php echo __('This application is now on maintenance mode, back soon as possible!'); ?></p>
                    <p><?php echo __('Maintenance start at %s ', Configure::read('MaintenanceMode.start')); ?></p>
                    <p><?php echo __('Maintenance duration %s Hours', Configure::read('MaintenanceMode.duration')); ?></p>

                </div>
            <?php } else { ?>
                <span class="glyphicon glyphicon-tower" style="font-size: 1000%"></span>

                <h1><?php echo __('Application Online'); ?></h1>

                <div class="offline form">
                    <?php echo __('This application is back online, please refresh!'); ?>

                </div>

            </div>
        <?php } ?>

    </div>
</div>

