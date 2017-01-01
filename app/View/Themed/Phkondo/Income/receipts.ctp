<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('Income Control'), array('action' => 'index')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="receipts form">

            <?php
            echo $this->Form->create('IncomeReceipt', array('class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>',
                ),
                'novalidate' => true));
            ?>
            <fieldset>
                <legend><?php echo __n('Receipt','Receipts',2); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('status_id', array('empty' => __('All'), 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('open_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->
                 <div class="form-group">
                    <?php echo $this->Form->input('close_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->


            </fieldset>
             <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->submit(__('List'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>

            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

        <?php if (isset($receipts) && count($receipts)){ ?>
            <div class="index">

                <legend class="col-sm-9"><?php echo __n('Receipt','Receipts',2); ?></legend>

                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th><?php echo __('Paid To'); ?></th>
                                <th><?php echo __('Document'); ?></th>
                                <th><?php echo __('Document Date'); ?></th>
                                <th><?php echo __('Receipt Status'); ?></th>
                                <th><?php echo __('Payment Date'); ?></th>
                                <th><?php echo __('Receipt Payment Type'); ?></th>
                                <th><?php echo __('Client'); ?></th>
                                <th><?php echo __n('Condo','Condos',1); ?></th>
                                <th class="amount"><?php echo __('Amount'); ?></th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $amount_sum = 0;
                            $total_amount = 0;
                            ?>
                            <?php foreach ($receipts as $receipt): ?>
                                <?php
                                if ($receipt['Receipt']['receipt_status_id'] == 3) {
                                    $total_amount = $receipt['Receipt']['total_amount'];
                                    $amount_sum+=$total_amount;
                                } else {
                                    $total_amount = '( ' . $receipt['Receipt']['total_amount'] . ' )';
                                }
                                ?>
                                <tr>
                                    <td>

                                        <?php echo h($receipt['PaymentUser']['name']); ?>
                                    </td>
                                    <td><?php echo h($receipt['Receipt']['document']); ?>&nbsp;</td>

                                    <td><?php echo h( $receipt['Receipt']['document_date']); ?>&nbsp;</td>
                                    <td>

                                        <?php echo h($receipt['ReceiptStatus']['name']).' '.$receipt['CancelUser']['name']; ?>

                                    </td>
                                    <td><?php
                                        if ($receipt['Receipt']['payment_date'] != '') {
                                            echo h( $receipt['Receipt']['payment_date']);
                                        }
                                        ?>&nbsp;</td>
                                    <td>

                                        <?php echo h($receipt['ReceiptPaymentType']['name']); ?>
                                    </td>
                                    <td>
                                        <?php echo h($receipt['Client']['name']); ?>
                                    </td>
                                    <td>
                                        
                                        <?php echo h($receipt['Condo']['title']); ?>
                                    </td>
                                    
                                    <td class="amount"><?php echo h($total_amount); ?>&nbsp;<?php echo  Configure::read('currencySign'); ?></td>

                                </tr>
                            <?php endforeach; ?>
                            <tr>
<td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><strong><?php echo __('Total Amount'); ?></strong></td>
                                <td class="amount"><strong><?php echo h($amount_sum); ?>&nbsp;<?php echo  Configure::read('currencySign'); ?></strong></td>

                            </tr>
                        </tbody>
                    </table>
                </div>

            </div><!-- /.index -->
         <?php
    } elseif (isset($hasData) && $hasData==true) {
        ?>
            <div class="alert alert-info" role="alert"><?php echo  __('No records found.'); ?></div>
       
    <?php } ?>

    </div><!-- /#page-content .col-sm-9 -->


</div><!-- /#page-container .row-fluid -->
