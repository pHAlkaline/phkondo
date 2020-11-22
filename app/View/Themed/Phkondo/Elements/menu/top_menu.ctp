<?php ?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".phkondo-navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="glyphicon glyphicon-th" ></span>

            </button>
            <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas">
                <span class="sr-only">Toggle options</span>
                <span class="glyphicon glyphicon-menu-hamburger" ></span>
            </button>

            <a class="navbar-brand" href="<?php echo Router::url(array('plugin'=>null,'controller' => 'pages', 'action' => 'home'), true); ?>">
                <?php echo $this->Html->image('logo_phkondo_flat.svg', array('alt' => 'pHKondo', 'style' => 'height:100%', 'class' => 'animate__animated animate__fadeIn')); ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <?php if ($this->Session->read('Auth.User') && !MaintenanceModeComponent::isOn()): ?>   
            <div class="collapse navbar-collapse phkondo-navbar navbar-right">

                <ul class="nav navbar-nav" style="padding: 0 10px 0 5px;">
                    <!--li><a href="#">Link</a></li-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Menu'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin' || AuthComponent::user('role') == 'colaborator') { ?>
                                <li>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> ' . __n('Condo', 'Condos', 2), array('plugin' => '', 'controller' => 'condos', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                            <?php } ?>
                            <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin') { ?>
                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-th"></span> ' . __('Income Control'), array('plugin' => '', 'controller' => 'income', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                            <?php } ?>
                            <li role="presentation" class="divider"></li>

                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span> ' . __('Quick Guide'), 'https://github.com/pHAlkaline/phkondo/wiki/Quick-Tutorial', array('target' => '_blank', 'escape' => false)); ?></li>

                        </ul>

                    </li>
                </ul>

                <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin') { ?>

                    <ul class="nav navbar-nav" style="padding: 0 10px 0 5px;">
                        <!--li><a href="#">Link</a></li-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Config'); ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <h6 class="dropdown-header"><?php echo __('General'); ?></h6>
                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> ' . __n('Entity', 'Entities', 2), array('plugin' => '', 'controller' => 'entities', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <li >

                                    <?php echo $this->Html->link('<span class="fa fa-truck"></span> ' . __n('Supplier', 'Suppliers', 2), array('plugin' => '', 'controller' => 'suppliers', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> ' . __('Fraction Types'), array('plugin' => '', 'controller' => 'fraction_types', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-asterisk"></span> ' . __('Insurance Types'), array('plugin' => '', 'controller' => 'insurance_types', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-warning-sign"></span> ' . __('Support Categories'), array('plugin' => '', 'controller' => 'support_categories', 'action' => 'index'), array('escape' => false)); ?>
                                </li>

                                <h6 class="dropdown-header"><?php echo __('Accounting'); ?></h6>

                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-book"></span> ' . __('Movement Categories'), array('plugin' => '', 'controller' => 'movement_categories', 'action' => 'index'), array('escape' => false)); ?>
                                </li>

                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> ' . __('Movement Operations'), array('plugin' => '', 'controller' => 'movement_operations', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <?php
                                $event = new CakeEvent('Phkondo.Draft.hasCondoDraft');
                                $this->getEventManager()->dispatch($event);
                                if (!is_null($event->result) && $event->result['hasCondoDraft'] === true) {
                                    ?>
                                    <h6 class="dropdown-header"><?php echo __n('Draft', 'Drafts', 2); ?></h6>
                                    <li ><?php echo $this->Html->link('<span class="fa fa-file-text"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => '', 'controller' => 'drafts', 'action' => 'index'), array('escape' => false)); ?></li>
                                <?php } else { ?>
                                    <li ><?php echo $this->Html->link('<span class="fa fa-file-text"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => '', 'controller' => 'pages', 'action' => 'drafts'), array('class' => 'btn ', 'escape' => false)); ?> </li>

                                <?php } ?>
                                <?php if (AuthComponent::user('role') == 'admin') { ?>
                                    <h6 class="dropdown-header"><?php echo __('Users'); ?></h6>
                                    <li >
                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> ' . __('Users'), array('plugin' => '', 'controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
                                    </li>
                                <?php } ?>
                            </ul>

                        </li>
                    </ul>
                <?php } ?>
                <ul class="nav navbar-nav" style="padding: 0 10px 0 5px;">
                    <!--li><a href="#">Link</a></li-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('User'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if (Configure::read('Application.mode') != 'demo'): ?>
                                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> ' . __('Reserved area'), array('plugin' => '', 'controller' => 'users', 'action' => 'profile'), array('escape' => false)); ?>
                                <?php endif; ?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-log-out"></span> ' . __('End Session'), array('plugin' => '', 'controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?>


                        </ul>

                    </li>
                </ul>



            </div><!-- /.navbar-collapse -->
        <?php endif; ?>
    </div><!-- /.container-fluid -->
</nav>