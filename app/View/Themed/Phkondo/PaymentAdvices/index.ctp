<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<?php $this->Html->script('libs/table2csv/table2csv.min', false); ?>
<?php $this->Html->script('table2csv', false); ?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Payment Advice', 'Payment Advices', 2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('Generate All'), array('action' => 'generate', '?' => $this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 2px; float: right;', 'escape' => false)); ?>
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false)); ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool_payment_advices'); ?>
            <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>" class="footable table table-hover table-condensed table-export">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('document'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('document_date'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('Fraction.fraction', __n('Fraction', 'Fractions', 1)); ?></th>
                            <th><?php echo $this->Paginator->sort('Entity.name', __n('Entity', 'Entities', 1)); ?></th>
                            <!--th data-breakpoints="xs"><?php //echo $this->Paginator->sort('Status.name',__('Status')); ?></th-->
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('PaymentType.name', __('Payment Type')); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('payment_date'); ?></th>
                            <th class="amount"><?php echo $this->Paginator->sort('total_amount'); ?></th>
                            <th data-breakpoints="xs" class="actions hidden-print"><?php //echo __('Actions'); 
                                                                                    ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payment_advices as $payment_advice) : ?>
                            <tr>
                                <td style="white-space:nowrap;"><?php echo h($payment_advice['PaymentAdvice']['document']); ?>&nbsp;</td>

                                <td><?php echo h($payment_advice['PaymentAdvice']['document_date']); ?>&nbsp;</td>
                                <td>
                                    <?php echo h($payment_advice['Fraction']['fraction']); ?>
                                </td>
                                <td>
                                    <?php echo h($payment_advice['Entity']['name']); ?>
                                </td>
                                <td>
                                    <?php echo h($payment_advice['PaymentType']['name']); ?>
                                </td>
                                <td><?php
                                    if ($payment_advice['PaymentAdvice']['payment_date'] != '') {
                                        echo h($payment_advice['PaymentAdvice']['payment_date']);
                                    } ?>&nbsp;</td>

                                <td class="amount"><?php echo number_format($payment_advice['PaymentAdvice']['total_amount'], 2); ?>&nbsp;<?php echo  Configure::read('Application.currencySign'); ?></td>
                                <td class="actions hidden-print">
                                    <?php
                                    $editDisabled = '';
                                    $deleteDisabled = '';
                                    $payDisabled = '';
                                    $cancelDisabled = '';
                                    /*if (!$payment_advice['PaymentAdvice']['editable']){
                                        $editDisabled=' disabled';
                                    }
                                    if (!$payment_advice['PaymentAdvice']['deletable']){
                                        $deleteDisabled=' disabled';
                                    }*/
                                    if (!$payment_advice['PaymentAdvice']['payable']) {
                                        $payDisabled = ' disabled';
                                    }
                                    /*if (!$payment_advice['PaymentAdvice']['cancelable']){
                                        $cancelDisabled=' disabled';
                                    }*/


                                    ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $payment_advice['PaymentAdvice']['id'], '?' => $this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $payment_advice['PaymentAdvice']['id'], '?' => $this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs ' . $editDisabled, 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $payment_advice['PaymentAdvice']['id'], '?' => $this->request->query), array('title' => __('Delete'), 'class' => 'btn btn-default btn-xs ' . $deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $payment_advice['PaymentAdvice']['document']))); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-euro"></span> ', array('controller' => 'Receipts', 'action' => 'addFromPaymentAdvice', $payment_advice['PaymentAdvice']['id'], '?' => $this->request->query), array('title' => __('Create Receipt'), 'target'=>'_blank','class' => 'btn btn-default btn-xs ' . $payDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to set paymentAdvice # %s as paid? - Payment as %s', $payment_advice['PaymentAdvice']['document'], $payment_advice['PaymentType']['name']))); ?>
                                    <!--?php //echo $this->Form->postLink('<span class="glyphicon glyphicon-ban-circle"></span> ', array('action' => 'cancel', $payment_advice['PaymentAdvice']['id'],'?'=>$this->request->query), array('title' => __('Cancel'), 'class' => 'btn btn-default btn-xs '.$cancelDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to cancel # %s?', $payment_advice['PaymentAdvice']['document']))); ?-->
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-save-file"></span> ', array('action' => 'print', $payment_advice['PaymentAdvice']['id'], 'ext' => 'pdf', '?' => $this->request->query), array('target' => '_blank', 'title' => __('Print'), 'class' => 'btn btn-default btn-xs', 'escape' => false)) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class='pull-right'><small>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                    ));
                    ?> </small></p>

            <div class='clearfix'></div>
            <ul class="hidden-print pagination pull-right">
                <?php
                echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
                echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                ?>
            </ul><!-- /.pagination -->

        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->