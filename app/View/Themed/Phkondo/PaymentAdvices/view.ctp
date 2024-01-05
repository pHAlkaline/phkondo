<?php
$attachmentFormats = ['pdf' => __d('email', 'PDF'), 'html' => __d('html', 'HTML')];
if (!Configure::check('CakePdf.phkondo.active') || Configure::read('CakePdf.phkondo.active') == false) {
    unset($attachmentFormats['pdf']);
}
?>
<?php
$this->Html->css('footable/footable.bootstrap.min', false);
$this->Html->script('moment-with-locales', false);
$this->Html->script('libs/footable/footable', false);
$this->Html->script('footable', false);
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $editDisabled = '';
                $deleteDisabled = '';
                $payDisabled = '';
                $cancelDisabled = '';
                /*if (!$paymentAdvice['PaymentAdvice']['editable']) {
                    $editDisabled = ' disabled';
                }
                if (!$paymentAdvice['PaymentAdvice']['deletable']) {
                    $deleteDisabled = ' disabled';
                }
                if (!$paymentAdvice['PaymentAdvice']['cancelable']) {
                    $cancelDisabled = ' disabled';
                }*/
                if (!$paymentAdvice['PaymentAdvice']['payable']) {
                    $payDisabled = ' disabled';
                }
                ?>
                <li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $paymentAdvice['PaymentAdvice']['id'], '?' => $this->request->query), array('class' => 'btn ' . $editDisabled)); ?> </li>
                <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $paymentAdvice['PaymentAdvice']['id'], '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $paymentAdvice['PaymentAdvice']['document']))); ?> </li>
                <li><?php echo $this->Html->link(__('New'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li><?php echo $this->Html->link(__('List'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <!--li><?php //echo $this->Form->postLink(__('Cancel'), array('action' => 'cancel', $paymentAdvice['PaymentAdvice']['id'], '?' => $this->request->query), array('class' => 'btn ' . $cancelDisabled, 'confirm' => __('Are you sure you want to cancel # %s?', $paymentAdvice['PaymentAdvice']['document'])));  
                        ?> </li-->
                <li><?php echo $this->Html->link(__('Print'), array('action' => 'print', $paymentAdvice['PaymentAdvice']['id'], '?' => ['condo_id'=> $paymentAdvice['PaymentAdvice']['condo_id']]), array('target' => '_blank', 'class' => '', 'escape' => false)); ?> </li>
                <li><?php echo $this->Form->postLink(__('Create Receipt'), array('controller' => 'Receipts', 'action' => 'addFromPaymentAdvice', $paymentAdvice['PaymentAdvice']['id'], '?' => ['condo_id'=> $paymentAdvice['PaymentAdvice']['condo_id']]), array('target' => '_blank', 'class' => 'btn ' . $payDisabled)); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-10">

        <div class="payment_advices view">

            <legend><?php echo __n('Payment Advice', 'Payment Advices', 1); ?>&nbsp;<?php echo h($paymentAdvice['PaymentAdvice']['document']); ?>&nbsp;</legend>
            <div class="actions col-sm-12">
                <div class="float-right text-right">
                    <h4 class="text-right"><?php echo __('Total Amount') . ' : ' . number_format($paymentAdvice['PaymentAdvice']['total_amount'], 2) . ' ' . Configure::read('Application.currencySign'); ?></h4>

                </div>

            </div><!-- /.actions -->
            <section>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab"><?= __('Details'); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#notes" aria-controls="notes" role="tab" data-toggle="tab"><?= __n('Note', 'Notes', 2); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#send-by-email" aria-controls="send-by-email" role="tab" data-toggle="tab"><?= __d('email', 'Send By Email'); ?></a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="details" aria-labelledby="details-tab">

                        <br />

                        <table class="table table-hover table-condensed">
                            <tbody>
                                <tr>
                                    <td class='col-sm-2'><strong><?php echo __('Document'); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['PaymentAdvice']['document']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Document Date'); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['PaymentAdvice']['document_date']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Due Date'); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['PaymentAdvice']['due_date']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['Fraction']['fraction']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __n('Entity', 'Entities', 1); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['Entity']['name']); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Total Amount'); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['PaymentAdvice']['total_amount']); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Address'); ?></strong></td>
                                    <td><?php echo nl2br(h($paymentAdvice['Entity']['address'])); ?>&nbsp;</td>
                                </tr>
                                <!--tr>
                                    <td><strong><?php //echo __('Status'); 
                                                ?></strong></td>
                                    <td><?php //echo h($paymentAdvice['ReceiptStatus']['name']); 
                                        ?>&nbsp;</td>
                                </tr-->
                                <tr>
                                    <td><strong><?php echo __('Payment Method'); ?></strong></td>
                                    <td><?php echo h($paymentAdvice['PaymentType']['name']); ?>&nbsp;</td>
                                </tr>


                                <!--?php if ($paymentAdvice['PaymentAdvice']['status_id'] == 4) { ?>
                                    <tr>
                                        <td><strong><?php //echo __('Cancel Motive'); 
                                                    ?></strong></td>
                                        <td>
                                            <?php //echo h($paymentAdvice['PaymentAdvice']['cancel_motive']); 
                                            ?>
                                            &nbsp;
                                        </td>
                                    </tr-->
                                <!--?php } ?-->
                                <tr>
                                    <td><strong><?php echo __('Payment Date'); ?></strong></td>
                                    <td>
                                        <?php
                                        if ($paymentAdvice['PaymentAdvice']['payment_date'] != '') {
                                            echo h($paymentAdvice['PaymentAdvice']['payment_date']);
                                        }
                                        ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __n('Receipt', 'Receipts', 1); ?></strong></td>
                                    <td>
                                        <?php
                                        if ($paymentAdvice['PaymentAdvice']['receipt_id'] != '') {
                                            echo $this->Html->link(h($paymentAdvice['Receipt']['document']), array('controller' => 'receipts', 'action' => 'view', $paymentAdvice['PaymentAdvice']['receipt_id'], '?' => $this->request->query), array('target' => '_blank', 'class' => '', 'escape' => false));
                                        }
                                        ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Modified'); ?></strong></td>
                                    <td>
                                        <?php echo h($paymentAdvice['PaymentAdvice']['modified']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Created'); ?></strong></td>
                                    <td>
                                        <?php echo h($paymentAdvice['PaymentAdvice']['created']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Observations'); ?></strong></td>
                                    <td>
                                        <?php echo h($paymentAdvice['PaymentAdvice']['observations']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="notes" aria-labelledby="notes-tab">
                        <br />
                        <?php
                        if (!empty($paymentAdvice['ReceiptNote'])) {
                            $paymentAdvice['Note'] = $paymentAdvice['ReceiptNote'];
                        }
                        ?>
                        <?php if (!empty($paymentAdvice['Note'])) : ?>

                            <div class="row text-center loading">
                                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
                            </div>
                            <div class="col-sm-12 hidden">
                               
                                <table data-empty="<?= __('Empty'); ?>" class="footable table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('Document'); ?></th>
                                            <th><?php echo __('Type'); ?></th>
                                            <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
                                            <th data-breakpoints="xs"><?php echo __('Date'); ?></th>
                                            <th data-breakpoints="xs"><?php echo __('Title'); ?></th>
                                            <th class="amount"><?php echo __('Amount'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($paymentAdvice['Note'] as $note) :
                                            //debug($note);
                                        ?>
                                            <tr>
                                                <td><?php echo h($note['document']); ?></td>
                                                <td><?php echo h($note['NoteType']['name']); ?></td>
                                                <td><?php echo h($note['Fraction']['fraction']); ?></td>
                                                <td><?php echo h($note['document_date']); ?></td>
                                                <td><?php echo h($note['title']); ?></td>
                                                <td class="amount"><?php
                                                                    if ($note['NoteType']['id'] == 1) {
                                                                        echo '-';
                                                                    }
                                                                    echo $note['amount'];
                                                                    ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><?php echo __('Total amount'); ?>&nbsp;:&nbsp;</td>
                                            <td class="amount"><?php echo number_format($paymentAdvice['PaymentAdvice']['total_amount'], 2); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?></td>


                                        </tr>
                                    </tbody>
                                </table><!-- /.table table-hover table-condensed -->
                            </div>

                        <?php endif; ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="send-by-email" aria-labelledby="send-by-email-tab">

                        <div class="payment_advices form">
                            <br />
                            <?php echo $this->Form->create(
                                'PaymentAdvice',
                                array(
                                    'url' => array('controller' => 'payment_advices', 'action' => 'send', $paymentAdvice['PaymentAdvice']['id'], '?' => $this->request->query),
                                    'class' => 'form-horizontal',
                                    'role' => 'form',
                                    'inputDefaults' => array(
                                        'class' => 'form-control',
                                        'label' => array('class' => 'col-sm-2 control-label'),
                                        'between' => '<div class="col-sm-6">',
                                        'after' => '</div>'
                                    )
                                )
                            ); ?>
                            <fieldset>
                                <?php echo $this->Form->input('id'); ?>

                                <div class="form-group">
                                    <?php echo $this->Form->input('send_to', ['type' => 'select', 'label' => array('text' => __d('email', 'Send To'), 'class' => 'col-sm-2 control-label'), 'class' => 'form-control select2-phkondo', 'options' => $notificationEntities, 'multiple' => true, 'value' => $notificationEntities, 'data-allow-clear' => true, 'data-tags' => true, 'data-maximum-selection-length' => 5, 'required' => 'required']); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $this->Form->input('subject', array('label' => array('text' => __d('email', 'Subject'), 'class' => 'col-sm-2 control-label'), 'required' => 'required', 'class' => 'form-control', 'default' => $emailNotifications['payment_advice_subject'])); ?>
                                </div><!-- .form-group -->

                                <div class="form-group">
                                    <?php echo $this->Form->input('message', array('label' => array('text' => __d('email', 'Message'), 'class' => 'col-sm-2 control-label'), 'required' => 'required', 'type' => 'textarea', 'class' => 'form-control', 'default' => $emailNotifications['payment_advice_message'])); ?>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <?php echo $this->Form->input('attachment_format', ['type' => 'select', 'label' => array('text' => __d('email', 'Format'), 'class' => 'col-sm-2 control-label'), 'class' => 'form-control select2-phkondo', 'options' => $attachmentFormats, 'value' => $emailNotifications['payment_advice_attachment_format'], 'required' => 'required']); ?>
                                </div>

                                <!-- .form-group -->

                            </fieldset>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <?php echo $this->Form->button(__d('email', 'Send'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>

                </div>
            </section>



        </div><!-- /.view -->



    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->