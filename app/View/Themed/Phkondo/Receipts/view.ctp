<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $editDisabled = '';
                $deleteDisabled = '';
                $payDisabled = '';
                $cancelDisabled = '';
                if (!$receipt['Receipt']['editable']) {
                    $editDisabled = ' disabled';
                }
                if (!$receipt['Receipt']['deletable']) {
                    $deleteDisabled = ' disabled';
                }
                if (!$receipt['Receipt']['payable']) {
                    $payDisabled = ' disabled';
                }
                if (!$receipt['Receipt']['cancelable']) {
                    $cancelDisabled = ' disabled';
                }
                ?>
                <li ><?php echo $this->Html->link(__('Edit Receipt'), array('action' => 'edit', $receipt['Receipt']['id'], '?' => $this->request->query), array('class' => 'btn ' . $editDisabled)); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Receipt'), array('action' => 'delete', $receipt['Receipt']['id'], '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $receipt['Receipt']['document']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Receipt'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Receipts'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Pay Receipt'), array('action' => 'pay_receipt', $receipt['Receipt']['id'], '?' => $this->request->query), array('class' => 'btn ' . $payDisabled, 'confirm' => __('Are you sure you want to set receipt # %s as paid? - Payment as %s', $receipt['Receipt']['document'], $receipt['ReceiptPaymentType']['name']))); ?></li>
                <li ><?php echo $this->Form->postLink(__('Cancel Receipt'), array('action' => 'cancel', $receipt['Receipt']['id'], '?' => $this->request->query), array('class' => 'btn ' . $cancelDisabled, 'confirm' => __('Are you sure you want to cancel # %s?', $receipt['Receipt']['document']))); ?> </li>
                <li ><?php echo $this->Html->link(__('Print Receipt'), array('action' => 'print_receipt', $receipt['Receipt']['id'], '?' => $this->request->query), array('target' => '_blank', 'class' => '', 'escape' => false)); ?> </li>
                <!--li ><?php //echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('New Notes'), array('action' => 'add_notes', $receipt['Receipt']['id']), array('class' => 'btn ' . $editDisabled, 'escape' => false));    ?> </li-->

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="receipts view">

            <legend><?php echo __n('Receipt', 'Receipts', 1); ?>&nbsp;<?php echo h($receipt['Receipt']['document']); ?>&nbsp;</legend>

            <section>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab"><?= __('Details'); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#notes" aria-controls="notes" role="tab" data-toggle="tab"><?= __n('Note', 'Notes', 2); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="details" aria-labelledby="details-tab">

 <br/>

                        <table class="table table-hover table-condensed">
                            <tbody>
                                <tr>
                                    <td class='col-sm-2'><strong><?php echo __('Document'); ?></strong></td>
                                    <td><?php echo h($receipt['Receipt']['document']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></td>
                                    <td><?php echo h($receipt['Fraction']['fraction']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Client'); ?></strong></td>
                                    <td><?php echo h($receipt['Client']['name']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Total Amount'); ?></strong></td>
                                    <td><?php echo h($receipt['Receipt']['total_amount']); ?>&nbsp;<?php echo Configure::read('currencySign'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Address'); ?></strong></td>
                                    <td><?php echo nl2br(h($receipt['Receipt']['address'])); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Document Date'); ?></strong></td>
                                    <td><?php echo h($receipt['Receipt']['document_date']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Receipt Status'); ?></strong></td>
                                    <td><?php echo h($receipt['ReceiptStatus']['name']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Receipt Payment Type'); ?></strong></td>
                                    <td><?php echo h($receipt['ReceiptPaymentType']['name']); ?>&nbsp;</td>
                                </tr>


                                <?php if ($receipt['Receipt']['receipt_status_id'] == 4) { ?>
                                    <tr>		<td><strong><?php echo __('Cancel Motive'); ?></strong></td>
                                        <td>
                                            <?php echo h($receipt['Receipt']['cancel_motive']); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>		
                                    <td><strong><?php echo __('Payment Date'); ?></strong></td>
                                    <td>
                                        <?php
                                        if ($receipt['Receipt']['payment_date'] != '') {
                                            echo h($receipt['Receipt']['payment_date']);
                                        }
                                        ?>
                                        &nbsp;
                                    </td>
                                </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                                    <td>
                                        <?php echo h($receipt['Receipt']['modified']); ?>
                                        &nbsp;
                                    </td>
                                </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                                    <td>
                                        <?php echo h($receipt['Receipt']['created']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>		<td><strong><?php echo __('Observations'); ?></strong></td>
                                    <td>
                                        <?php echo h($receipt['Receipt']['observations']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="notes" aria-labelledby="notes-tab">
                        <br/>
                        <?php
                        if (!empty($receipt['ReceiptNote'])) {
                            $receipt['Note'] = $receipt['ReceiptNote'];
                        }
                        ?>
                        <?php if (!empty($receipt['Note'])): ?>

                            <div class="row text-center loading">
                                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
                            </div>
                            <div class="col-sm-12 hidden">

                                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('Document'); ?></th>
                                            <th><?php echo __('Note Type'); ?></th>
                                            <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
                                            <th data-breakpoints="xs"><?php echo __('Document Date'); ?></th>
                                            <th data-breakpoints="xs"><?php echo __('Title'); ?></th>
                                            <th class="amount"><?php echo __('Amount'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($receipt['Note'] as $note):
                                            //debug($note);
                                            ?>
                                            <tr>
                                                <td><?php echo $note['document']; ?></td>
                                                <td><?php echo $note['NoteType']['name']; ?></td>
                                                <td><?php echo $note['Fraction']['fraction']; ?></td>
                                                <td><?php echo h($note['document_date']); ?></td>
                                                <td><?php echo $note['title']; ?></td>
                                                <td class="amount"><?php
                                                    if ($note['NoteType']['id'] == 1) {
                                                        echo '-';
                                                    }
                                                    echo $note['amount'];
                                                    ?>&nbsp;<?php echo Configure::read('currencySign'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><?php echo __('Total amount'); ?>&nbsp;:&nbsp;</td>
                                            <td class="amount"><?php echo number_format($receipt['Receipt']['total_amount'], 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?></td>


                                        </tr>
                                    </tbody>
                                </table><!-- /.table table-hover table-condensed -->
                            </div>    

                        <?php endif; ?>

                    </div>
                </div>
            </section>



        </div><!-- /.view -->



    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
