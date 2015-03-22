<?php
$has_fiscal_year = (isset($condo['FiscalYear'][0]['title'])) ? true : false;
?>
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Condo'), array('action' => 'edit', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false)); ?></li>
                <?php //if (AuthComponent::user('role') == 'admin'): ?>
                <li ><?php echo $this->Form->postLink(__('Delete Condo'), array('action' => 'delete', $condo['Condo']['id']), array('class' => 'btn ', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $condo['Condo']['title']))); ?> </li>
                <?php //endif; ?>
                <li ><?php echo $this->Html->link(__('List Condos'), array('action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Fiscal Years'), array('controller' => 'fiscal_years', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Administrators'), array('controller' => 'administrators', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Fractions'), array('controller' => 'fractions', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Budgets'), array('controller' => 'budgets', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Accounts'), array('controller' => 'accounts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Invoice Conference'), array('controller' => 'invoice_conference', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Receipts'), array('controller' => 'receipts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Maintenances'), array('controller' => 'maintenances', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Insurances'), array('controller' => 'insurances', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li class="divider">&nbsp;</li>
                <?php if ($has_fiscal_year): ?>
                    <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Reports'), array('controller' => 'reports', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php endif; ?>
                <?php
                $event = new CakeEvent('Phkondo.Draft.hasCondoDraft');
                $this->getEventManager()->dispatch($event);
                if ($event->result['hasCondoDraft']===true){ ?>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Drafts'), array('plugin'=>'drafts','controller' => 'condo_drafts', 'action' => 'index'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <?php } else { ?>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Drafts'), array('action' => 'drafts'), array('class' => 'btn ', 'escape' => false)); ?> </li>
                
                <?php } ?>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="condos view">

            <h2><?php echo __('Condo'); ?></h2>
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
                            <?php echo h($condo['Condo']['address']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['email']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Comments'); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['comments']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Fiscal Year'); ?></strong></td>
                        <td>
                            <?php if ($has_fiscal_year) {
                                echo h($condo['FiscalYear'][0]['title'] . ' ( ' . $this->Time->format(Configure::read('dateFormatSimple'), $condo['FiscalYear'][0]['open_date']) . ' a ' . $this->Time->format(Configure::read('dateFormatSimple'), $condo['FiscalYear'][0]['close_date']) . ' ) ');
                            } else {
                                echo '<div class="alert alert-warning">' . __('Deve activar um exercicio!!') . '</div>';
                            } ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
<?php echo $this->Time->format(Configure::read('dateFormat'), $condo['Condo']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>

                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->

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


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
