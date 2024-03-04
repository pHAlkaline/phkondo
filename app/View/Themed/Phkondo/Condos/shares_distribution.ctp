<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('shares_distribution', false); ?>
<?php
$has_fiscal_year = (isset($condo['FiscalYear'][0]['title'])) ? true : false;
$totalShares = 0;
$totalMilRate = 0;
$sharesAmount = isset($this->request->data['Note']['amount']) ? $this->request->data['Note']['amount'] : 0;
$numOfShares = isset($this->request->data['Note']['shares']) ? $this->request->data['Note']['shares'] : 0;
$numOfFractions = count($fractions);
foreach ($fractions as $fraction) {
    $totalMilRate += $fraction['Fraction']['permillage'];
}
        
Configure::load('email_notifications');
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">
                <li><?php echo $this->Html->link(__('View %s', __n('Condo', 'Condos', 1)), array('action' => 'view', $condo['Condo']['id']), array('class' => 'btn')); ?></li>
                <li><?php echo $this->Html->link(__('List Condos'), array('controller' => 'condos', 'action' => 'index'), array('class' => 'btn')); ?></li>
            </ul><!-- /.list-group -->
        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->
    <div id="page-content" class="col-sm-10">
        <?php
        if (isset($this->request->data['Note']['share_distribution_id']) && $this->request->data['Note']['share_distribution_id'] == 2 && $totalMilRate <> 1000) :
        ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo __('Warning: permillage sum should be 1000'); ?>
            </div>

        <?php endif; ?>
        <div class="index">

            <legend><?php echo __('Create Notes'); ?></legend>
            <br />

            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>
                        <td class='col-sm-2'><strong><?php echo __n('Condo', 'Condos', 1); ?></strong></td>
                        <td>
                            <?php echo h($condo['Condo']['title']); ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __n('Fiscal Year', 'Fiscal Years', 1); ?></strong></td>
                        <td>
                            <?php
                            if ($has_fiscal_year) {
                                echo h($condo['FiscalYear'][0]['title'] . ' ( ' . h($condo['FiscalYear'][0]['open_date']) . ' a ' . h($condo['FiscalYear'][0]['close_date']) . ' ) ');
                            }
                            ?>
                            &nbsp;

                        </td>
                    </tr>

                </tbody>
            </table><!-- /.table table-hover table-condensed -->

            <div class="shares_distribution form">
                <?php echo $this->Form->create('Note', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
                <?php echo $this->Form->hidden('calculate', array('value' => '1')); ?>

                <fieldset>
                    <div class="form-group">
                        <?php echo $this->Form->input('title', array('class' => 'form-control', 'type' => 'text', 'required' => 'required')); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <?php echo $this->Form->input('amount', array('class' => 'form-control', 'type' => 'number', 'min' => '1',  'step' => '0.01', 'required' => 'required')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('begin_date', array(
                            'required' => 'required',
                            'type' => 'text',
                            'class' => 'form-control datefield',
                            'data-date-start-date' => $condo['FiscalYear'][0]['open_date'],
                            'data-date-end-date' => $condo['FiscalYear'][0]['close_date']
                        ));
                        ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <?php echo $this->Form->input('shares', array('type' => 'number', 'required' => 'required', 'min' => 1, 'max'=>104, 'label' => ['text' => __n('Share', 'Shares', 2).' '.__('Qnt'), 'class' => 'col-sm-2 control-label'], 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <?php echo $this->Form->input('share_periodicity_id', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <?php echo $this->Form->input('share_distribution_id', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <?php echo $this->Form->input('due_days', array('required' => 'required', 'class' => 'form-control', 'type' => 'number', 'min' => 0)); ?>
                    </div><!-- .form-group -->
                </fieldset>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <?php echo $this->Form->button(__('Calculate'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>

            </div>
            <hr />
            <?php if (isset($this->request->data['Note'])) : ?>
                <p>&nbsp;</p>
                <div class="row text-center loading">
                    <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
                </div>
                <?php echo $this->Form->create('Note'); ?>
                <?php echo $this->Form->hidden('calculate', array('value' => '0')); ?>
                <?php echo $this->Form->hidden('title'); ?>
                <?php echo $this->Form->hidden('amount'); ?>
                <?php echo $this->Form->hidden('begin_date'); ?>
                <?php echo $this->Form->hidden('shares'); ?>
                <?php echo $this->Form->hidden('share_periodicity_id'); ?>
                <?php echo $this->Form->hidden('share_distribution_id'); ?>
                <?php echo $this->Form->hidden('due_days'); ?>

                <div class="col-sm-12 hidden">

                    <table data-empty="<?= __('Empty'); ?>" class="footable table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th><?php echo __n('Entity', 'Entities', 1); ?></th>
                                <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Description'); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Permillage'); ?></th>
                                <th data-breakpoints="xs"><?php echo __('Amount'); ?></th>
                                <th data-breakpoints="xs"><?php echo __n('Share', 'Shares', 2); ?></th>
                                <th><?php echo __('Total'); ?></th>
                                <th style="text-align: center; vertical-align:middle;"><?php echo $this->Form->checkbox('NoteSelection', array('checked' => 'checked', 'value' => '1', 'data-context' => 'disenalllines', 'label' => false)); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $row = 0;
                            foreach ($fractions as $key => $fraction) :
                            ?>
                                <?php foreach ($fraction['Entity'] as $keyEntity => $entity) : ?>
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
                                    switch ($this->request->data['Note']['share_distribution_id']) {
                                        case 2:
                                            if ($totalMilRate == 0 || $numOfShares == 0) {
                                                $amountByShare = 0;
                                            } else {
                                                $amountByShare = $sharesAmount * ($fraction['Fraction']['permillage'] / $totalMilRate) / $numOfShares;
                                            }
                                            break;

                                        default:
                                            $amountByShare = $sharesAmount / $numOfShares / $numOfFractions;
                                            break;
                                    }
                                    //debug($amountByShare);
                                    $amountByShare = $this->Number->precision($amountByShare * $ownerPercentage, 2);
                                    $total = $this->Number->precision($amountByShare * $numOfShares, 2);
                                    $totalShares += $total;
                                    ?>
                                    <tr>
                                        <td style="text-align: center; vertical-align:middle;"><?php echo h($entity['name']); ?>&nbsp;</td>
                                        <td style="text-align: center; vertical-align:middle;"><?php echo h($fraction['Fraction']['fraction']); ?>&nbsp;</td>
                                        <td style="text-align: center; vertical-align:middle;"><?php echo h($fraction['Fraction']['description']); ?>&nbsp;</td>
                                        <td style="text-align: center; vertical-align:middle;"><?php echo h($fraction['Fraction']['permillage']); ?>&nbsp;</td>
                                        <td data-type="html" data-editable="true"><?php echo $this->Form->input('Note.' . $row . '.amount', array('class' => 'form-control', 'value' => $amountByShare, 'type' => 'text', 'data-context' => 'note', 'label' => false)); ?>&nbsp;</td>
                                        <td data-type="html" data-editable="true"><?php echo $this->Form->input('Note.' . $row . '.shares', array('class' => 'form-control', 'value' => $numOfShares, 'type' => 'text', 'data-context' => 'note', 'label' => false)); ?>&nbsp;</td>
                                        <td data-type="html"><?php echo $this->Form->input('Note.' . $row . '.total', array('class' => 'form-control', 'value' => $total, 'type' => 'text', 'disabled' => 'disabled', 'label' => false)); ?>&nbsp;</td>
                                        <td data-type="html" style="text-align: center; vertical-align:middle;"><?php echo $this->Form->checkbox('Note.' . $row . '.selected', array('checked' => 'checked', 'value' => '1', 'data-context' => 'disenline', 'label' => false)); ?>&nbsp;</td>
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
                        if ($this->Number->precision($totalShares, 2) != $this->Number->precision($sharesAmount, 2))
                            $pclass = 'text-danger';
                        ?>
                        <p class="<?php echo $pclass ?>"><?php echo ' ( ' . __('Amount') . ' ' . $this->Number->precision($sharesAmount, 2) . ' ) ' . __('Total notes') . ': <span id="notesTotal">' . $this->Number->precision($totalShares, 2) . ' </span>'; ?></p>

                        <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                    </div>
                </div>

                <?php echo $this->Form->end(); ?>
            <?php endif; ?>


        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->