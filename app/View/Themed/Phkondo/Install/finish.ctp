<h2><?php echo $title_for_step; ?></h2>
<div id="page-content" class="col-sm-10">

    <div class="install form">
        <div class = "row">
            <div class="alert alert-info" role="alert">

                <?php
                echo __d('install', 'Dont forget to restore default access values to Config and tmp directory.');
                ?>
            </div>
            <div class="alert alert-info" role="alert">

                <?php echo __d('install', 'Passwords secured and updated for all users');
                ?>
            </div>
            <div class="alert alert-info" role="alert">

                <?php echo __d('install', 'pHKondo: %s', $this->Html->link(Router::url('/', true), Router::url('/', true))); ?>
            </div>
        </div>

        <div class = "row">
            <h3><?php echo __d('install', 'Resources'); ?></h3>
            <ul >
                <li><?php echo $this->Html->link('Official', 'https://phkondo.net', array('target' => '_blank')); ?></li>
                <li><?php echo $this->Html->link('Wiki', 'http://github.com/pHAlkaline/phkondo/wiki', array('target' => '_blank')); ?></li>
                <li><?php echo $this->Html->link('pHKondo Google Group', 'http://groups.google.com/group/phkondo', array('target' => '_blank')); ?></li>
                <li><?php echo $this->Html->link('Code repository', 'http://github.com/phalkaline/phkondo', array('target' => '_blank')); ?></li>


        </div>
    </div>


</div>
