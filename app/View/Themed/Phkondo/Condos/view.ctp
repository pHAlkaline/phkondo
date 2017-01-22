<?php

$this->Html->script('condo_view', false); ?>
<?php
$has_fiscal_year = (isset($condo['FiscalYear'][0]['title'])) ? true : false;

$administrators = Set::extract('/Administrator/Entity/name', $condo);
$administrators = implode(", ", $administrators);
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked nav-stacked">			
                    <li ><?php echo $this->Html->link(__('Edit Condo'), array('action' => 'edit', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false)); ?></li>
                <?php if (in_array(AuthComponent::user('role'), array('admin', 'store_admin'))): ?>
                    <li ><?php echo $this->Form->postLink(__('Delete Condo'), array('action' => 'delete', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $condo['Condo']['title']))); ?> </li>
                <?php endif; ?>
                    <li ><?php echo $this->Html->link(__('List Condos'), array('action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li class="divider">&nbsp;</li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Fraction', 'Fractions', 2), array('controller' => 'fractions', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Administrator', 'Administrators', 2), array('controller' => 'administrators', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>

                    <li class="divider">&nbsp;</li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Fiscal Year', 'Fiscal Years', 2), array('controller' => 'fiscal_years', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Account', 'Accounts', 2), array('controller' => 'accounts', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Invoice Conference'), array('controller' => 'invoice_conference', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Budget', 'Budgets', 2), array('controller' => 'budgets', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Receipt', 'Receipts', 2), array('controller' => 'receipts', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li class="divider">&nbsp;</li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Support', 'Supports', 2), array('controller' => 'supports', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Maintenance', 'Maintenances', 2), array('controller' => 'maintenances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Insurance', 'Insurances', 2), array('controller' => 'insurances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li class="divider">&nbsp;</li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Attachment', 'Attachments', 2), array('controller' => 'attachments', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>

                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Reports'), array('controller' => 'reports', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                <?php
                $event = new CakeEvent('Phkondo.Draft.hasCondoDraft');
                $this->getEventManager()->dispatch($event);
                if ($event->result['hasCondoDraft'] === true) {
                    ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => 'drafts', 'controller' => 'condo_drafts', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php } else { ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Draft', 'Drafts', 2), array('action' => 'drafts','?'=>array('condo_id'=>$condo['Condo']['id'])), array('class' => 'btn ', 'escape' => false)); ?> </li>

                <?php } ?>

                </ul><!-- /.list-group -->

        </div><!-- /#sidebar .actions -->
    </div>
    <div id="page-content" class="col-sm-9">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading"><strong><?php echo __n('Condo', 'Condos', 1); ?></strong></div>
            <div class="panel-body">

                <dl class="dl-horizontal">

                    <dt><strong><?php echo __('Title'); ?></strong></dt>
                    <dd><?php echo h($condo['Condo']['title']); ?>&nbsp;</dd>

                    <dt><strong><?php echo __('Taxpayer Number'); ?></strong></dt>
                    <dd>
                        <?php echo h($condo['Condo']['taxpayer_number']); ?>
                        &nbsp;
                    </dd>
                    <dt><strong><?php echo __('Address'); ?></strong></dt>
                    <dd>
                        <?php echo nl2br(h($condo['Condo']['address'])); ?>
                        &nbsp;
                    </dd>
                    <dt><strong><?php echo __('Email'); ?></strong></dt>
                    <dd>
                        <?php echo h($condo['Condo']['email']); ?>
                        &nbsp;
                    </dd>

                    <dt><strong><?php echo __('Matrix Registration'); ?></strong></dt>
                    <dd><?php echo h($condo['Condo']['matrix_registration']); ?>&nbsp;</dd>
                    <dt><strong><?php echo __('Land Registry'); ?></strong></dt>
                    <dd><?php echo h($condo['Condo']['land_registry']); ?>&nbsp;</dd>
                    <dt><strong><?php echo __('Land Registry Year'); ?></strong></dt>
                    <dd><?php echo h($condo['Condo']['land_registry_year']); ?>&nbsp;</dd>
                    <dt><strong><?php echo __n('Fiscal Year', 'Fiscal Years', 1); ?></strong></dt>
                    <dd>
                        <?php
                        if ($has_fiscal_year) {
                            echo h($condo['FiscalYear'][0]['title'] . ' ( ' . h($condo['FiscalYear'][0]['open_date']) . ' a ' . h($condo['FiscalYear'][0]['close_date']) . ' ) ');
                        } else {
                            echo '<div class="alert alert-warning">' . __('Please activate one fiscal year.') . '</div>';
                        }
                        ?>
                        &nbsp;
                    </dd>

                    <dt><strong><?php echo __n('Administrator', 'Administrator', 2); ?></strong></dt>
                    <dd><?php echo h($administrators); ?>&nbsp;</dd>
                    <dt><strong><?php echo __('Comments'); ?></strong></dt>
                    <dd><?php echo h($condo['Condo']['comments']); ?>&nbsp;</dd>
                    <dt><strong><?php echo __('Created'); ?></strong></dt>
                    <dd>
                        <?php echo h($condo['Condo']['created']); ?>
                        &nbsp;
                    </dd>





                </dl>

            </div><!-- /.view -->
        </div>
        <div class="panel panel-default" id="CommentsPanel">
            <!-- Default panel contents -->
            <div class="panel-heading"  data-toggle="collapse" data-target="#CommentsIndex"><strong><?php echo __('Comments'); ?></strong> 
                <div class="clearfix content-action-menu pull-right">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-down"></span> ', '#CommentsPanel', array('title' => __('View %s', __('Comments')), 'id' => 'viewCommentsBtn', 'class' => ' ', 'escape' => false)); ?>
                </div>
            </div>
            <div class="panel-body collapse" id="CommentsIndex">

                <?php echo $this->Comments->display_for($condo); ?>

            </div>

        </div>
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading" data-toggle="collapse" data-target="#AlertsIndex"><strong><?php echo __('Alerts'); ?></strong> 
                <div class="clearfix content-action-menu pull-right">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-down"></span> ', '#AlertsIndex', array('title' => __('View %s', __('Alerts')), 'id' => 'viewAlertsBtn', 'class' => ' ', 'escape' => false)); ?>
                </div>
            </div>
            <div class="panel-body collapse" id="AlertsIndex">

                <?php
                $viewGlyphiconState = array();
                foreach ($condo['Insurance'] as $insurance) {

                    if ($insurance['expire_out'] > -30) {

                        $viewGlyphiconState[] = 'info';
                    }
                    if ($insurance['expire_out'] > -15) {
                        $viewGlyphiconState[] = 'warning';
                    }
                    if ($insurance['expire_out'] > 0) {
                        $viewGlyphiconState[] = 'danger';
                    }
                }
                ?>
                <?php if (in_array('danger', $viewGlyphiconState)) : ?>
                <div class="alert alert-danger">
                        <?php echo $this->Html->link(__('Expired insurance'), array('controller' => 'insurances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Expired insurance'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php elseif (in_array('warning', $viewGlyphiconState)) : ?>
                <div class="alert alert-warning">
                        <?php echo $this->Html->link(__('Insurance to expire soon'), array('controller' => 'insurances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Insurance to expire soon'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php elseif (in_array('info', $viewGlyphiconState)) : ?>
                <div class="alert alert-info">
                        <?php echo $this->Html->link(__('Insurance to expire soon'), array('controller' => 'insurances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Insurance to expire soon'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php endif; ?>

                <?php
                $viewGlyphiconState = array();
                foreach ($condo['Maintenance'] as $maintenance) {
                    if ($maintenance['expire_out'] > -10) {
                        $viewGlyphiconState[] = 'info';
                    }
                    if ($maintenance['expire_out'] > -5) {
                        $viewGlyphiconState[] = 'warning';
                    }
                    if ($maintenance['expire_out'] > 0) {
                        $viewGlyphiconState[] = 'danger';
                    }
                    if ($maintenance['next_inspection_out'] > -10) {
                        $viewGlyphiconState[] = 'info';
                    }
                    if ($maintenance['next_inspection_out'] > -5) {
                        $viewGlyphiconState[] = 'warning';
                    }
                    if ($maintenance['next_inspection_out'] > 0) {
                        $viewGlyphiconState[] = 'danger';
                    }
                }
                ?>
                <?php if (in_array('danger', $viewGlyphiconState)) : ?>
                <div class="alert alert-danger">
                        <?php echo $this->Html->link(__('Expired maintenance'), array('controller' => 'maintenances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Expired maintenance'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php elseif (in_array('warning', $viewGlyphiconState)) : ?>
                <div class="alert alert-warning">
                        <?php echo $this->Html->link(__('Maintenance to expire soon'), array('controller' => 'maintenances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Maintenance to expire soon'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php elseif (in_array('info', $viewGlyphiconState)) : ?>
                <div class="alert alert-info">
                        <?php echo $this->Html->link(__('Maintenance to expire soon'), array('controller' => 'maintenances', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Maintenance to expire soon'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php endif; ?>

                <?php if ($hasSharesDebt) : ?>
                <div class="alert alert-danger">
                        <?php echo $this->Html->link(__('Fractions with late payment'), array('controller' => 'fractions', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Fractions with late payment'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>
                </div>
                <?php endif; ?>

                <?php
                $viewGlyphiconState = array();
                foreach ($condo['Account'] as $account) {
                    if ($account['balance'] < 0) {
                        $viewGlyphiconState[] = 'danger';
                    }
                }
                ?>
                <?php if (in_array('danger', $viewGlyphiconState)) : ?>
                <div class="alert alert-danger">
                        <?php echo $this->Html->link(__('Accounts with negative balance'), array('controller' => 'accounts', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Accounts with negative balance'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>


                </div>
                <?php endif; ?>
                <?php if ($hasDebt) : ?>
                <div class="alert alert-danger">
                        <?php echo $this->Html->link(__('Suppliers with arrears'), array('controller' => 'invoice_conference', 'action' => 'index','?'=>array('condo_id'=>$condo['Condo']['id'])), array('title' => __('Suppliers with arrears'), 'class' => '', 'style' => 'color:inherit;', 'escape' => false)); ?>

                </div>
                <?php endif; ?>

            </div>
        </div>
    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
