
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $deleteDisabled = '';
                if (!$this->Form->value('Receipt.deletable')) {
                    $deleteDisabled = 'disabled';
                }
                ?>
                <li ><?php echo $this->Html->link(__('New Receipt'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn')); ?></li>
                <li ><?php echo $this->Form->postLink(__('Delete Receipt'), array('action' => 'delete', $this->Form->value('Receipt.id'), '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Receipt.id')))); ?></li>
                <li ><?php echo $this->Html->link(__('List Receipts'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>
                <!--li ><?php //echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('New Notes'), array('action' => 'add_notes', $this->Form->value('Receipt.id')), array('class' => 'btn ', 'escape' => false));     ?> </li-->

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="receipts form">

            <?php
            echo $this->Form->create('Receipt', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>',)));
            ?>
            <fieldset>
                <legend><?php echo __('Edit Receipt'); ?></legend>
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
                    <?php echo $this->Form->input('document_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('receipt_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('receipt_payment_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('observations', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->


            </fieldset>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-6"> 
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?> 
                </div> 
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->
        <?php if (count($notes)): ?>
            <div class="related">
                <a name="AddNotes"></a>
                <?php $this->Html->script('receipt_add_notes', false); ?>
                <div id="page-container" class="row row-offcanvas row-offcanvas-left">

                    <div id="page-content" class="col-sm-12">

                        <div class="index">
                            <?php
                            echo $this->Form->create('Note', array(
                                'url' => array('controller' => 'owner_receipts', 'action' => 'add_notes', $this->Form->value('Receipt.id'),'?' => $this->request->query)));
                            ?>

                            <?php echo $this->Form->hidden('Receipt.amount', array('value' => $receiptAmount)); ?>
                            <legend class="col-sm-9"><?php echo __n('Receipt', 'Receipts', 1) . ' ' . $receiptId; ?></legend>
                            <div class="actions col-sm-3">
                                <h3 style="float:right;"><?php echo __('Total amount'); ?><span id="addNotesTotalAmount"></span></h3>


                            </div><!-- /.actions -->
                            <legend class="col-sm-9"><?php echo __('Pick Notes'); ?></legend>
                            <div class="actions col-sm-3">
                                <?php if (count($notes)): ?>
                                    <?php
                                    echo $this->Form->submit(__('Submit'), array(
                                        'class' => 'btn btn-primary', 'style' => 'margin: 14px 0; float: right;'));
                                    ?>            
                                <?php endif; ?>

                            </div><!-- /.actions -->

                            <table class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <th><?php echo __('Document'); ?></th>
                                        <th><?php echo __('Document date'); ?></th>
                                        <th><?php echo __('Title'); ?></th>
                                        <th><?php echo __('Note Type'); ?></th>
                                        <th><?php echo __n('Fraction', 'Fractions', 1); ?></th>
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
                                            <td><?php echo h($note['Note']['document_date']); ?>&nbsp;</td>
                                            <td><?php echo h($note['Note']['title']); ?>&nbsp;</td>
                                            <td><?php echo h($note['NoteType']['name']); ?></td>
                                            <td><?php echo h($note['Fraction']['fraction']); ?></td>
                                            <td><?php echo h($note['Entity']['name']); ?></td>
                                            <td><?php echo h($note['Note']['amount']); ?>&nbsp;<?php echo Configure::read('currencySign'); ?></td>
                                            <!--td><?php //echo h($note['Note']['pending_amount']);      ?>&nbsp;</td-->
                                            <td><?php echo h($note['Note']['due_date']); ?>&nbsp;</td>
                                            <td class="actions">
                                                <?php
                                                $checked = '';
                                                if ($note['Note']['receipt_id'] != '') {
                                                    $checked = 'checked';
                                                }
                                                ?>
                                                <?php echo $this->Form->hidden('Note.' . $note['Note']['id'] . '.type', array('value' => $note['NoteType']['id'])); ?>
                                                <?php echo $this->Form->hidden('Note.' . $note['Note']['id'] . '.amount', array('value' => $note['Note']['amount'])); ?>
                                                <?php echo $this->Form->checkbox('Note.' . $note['Note']['id'] . '.check', array('hiddenField' => false, 'checked' => $checked)); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>


                            <?php echo $this->Form->end(); ?>

                        </div><!-- /.index -->

                    </div><!-- /#page-content .col-sm-9 -->

                </div><!-- /#page-container .row-fluid -->



            </div><!-- /.related -->
        <?php endif; ?>
    </div><!-- /#page-content .col-sm-9 -->


</div><!-- /#page-container .row-fluid -->
