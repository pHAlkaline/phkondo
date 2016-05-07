<div id="page-container" class="row">
     <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo $phkRequestData['supplier_text']; ?></h2>
           
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Invoice'), array('action' => 'add',$supplier_id,'?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
             <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('document'); ?></th>
                            <th><?php echo $this->Paginator->sort('description'); ?></th>
                            <th><?php echo $this->Paginator->sort('document_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('payment_due_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('InvoiceConferenceStatus.name', __('Invoice Conference Status')); ?></th>

                            <th class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>

                            <th class="actions hidden-print"><?php //echo __('Actions');  ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice_conference): ?>
                            <tr>
                                <td><?php echo h($invoice_conference['InvoiceConference']['document']); ?>&nbsp;</td>
                                <td><?php echo h($invoice_conference['InvoiceConference']['description']); ?>&nbsp;</td>
                                <td><?php echo h( $invoice_conference['InvoiceConference']['document_date']); ?>&nbsp;</td>
                                <td><?php echo h( $invoice_conference['InvoiceConference']['payment_due_date']); ?>&nbsp;</td>
                                <td><?php echo h($invoice_conference['InvoiceConferenceStatus']['name']); ?></td>
                                <td class="amount"><?php echo h($invoice_conference['InvoiceConference']['amount']); ?>&nbsp;<?php echo  Configure::read('currencySign'); ?></td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $invoice_conference['InvoiceConference']['id'],'?'=>$this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $invoice_conference['InvoiceConference']['id'],'?'=>$this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $invoice_conference['InvoiceConference']['id'],'?'=>$this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs', 'escape' => false,'confirm'=> __('Are you sure you want to delete # %s?' , $invoice_conference['InvoiceConference']['description'] ))); ?>

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
                    ?>                </small></p>

            <div class='clearfix'></div><ul class="hidden-print pagination pull-right">
                <?php
                echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
                echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
                ?>
            </ul><!-- /.pagination -->

        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
