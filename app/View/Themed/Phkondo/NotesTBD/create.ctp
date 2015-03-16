<?php $this->Html->script('note_create', false); ?>
<?php
$totalShares = 0;
$totalMilRate = 0;
$budgetAmount = $budget['Budget']['amount'];

$common_reserve_fund = 0;
if ($budget ['Budget']['common_reserve_fund'] > 0) {
    $common_reserve_fund = $budgetAmount * ($budget ['Budget']['common_reserve_fund'] / 100);
    $budgetAmount = $budgetAmount - $common_reserve_fund;
}

$numOfShares = $budget ['Budget']['shares'];
$numOfFractions = count($fractions);
foreach ($fractions as $fraction) {
    $totalMilRate += $fraction['Fraction']['mil_rate'];
}
?>
<div id="page-container" class="row">
    <!--
        <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">
    
            <div class="actions">
    
                <ul class="nav nav-pills nav-stacked">
                    </li>"; ?>
                                </ul><!-- /.list-group ->
    
            </div><-- /.actions ->
    
        </div--><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-12">

        <div class="fractions index">

            <h2 class="col-sm-9"><?php echo __('Create Notes'); ?></h2>


            <?php echo $this->Form->create('Note'); ?>
            <?php echo $this->Form->hidden('Note.Budget.amount', array('value' => $budgetAmount)); ?>
            <?php echo $this->Form->hidden('Note.Budget.periodicity', array('value' => $budget['Budget']['share_periodicity_id'])); ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php echo h('Fraction'); ?></th>
                        <th><?php echo h('Description'); ?></th>
                        <th><?php echo h('Mil rate'); ?></th>
                        <th><?php echo h('Amount'); ?></th>
                        <th><?php echo h('Common Reserve Fund'); ?></th>
                        <th><?php echo h('Shares'); ?></th>
                        <th><?php echo h('Total'); ?></th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fractions as $key => $fraction): ?>
                        <?php echo $this->Form->hidden('Note.' . $key . '.fraction_id', array('value' => $fraction['Fraction']['id'])); ?>
                        <?php
                        switch ($budget['Budget']['share_distribution_id']) {
                            case 2:
                                $amountByShare = $budgetAmount * ($fraction['Fraction']['mil_rate'] / $totalMilRate) / $numOfShares;

                                if ($common_reserve_fund > 0) {
                                    $commonReserveFundByShare = $common_reserve_fund * ($fraction['Fraction']['mil_rate'] / $totalMilRate) / $numOfShares;
                                }
                                break;

                            default:
                                $amountByShare = $budgetAmount / $numOfShares / $numOfFractions;
                                if ($common_reserve_fund > 0) {
                                    $commonReserveFundByShare = $common_reserve_fund / $numOfShares / $numOfFractions;
                                }
                                break;
                        }

                        $amountByShare = $this->Number->precision($amountByShare, 2);
                        $commonReserveFundByShare = $this->Number->precision($commonReserveFundByShare, 2);
                        $total = $this->Number->precision($commonReserveFundByShare + $amountByShare * $numOfShares, 2);
                        $totalShares += $total;
                        ?>
                        <tr>
                            <td><?php echo h($fraction['Fraction']['fraction']); ?>&nbsp;</td>
                            <td><?php echo h($fraction['Fraction']['description']); ?>&nbsp;</td>
                            <td><?php echo h($fraction['Fraction']['mil_rate']); ?>&nbsp;</td>
                            <td><?php echo $this->Form->input('Note.' . $key . '.amount', array('value' => $amountByShare, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                            <td><?php echo $this->Form->input('Note.' . $key . '.common_reserve_fund', array('value' => $commonReserveFundByShare, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                            <td><?php echo $this->Form->input('Note.' . $key . '.shares', array('value' => $numOfShares, 'type' => 'text', 'data-type' => 'note', 'label' => false)); ?>&nbsp;</td>
                            <td><?php echo $this->Form->input('Note.' . $key . '.total', array('value' => $total, 'type' => 'text', 'disabled' => 'disabled', 'label' => false)); ?>&nbsp;</td>



                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="pull-right">
                <p><?php echo h('Total Budget: ') . $budgetAmount; ?></p>
                <p><?php echo h(' Total Notes: ') . '<span id="notesTotal">' . $this->Number->precision($totalShares, 2) . '</span>'; ?></p>
                <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
            </div>

            <?php echo $this->Form->end(); ?>



        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
