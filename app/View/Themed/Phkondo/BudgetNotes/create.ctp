<?php $this->Html->script('note_create', false); ?>
<?php
$totalShares = 0;
$totalMilRate = 0;
$budgetAmount = $budget['Budget']['amount'];
$numOfShares = $budget ['Budget']['shares'];
$numOfFractions = count($fractions);
foreach ($fractions as $fraction) {
    $totalMilRate += $fraction['Fraction']['mil_rate'];
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s', __n('Budget','Budgets',1)), array('controller' => 'budgets', 'action' => 'view', $budget['Budget']['id'],'?'=>$this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('List Budgets'), array('controller' => 'budgets', 'action' => 'index','?'=>$this->request->query), array('class' => 'btn')); ?></li>
            </ul><!-- /.list-group -->
        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->
    <div id="page-content" class="col-sm-9">

        <div class="index">

            <legend><?php echo __('Create Notes'); ?></legend>


            <?php echo $this->Form->create('Note'); ?>
            <?php echo $this->Form->hidden('Note.Budget.amount', array('value' => $budgetAmount)); ?>
            <?php echo $this->Form->hidden('Note.Budget.notes.amount', array('value' => $budgetAmount)); ?>
            <?php echo $this->Form->hidden('Note.Budget.periodicity', array('value' => $budget['Budget']['share_periodicity_id'])); ?>
            <dvi class='clearfix'></dvi>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo __n('Owner','Owners',1); ?></th>
                            <th><?php echo __n('Fraction','Fractions',1); ?></th>
                            <th><?php echo __('Description'); ?></th>
                            <th><?php echo __('Mil rate'); ?></th>
                            <th><?php echo __('Amount'); ?></th>
                            <th><?php echo __('Common Reserve Fund'); ?></th>
                            <th><?php echo __n('Share','Shares',2); ?></th>
                            <th><?php echo __('Total'); ?></th>

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
                                        $amountByShare = $budgetAmount * ($fraction['Fraction']['mil_rate'] / $totalMilRate) / $numOfShares;
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
                                    <td><?php echo h($fraction['Fraction']['mil_rate']); ?>&nbsp;</td>
                                    <td><?php echo $this->Form->input('Note.' . $row . '.amount', array('class' => 'form-control', 'value' => $amountByShare, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td><?php echo $this->Form->input('Note.' . $row . '.common_reserve_fund', array('class' => 'form-control', 'value' => $commonReserveFundByShare, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td><?php echo $this->Form->input('Note.' . $row . '.shares', array('class' => 'form-control', 'value' => $numOfShares, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                                    <td><?php echo $this->Form->input('Note.' . $row . '.total', array('class' => 'form-control', 'value' => $total, 'type' => 'text', 'disabled' => 'disabled', 'label' => false)); ?>&nbsp;</td>
                                </tr>

                                <?php
                                $row++;
                            endforeach;
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="pull-right">
                <?php
                $pclass = "";
                if ($this->Number->precision($totalShares, 2) != $this->Number->precision($budgetAmount, 2))
                    $pclass = 'text-danger';
                ?>
                <p class="<?php echo $pclass ?>"><?php echo __('Total notes') . ': <span id="notesTotal">' . $this->Number->precision($totalShares, 2) . '</span>'; ?></p>
                <p><?php echo __('Budget amount') . ': ' . $this->Number->precision($budgetAmount, 2); ?></p>

                <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
            </div>

            <?php echo $this->Form->end(); ?>



        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
