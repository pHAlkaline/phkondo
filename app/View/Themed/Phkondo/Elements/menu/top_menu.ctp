

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".phkondo-navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Router::url('/', true); ?>"><?= __('pHKondo').' - '.Configure::read('Theme.owner_name'); ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse phkondo-navbar">
            <?php if ($this->Session->read('Auth.User') && !MaintenanceModeComponent::isOn()): ?>

                <ul class="nav navbar-nav navbar-right" style="padding: 0 10px 0 5px;">
                    <!--li><a href="#">Link</a></li-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('MENU '); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin' || AuthComponent::user('role') == 'colaborator') { ?>
                                <li>

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> ' . __('Condos'), array('plugin' => '', 'controller' => 'condos', 'action' => 'index'), array('escape' => false)); ?>
                                </li>

                            <?php } ?>
                            <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin') { ?>
                                <li role="presentation" class="divider"></li>
                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-briefcase"></span> ' . __('Entities'), array('plugin' => '', 'controller' => 'entities', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                

                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-book"></span> ' . __('Movement Categories'), array('plugin' => '', 'controller' => 'movement_categories', 'action' => 'index'), array('escape' => false)); ?>
                                </li>

                                <li >

                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-cog"></span> ' . __('Movement Operations'), array('plugin' => '', 'controller' => 'movement_operations', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <?php
                                $event = new CakeEvent('Phkondo.Draft.hasCondoDraft');
                                $this->getEventManager()->dispatch($event);
                                if ($event->result['hasCondoDraft'] === true) {
                                    ?>
                                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-file"></span> ' . __('Drafts'), array('plugin' => '', 'controller' => 'drafts', 'action' => 'index'), array('escape' => false)); ?></li>
                                <?php } else { ?>
                                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-file"></span> ' . __('Drafts'), array('controller' => 'pages', 'action' => 'drafts'), array('class' => 'btn ', 'escape' => false)); ?> </li>

                                <?php } ?>
                                <?php if (AuthComponent::user('role') == 'admin') { ?>

                                    <li role="presentation" class="divider"></li>

                                    <li >

                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-th"></span> ' . __('Income Control'), array('plugin' => '', 'controller' => 'income', 'action' => 'index'), array('escape' => false)); ?>
                                    </li>

                                    <li >

                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> ' . __('Users'), array('plugin' => '', 'controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>

                            <li role="presentation" class="divider"></li>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-log-out"></span> ' . __('End Session'), array('plugin' => '', 'controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?>



                        </ul>

                    </li>
                </ul>

            <?php endif; ?>
            <?php if (isset($keyword)) : ?>
                <form method="get" class="navbar-form navbar-right" role="search" action="<?php echo $this->request->here; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control"  name="keyword" onblur="if (this.value == '')
                                        this.value = '<?php echo __('Search'); ?>';" onfocus="if (this.value == '<?php echo __('Search'); ?>')
                                                    this.value = '';" value="<?php echo $keyword ?>" >
                    </div>
                    <button type="submit" class="btn btn-default"><?php echo __('Search'); ?></button>
                </form>
            <?php endif; ?>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>