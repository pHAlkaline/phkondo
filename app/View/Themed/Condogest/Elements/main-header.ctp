<header class="main-header">
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Logo -->
                <a href="<?= Router::url('/', true); ?>" class="navbar-brand">
                    <b><?php echo Configure::read('Theme.owner_name'); ?></b>
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-home"></span> ' . __n('Condo', 'Condos', 2), array('plugin' => '', 'controller' => 'condos', 'action' => 'index'), array('escape' => false)); ?>
                    </li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <?php if (isset($keyword)) : ?>
                    <form class="navbar-form navbar-left" role="search" action="<?php echo $this->request->here; ?>">
                        <div class="form-group">
                            <input type="text" class="form-control"  name="keyword" onblur="if (this.value == '')
                                            this.value = '<?php echo __('Search'); ?>';" onfocus="if (this.value == '<?php echo __('Search'); ?>')
                                                        this.value = '';" value="<?php echo $keyword ?>" >
                        </div>
                    </form>
                <?php endif; ?>
                <ul class="nav navbar-nav ">
                    <?php if (AuthComponent::user('role') == 'admin' || AuthComponent::user('role') == 'store_admin') { ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('Admin'); ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">

                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-briefcase"></span> ' . __n('Entity', 'Entities', 2), array('plugin' => '', 'controller' => 'entities', 'action' => 'index'), array('escape' => false)); ?>
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
                                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-file"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => '', 'controller' => 'drafts', 'action' => 'index'), array('escape' => false)); ?></li>
                                <?php } else { ?>
                                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-file"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => '', 'controller' => 'pages', 'action' => 'drafts'), array('escape' => false)); ?> </li>
                                <?php } ?>
                                <li role="presentation" class="divider"></li>
                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-th"></span> ' . __('Income Control'), array('plugin' => '', 'controller' => 'income', 'action' => 'index'), array('escape' => false)); ?>
                                </li>
                                <li >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span> ' . __('Users'), array('plugin' => '', 'controller' => 'users', 'action' => 'index'), array('escape' => false)); ?>
                                </li>



                            </ul>
                        </li>
                    <?php } ?>
                    <li><?php echo $this->Html->link(__('End Session') . '&nbsp;&nbsp<span class="glyphicon glyphicon-log-out"></span> ', array('plugin' => '', 'controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?>


                </ul>

            </div><!-- /.navbar-collapse -->



        </div>
    </nav>
</header>