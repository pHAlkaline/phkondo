<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">
        <div class="display home text-center" >
            <?php if (!SubscriptionManagerComponent::isOn()) { ?>
            <h1><?php echo __('Subscription Expired'); ?></h1>
            <div class="alert alert-warning offline form">
                <p><?php echo __('This subscription has expired!'); ?></p>
                <p><?php echo __('Subscription started at %s ', Configure::read('SubscriptionManager.start')); ?></p>
                <p><?php echo __('Subscription expired after %s days', Configure::read('SubscriptionManager.duration')); ?></p>
                <p><?php echo __('It may be possible to restore access contacting us to report issue, or accessing %s ','<a target="_blank" href="https://phalkaline.gumroad.com/l/phkondocloud"> GUMROAD </a>'); ?></p>
            </div>
            <?php } else { ?>
            <span class="glyphicon glyphicon-tower" style="font-size: 1000%"></span>

            <h1><?php echo __('Subscription Active'); ?></h1>

            <div class="offline form">
                    <?php echo __('This subscription is back online, please refresh!'); ?>

            </div>

        </div>
        <?php } ?>

    </div>
</div>

