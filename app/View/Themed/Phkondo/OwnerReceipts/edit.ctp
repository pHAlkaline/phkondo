
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $deleteDisabled = '';
                if (!$this->Form->value('Receipt.deletable')) {
                    $deleteDisabled = 'disabled';
                }
                ?>
                <li ><?php echo $this->Html->link(__('New Receipt'), array('action' => 'add'), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Form->postLink(__('Delete Receipt'), array('action' => 'delete', $this->Form->value('Receipt.id')), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Receipt.id')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Receipts'), array('action' => 'index'), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Add Notes'), array('action' => 'add_notes', $this->Form->value('Receipt.id')), array('class' => 'btn ', 'escape' => false)); ?> </li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="receipts form">

            <?php echo $this->Form->create('Receipt', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <h2><?php echo __('Edit Receipt'); ?></h2>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('client_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('address', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('observations', array('class' => 'form-control')); ?>
                </div><!-- .form-group --> 
                <div class="form-group">
                    <?php echo $this->Form->input('receipt_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('receipt_payment_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">                 <div class="col-sm-offset-2 col-sm-6">                     <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>                 </div>             </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->
        <div class="related">

        <h3><?php echo __('Notes'); ?></h3>
        <?php
        if (!empty($receipt['ReceiptNote'])) {
            $receipt['Note'] = $receipt['ReceiptNote'];
        }
        ?>
        <?php if (!empty($receipt['Note'])): ?>

            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo __('Document'); ?></th>
                            <th><?php echo __('Note Type'); ?></th>
                            <th><?php echo __('Document Date'); ?></th>
                            <th><?php echo __('Fraction'); ?></th>
                            <th><?php echo __('Title'); ?></th>
                            <th class="amount"><?php echo __('Amount'); ?></th>
                            <th class="actions"><?php //echo __('Actions');        ?></th>

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
                                <td><?php echo $this->Time->format(Configure::read('dateFormatSimple'), $note['document_date']); ?></td>
                                <td><?php echo $note['Fraction']['description']; ?></td>
                                <td><?php echo $note['title']; ?></td>
                                <td class="amount"><?php
                                    if ($note['NoteType']['id'] == 1){
                                        echo '-';
                                    }
                                    echo $note['amount'];
                                    ?>&nbsp;<?= Configure::read('currencySign'); ?></td>

                                <td class="actions">
                                    <?php
                                    $editDisabled = '';
                                    if (!$receipt['Receipt']['editable']) {
                                        $editDisabled = 'disabled';
                                    }
                                    ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('controller' => 'owner_receipts', 'action' => 'remove_note', $note['id']), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs ' . $editDisabled, 'escape' => false), __('Are you sure you want to remove # %s?', $note['document'])); ?>

                                </td>

                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo __('Total amount'); ?></td>
                            <td class="amount"><?php echo $receipt['Receipt']['total_amount']; ?>&nbsp;<?= Configure::read('currencySign'); ?></td>

                            <td class="actions">
                            </td>

                        </tr>
                    </tbody>
                </table><!-- /.table table-hover table-condensed -->
            </div>    

        <?php endif; ?>


    </div><!-- /.related -->
    </div><!-- /#page-content .col-sm-9 -->
    

</div><!-- /#page-container .row-fluid -->
