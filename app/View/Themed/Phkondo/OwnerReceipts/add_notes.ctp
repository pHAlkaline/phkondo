<?php $this->Html->script('receipt_add_notes', false); ?>
<div id="page-container" class="row">
    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('View %s',__n('Receipt','Receipts',1)), array('action' => 'view', $id),array('class'=>'btn')); ?></li>
                <li ><?php echo $this->Html->link(__('List Receipts'), array('action' => 'index'),array('class'=>'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->
    <div id="page-content" class="col-sm-9">

        <div class="notes index">
            <?php echo $this->Form->create('Note'); ?>
            <?php echo $this->Form->hidden('Receipt.amount', array('value' => $receiptAmount)); ?>
            <h2 class="col-sm-9"><?php echo __n('Receipt','Receipts',1) . ' ' . $receiptId; ?></h2>
            <div class="actions col-sm-3">
                <h3 style="float:right;"><?php echo __('Total amount'); ?><span id="addNotesTotalAmount"></span></h3>


            </div><!-- /.actions -->
            <h2 class="col-sm-9"><?php echo __('Pick Notes'); ?></h2>
            <div class="actions col-sm-3">
                <?php if (count($notes)): ?>
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary', 'style' => 'margin: 14px 0; float: right;')); ?>            
                <?php endif; ?>

            </div><!-- /.actions -->

            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th><?php echo __('Document'); ?></th>
                        <th><?php echo __('Document date'); ?></th>
                        <th><?php echo __('Title'); ?></th>
                        <th><?php echo __('Note Type'); ?></th>
                        <th><?php echo __n('Fraction','Fractions',1); ?></th>
                        <th><?php echo __('Client'); ?></th>
                        <th><?php echo __('Amount'); ?></th>
                        <th><?php echo __('Due Date'); ?></th>
                        <th class="actions"><?php echo __('Pick'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notes as $key => $note): ?>
                        <tr>
                            <td><?php echo h($note['Note']['document']); ?>&nbsp;</td>
                            <td><?php echo h( $note['Note']['document_date']); ?>&nbsp;</td>
                            <td><?php echo h($note['Note']['title']); ?>&nbsp;</td>
                            <td><?php echo h($note['NoteType']['name']); ?></td>
                            <td><?php echo h($note['Fraction']['fraction']); ?></td>
                            <td><?php echo h($note['Entity']['name']); ?></td>
                            <td><?php echo h($note['Note']['amount']); ?>&nbsp;<?= Configure::read('currencySign'); ?></td>
                            <!--td><?php //echo h($note['Note']['pending_amount']);  ?>&nbsp;</td-->
                            <td><?php echo h( $note['Note']['due_date']); ?>&nbsp;</td>
                            <td class="actions">
                                <?php echo $this->Form->hidden('Note.' . $note['Note']['id'] . '.type', array('value' => $note['NoteType']['id'])); ?>
                                <?php echo $this->Form->hidden('Note.' . $note['Note']['id'] . '.amount', array('value' => $note['Note']['amount'])); ?>
                                <?php echo $this->Form->checkbox('Note.' . $note['Note']['id'] . '.check', array('hiddenField' => false)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <?php echo $this->Form->end(); ?>

        </div><!-- /.index -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
