<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('note_create', false); ?>
<?php
$totalShares = 0;
$totalMilRate = 0;
$budgetAmount = $budget['Budget']['amount'];
$numOfShares = $budget ['Budget']['shares'];
$numOfFractions = count($fractions);
foreach ($fractions as $fraction) {
    $totalMilRate += $fraction['Fraction']['permillage'];
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Budget', 'Budgets', 1)), array('controller' => 'budgets', 'action' => 'view', $budget['Budget']['id'], '?' => $this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('List Budgets'), array('controller' => 'budgets', 'action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>
            </ul><!-- /.list-group -->
        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->
    <div id="page-content" class="col-sm-10">
        <?php
        if ($budget['Budget']['share_distribution_id'] == 2 && $totalMilRate <> 1000):
            ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo __('Warning: permillage sum should be 1000'); ?></div>

        <?php endif; ?>
        <div class="index">

            <legend><?php echo __('Create Notes'); ?></legend>


            <?php echo $this->Form->create('Note'); ?>
            <?php echo $this->Form->hidden('Note.Budget.amount', array('value' => $budgetAmount)); ?>
            <?php echo $this->Form->hidden('Note.Budget.notes.amount', array('value' => $budgetAmount)); ?>
            <?php echo $this->Form->hidden('Note.Budget.periodicity', array('value' => $budget['Budget']['share_periodicity_id'])); ?>
            <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo __n('Owner', 'Owners', 1); ?></th>
                            <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
                            <th data-breakpoints="xs"><?php echo __('Description'); ?></th>
                            <th data-breakpoints="xs"><?php echo __('permillage'); ?></th>
                            <th data-breakpoints="xs"><?php echo __('Amount'); ?></th>
                            <th data-breakpoints="xs"><?php echo __('Common Reserve Fund'); ?></th>
                            <th data-breakpoints="xs"><?php echo __n('Share', 'Shares', 2); ?></th>
                            <th><?php echo __('Total'); ?></th>
                            <th>&nbsp;</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $row = 0;
                        foreach ($fractions as $key => $fraction):
                            ?>
                            <?php foreach ($fraction['Entity'] as $keyEntity => $entity): ?>
                                <?php
                                if ($fraction['Fraction']['manager_id'] != null && $fraction['Fraction']['manager_id'] != $entity['id']) {
                                    continue;
                                }
                                $ownerPercentage = ($entity['EntitiesFraction']['owner_percentage'] / 100);
                                if ($fraction['Fraction']['manager_id'] != null) {
                                    $ownerPercentage = 1; // 1 = 100%
                                }
                                $ownerPercentage = $this->Number->precision($ownerPercentage, 2);
                                ?>
                                <?php echo $this->Form->hidden('Note.' . $row . '.fraction_id', array('value' => $fraction['Fraction']['id'])); ?>
                                <?php echo $this->Form->hidden('Note.' . $row . '.entity_id', array('value' => $entity['id'])); ?>
                                <?php
                                $commonReserveFundByShare = 0;
                                $amountByShare = 0;
                                switch ($budget['Budget']['share_distribution_id']) {
                                    case 2:
                                        if ($totalMilRate == 0 || $numOfShares == 0) {
                                            $amountByShare = 0;
                                        } else {
                                            $amountByShare = $budgetAmount * ($fraction['Fraction']['permillage'] / $totalMilRate) / $numOfShares;
                                        }
                                        break;

                                    default:
                                        $amountByShare = $budgetAmount / $numOfShares / $numOfFractions;
                                        break;
                                }
                                if ($budget ['Budget']['common_reserve_fund'] > 0) {
                                    $commonReserveFundByShare = $amountByShare * ($budget ['Budget']['common_reserve_fund'] / 100);
                                    $amountByShare = $amountByShare - $commonReserveFundByShare;
                                }
                                //debug($amountByShare);
                                $amountByShare = $this->Number->precision($amountByShare * $ownerPercentage, 2);
                                $commonReserveFundByShare = $this->Number->precision($commonReserveFundByShare * $ownerPercentage, 2);
                                $total = $this->Number->precision(($commonReserveFundByShare + $amountByShare) * $numOfShares, 2);
                                $totalShares += $total;
                                ?>
                                <tr>
                                    <td><?php echo h($entity['name']); ?>&nbsp;</td>
                                    <td><?php echo h($fraction['Fraction']['fraction']); ?>&nbsp;</td>
                                    <td><?php echo h($fraction['Fraction']['description']); ?>&nbsp;</td>
                                    <td><?php echo h($fraction['Fraction']['permillage']); ?>&nbsp;</td>
                                    <td data-type="html" data-editable="true"><?php echo $this->Form->input('Note.' . $row . '.amount', array('class' => 'form-control', 'value' => $amountByShare, 'type' => 'text', 'data-context' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td data-type="html" data-editable="true"><?php echo $this->Form->input('Note.' . $row . '.common_reserve_fund', array('class' => 'form-control', 'value' => $commonReserveFundByShare, 'type' => 'text', 'data-context' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td data-type="html" data-editable="true"><?php echo $this->Form->input('Note.' . $row . '.shares', array('class' => 'form-control', 'value' => $numOfShares, 'type' => 'text', 'data-context' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td data-type="html" ><?php echo $this->Form->input('Note.' . $row . '.total', array('class' => 'form-control', 'value' => $total, 'type' => 'text', 'disabled' => 'disabled', 'label' => false)); ?>&nbsp;</td>
                                    <td data-type="html" ><?php echo $this->Form->checkbox('Note.' . $row . '.selected', array('checked'=>'checked', 'value'=>'1', 'data-context' => 'disenline', 'label'=>false)); ?>&nbsp;</td>
                                </tr>
                                <?php
                                $row++;
                            endforeach;
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12">
                <div class="pull-right">
                    <?php
                    $pclass = "";
                    if ($this->Number->precision($totalShares, 2) != $this->Number->precision($budgetAmount, 2))
                        $pclass = 'text-danger';
                    ?>
                    <p class="<?php echo $pclass ?>"><?php echo ' ( '.__('Budget').' '.$this->Number->precision($budgetAmount, 2).' ) '.__('Total notes') . ': <span id="notesTotal">' . $this->Number->precision($totalShares, 2) .' </span>'; ?></p>
                    
                    <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>

            <?php echo $this->Form->end(); ?>



        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
