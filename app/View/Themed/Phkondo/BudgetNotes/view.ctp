<?php

$showActions = false;
if ($phkRequestData['budget_status'] == 1) {
    $showActions = true;
}
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">			
                <?php
                $deleteDisabled = null;
                $editDisabled = null;
                $newDisabled = null;
                if (!$note['Note']['editable'] || !$showActions) {
                    $editDisabled = 'disabled';
                }
                if (!$note['Note']['deletable'] || !$showActions) {
                    $deleteDisabled = 'disabled';
                }
                if (!$showActions) {
                    $newDisabled = 'disabled';
                }
                
                ?>  
                <li ><?php echo $this->Html->link(__('Edit Note'), array('action' => 'edit', $note['Note']['id'],'?'=>$this->request->query), array('class' => 'btn '.$editDisabled)); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Note'), array('action' => 'delete', $note['Note']['id'],'?'=>$this->request->query), array('class' => 'btn '.$deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $note['Note']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Note'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn '.$newDisabled)); ?> </li>
                <li ><?php echo $this->Html->link(__('List Notes'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="budget_notes view">

            <legend><?php echo __n('Note','Notes',1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Document'); ?></strong></td>
                        <td>
                                <?php echo h($note['Note']['document']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Title'); ?></strong></td>
                        <td>
                                <?php echo h($note['Note']['title']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Document Date'); ?></strong></td>
                        <td>
                                <?php echo h( $note['Note']['document_date']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Note Type'); ?></strong></td>
                        <td>
                                <?php echo h($note['NoteType']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Fraction','Fractions',1); ?></strong></td>
                        <td>
                                <?php echo h($note['Fraction']['fraction']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Entity','Entities',1); ?></strong></td>
                        <td>
                                <?php echo h($note['Entity']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Budget','Budgets',1); ?></strong></td>
                        <td>
                                <?php echo h($note['Budget']['title']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __n('Fiscal Year','Fiscal Years',1); ?></strong></td>
                        <td>
                                <?php echo h($note['FiscalYear']['title']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Amount'); ?></strong></td>
                        <td>
                                <?php echo h($note['Note']['amount']); ?>
                            &nbsp;<?php echo  Configure::read('currencySign'); ?>
                        </td>
                    </tr><!--tr>		<td><strong><?php //echo __('Pending Amount'); ?></strong></td>
                        <td>
                                <?php //echo h($note['Note']['pending_amount']); ?>
                            &nbsp;
                        </td>
                    </tr--><tr>		<td><strong><?php echo __('Due Date'); ?></strong></td>
                        <td>
                                <?php echo h( $note['Note']['due_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Payment Date'); ?></strong></td>
                        <td>
                                <?php if ($note['Note']['payment_date']) echo h( $note['Note']['payment_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Note Status'); ?></strong></td>
                        <td>
                                <?php echo h($note['NoteStatus']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Receipt','Receipts',1); ?></strong></td>
                        <td>
                                <?php echo h($note['Receipt']['document']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                                <?php echo h($note['Note']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                                <?php echo h($note['Note']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>					</tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
