<?php $this->Html->script('condo_view', false); ?>
<?php
$has_fiscal_year = (isset($condo['FiscalYear'][0]['title'])) ? true : false;

$administrators = Set::extract('/Administrator/Entity/name', $condo);
$administrators = implode(", ", $administrators);

?>
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Condo'), array('action' => 'edit', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false)); ?></li>
                <?php if (in_array(AuthComponent::user('role'), array('admin','store_admin'))): ?>
                <li ><?php echo $this->Form->postLink(__('Delete Condo'), array('action' => 'delete', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $condo['Condo']['title']))); ?> </li>
                <?php endif; ?>
                <li ><?php echo $this->Html->link(__('List Condos'), array('action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Fraction', 'Fractions', 2), array('controller' => 'fractions', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Administrator', 'Administrators', 2), array('controller' => 'administrators', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Fiscal Year', 'Fiscal Years', 2), array('controller' => 'fiscal_years', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Receipt', 'Receipts', 2), array('controller' => 'receipts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Account', 'Accounts', 2), array('controller' => 'accounts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Invoice Conference'), array('controller' => 'invoice_conference', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Budget', 'Budgets', 2), array('controller' => 'budgets', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                <li class="divider">&nbsp;</li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Maintenance', 'Maintenances', 2), array('controller' => 'maintenances', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Insurance', 'Insurances', 2), array('controller' => 'insurances', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Attachment', 'Attachments', 2), array('controller' => 'attachments', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>

                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Reports'), array('controller' => 'reports', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                <?php
                $event = new CakeEvent('Phkondo.Draft.hasCondoDraft');
                $this->getEventManager()->dispatch($event);
                if ($event->result['hasCondoDraft'] === true) {
                    ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Draft', 'Drafts', 2), array('plugin' => 'drafts', 'controller' => 'condo_drafts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php } else { ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Draft', 'Drafts', 2), array('action' => 'drafts'), array('class' => 'btn ', 'escape' => false)); ?> </li>

                <?php } ?>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="condos view">

            <h2><?php echo __n('Condo', 'Condos', 1); ?></h2>
            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class="col-sm-2"><strong><?php echo __('Title'); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['title']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td class='col-sm-2'><strong><?php echo __('Taxpayer Number'); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['taxpayer_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Address'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($condo['Condo']['address'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Email'); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['email']); ?>
                            &nbsp;
                        </td>
                    </tr>

                <td><strong><?php echo __n('Fiscal Year', 'Fiscal Years', 1); ?></strong></td>
                <td>
                    <?php
                    if ($has_fiscal_year) {
                        echo h($condo['FiscalYear'][0]['title'] . ' ( ' . h($condo['FiscalYear'][0]['open_date']) . ' a ' . h($condo['FiscalYear'][0]['close_date']) . ' ) ');
                    } else {
                        echo '<div class="alert alert-warning">' . __('Please activate one fiscal year.') . '</div>';
                    }
                    ?>
                    &nbsp;
                </td>
                </tr>
                <tr>		
                    <td><strong><?php echo __n('Administrator', 'Administrator', 2); ?></strong></td>
                    <td><?= h($administrators); ?>&nbsp;</td>
                </tr>
                <tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                    <td>
                        <?php echo h($condo['Condo']['created']); ?>
                        &nbsp;
                    </td>
                </tr>


                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->
        <div class="clearfix content-action-menu pull-right">
            <?php echo $this->Html->link('<span class="glyphicon glyphicon-comment"></span> ', '#', array('title' => __('View %s', __('Comments')), 'id' => 'viewCommentsBtn', 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
        </div>
        <div class="clearfix comments hide">
        <?php echo $this->Comments->display_for($condo); ?>
        </div>
        <div class="clearfix"><br/><br/></div>
        <div >
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
            <div class="alert alert-danger"><?php echo __('Expired insurance'); ?></div>
        <?php elseif (in_array('warning', $viewGlyphiconState)) : ?>
            <div class="alert alert-warning"><?php echo __('Insurance to expire soon'); ?></div>
        <?php elseif (in_array('info', $viewGlyphiconState)) : ?>
            <div class="alert alert-info"><?php echo __('Insurance to expire soon'); ?></div>
        <?php endif; ?>

        <?php
        $viewGlyphiconState = array();
        foreach ($condo['Maintenance'] as $maintenance) {
            if ($maintenance['expire_out'] > -30) {
                $viewGlyphiconState[] = 'info';
            }
            if ($maintenance['expire_out'] > -15) {
                $viewGlyphiconState[] = 'warning';
            }
            if ($maintenance['expire_out'] > 0) {
                $viewGlyphiconState[] = 'danger';
            }
            if ($maintenance['next_inspection_out'] > -30) {
                $viewGlyphiconState[] = 'info';
            }
            if ($maintenance['next_inspection_out'] > -15) {
                $viewGlyphiconState[] = 'warning';
            }
            if ($maintenance['next_inspection_out'] > 0) {
                $viewGlyphiconState[] = 'danger';
            }
        }
        ?>
        <?php if (in_array('danger', $viewGlyphiconState)) : ?>
            <div class="alert alert-danger"><?php echo __('Expired maintenance'); ?></div>
        <?php elseif (in_array('warning', $viewGlyphiconState)) : ?>
            <div class="alert alert-warning"><?php echo __('Maintenance to expire soon'); ?></div>
        <?php elseif (in_array('info', $viewGlyphiconState)) : ?>
            <div class="alert alert-info"><?php echo __('Maintenance to expire soon'); ?></div>
        <?php endif; ?>

        <?php if ($hasSharesDebt) : ?>
            <div class="alert alert-danger"><?php echo __('Fractions with late payment'); ?></div>
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
            <div class="alert alert-danger"><?php echo __('Accounts with negative balance'); ?></div>
        <?php endif; ?>
        <?php if ($hasDebt) : ?>
            <div class="alert alert-danger"><?php echo __('Suppliers with arrears'); ?></div>
        <?php endif; ?>
        </div>
    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
