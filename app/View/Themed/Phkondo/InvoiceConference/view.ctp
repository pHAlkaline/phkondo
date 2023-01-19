<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li><?php echo $this->Html->link(__('Edit Invoice'), array('action' => 'edit', $invoice_conference['InvoiceConference']['id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li><?php echo $this->Form->postLink(__('Delete Invoice'), array('action' => 'delete', $invoice_conference['InvoiceConference']['id'], '?' => $this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to delete # %s?', $invoice_conference['InvoiceConference']['description']))); ?> </li>
                <li><?php echo $this->Html->link(__('New Invoice'), array('action' => 'add', $invoice_conference['InvoiceConference']['supplier_id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index_by_supplier', $invoice_conference['InvoiceConference']['supplier_id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-10">

        <div class="invoice_conference view">

            <legend><?php echo __n('Invoice', 'Invoices', 1); ?></legend>

            <section>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab"><?= __('Details'); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#movements" aria-controls="movements" role="tab" data-toggle="tab"><?= __n('Movement', 'Movements', 2); ?> ( <?= count($invoice_conference['Movement']); ?> ) </a>
                    </li>
                  
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="details" aria-labelledby="details-tab">

                        <br />

                        <table class="table table-hover table-condensed">
                            <tbody>
                                <tr>
                                    <td><strong><?php echo __n('Supplier', 'Suppliers', 1); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['Supplier']['name']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class='col-sm-2'><strong><?php echo __('Document'); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['InvoiceConference']['document']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Description'); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['InvoiceConference']['description']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Amount'); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['InvoiceConference']['amount']); ?>
                                        &nbsp;<?php echo  Configure::read('Application.currencySign'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Document Date'); ?></strong></td>
                                    <td>
                                        <?php
                                        if (!empty($invoice_conference['InvoiceConference']['document_date'])) :
                                            echo h($invoice_conference['InvoiceConference']['document_date']);
                                        endif;
                                        ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Due Date'); ?></strong></td>
                                    <td>
                                        <?php
                                        if (!empty($invoice_conference['InvoiceConference']['payment_due_date'])) :
                                            echo h($invoice_conference['InvoiceConference']['payment_due_date']);
                                        endif;

                                        ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Payment Date'); ?></strong></td>
                                    <td>
                                        <?php
                                        if (!empty($invoice_conference['InvoiceConference']['payment_date'])) :
                                            echo h($invoice_conference['InvoiceConference']['payment_date']);
                                        endif;

                                        ?>
                                        &nbsp;
                                    </td>
                                </tr>


                                <tr>
                                    <td><strong><?php echo __('Status'); ?></strong></td>
                                    <td>
                                        <?php echo $invoice_conference['InvoiceConferenceStatus']['name']; ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Modified'); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['InvoiceConference']['modified']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Created'); ?></strong></td>
                                    <td>
                                        <?php echo h($invoice_conference['InvoiceConference']['created']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Observations'); ?></strong></td>
                                    <td>
                                        <?php echo nl2br(h($invoice_conference['InvoiceConference']['comments'])); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="movements" aria-labelledby="movements-tab">

                        <br />
                        <div class="col-sm-12">
                            <table data-empty="<?= __('Empty'); ?>" class="footable table table-hover table-condensed table-export">
                                <thead>
                                    <tr>
                                       
                                        <th><?php echo $this->Paginator->sort('movement_date'); ?></th>
                                        <th><?php echo $this->Paginator->sort('description'); ?></th>
                                        <th data-breakpoints="xs"><?php echo $this->Paginator->sort('MovementCategory.name', __('Movement Category')); ?></th>
                                        <th data-breakpoints="xs"><?php echo $this->Paginator->sort('MovementOperation.name', __('Movement Operation')); ?></th>
                                        <th data-breakpoints="xs"><?php echo $this->Paginator->sort('MovementType.name', __('Movement Type')); ?></th>
                                        <th class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>
                                        <th data-breakpoints="xs" class="actions hidden-print"><?php //echo __('Actions');
                                                                                                ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($invoice_conference['Movement'] as $movement) : ?>
                                        <tr>
                                           
                                            <td><?php echo h($movement['movement_date']); ?>&nbsp;</td>
                                            <td><?php echo h($movement['description']); ?>&nbsp;</td>
                                            <td><?php echo h($movement['MovementCategory']['name']); ?></td>
                                            <td><?php echo h($movement['MovementOperation']['name']); ?></td>
                                            <td><?php echo h($movement['MovementType']['name']); ?></td>
                                            <td class="amount"><?php if ($movement['MovementType']['id'] == 2) echo '-';
                                                                echo number_format($movement['amount'], 2); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?></td>

                                            <td class="actions hidden-print">
                                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('controller' => 'movements', 'action' => 'view', $movement['id'], '?' => array('condo_id' => $movement['Account']['condo_id'],'account_id' => $movement['Account']['id'])), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('controller' => 'movements', 'action' => 'edit', $movement['id'], '?' => array('condo_id' => $movement['Account']['condo_id'],'account_id' => $movement['Account']['id'])), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                                <?php if ($movement['MovementOperation']['id'] != '1' || ($movement['MovementOperation']['id'] == '1' && count($movements) == 1)) { ?>
                                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('controller' => 'movements', 'action' => 'delete', $movement['id'], '?' => array('condo_id' => $movement['Account']['condo_id'],'account_id' => $movement['Account']['id'])), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $movement['description']))); ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                 
                </div>
            </section>




        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->