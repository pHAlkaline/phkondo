<?php
$showActions = false;
if ($this->Session->read('Condo.Budget.Status') == 1) {
    $showActions = true;
}
?>
<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">

        <div class="notes index">

            <h2 class="col-sm-9"><?php echo __('Notes'); ?></h2>
            <?php if ($showActions) : ?>
                <div class="actions hidden-print col-sm-3">
                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Note'), array('action' => 'add'), array('class' => 'btn btn-primary', 'style' => 'margin: 14px 0; float: right;', 'escape' => false)); ?>
                </div><!-- /.actions -->
            <?php endif; ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('document'); ?></th>
                            <th><?php echo $this->Paginator->sort('document_date'); ?></th>

                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('NoteType.name',__('Note Type')); ?></th>
                            <th><?php echo $this->Paginator->sort('Fraction.description',__('Fraction')); ?></th>
                            <th><?php echo $this->Paginator->sort('Entity.name',__('Entity')); ?></th>
                            <th><?php echo $this->Paginator->sort('amount'); ?></th>
                            <!--th><?php //echo $this->Paginator->sort('pending_amount'); ?></th-->
                            <th><?php echo $this->Paginator->sort('due_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('payment_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('NoteStatus.name',__('Note Status')); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td><?php echo h($note['Note']['document']); ?>&nbsp;</td>
                                <td><?php echo $this->Time->format(Configure::read('dateFormatSimple'),$note['Note']['document_date']); ?>&nbsp;</td>
                                <td><?php echo h($note['Note']['title']); ?>&nbsp;</td>
                                <td><?php echo h($note['NoteType']['name']); ?></td>
                                <td><?php echo h($note['Fraction']['description']); ?></td>
                                <td><?php echo h($note['Entity']['name']); ?></td>
                                <td><?php echo h($note['Note']['amount']); ?>&nbsp;<?= Configure::read('currencySign'); ?></td>
                                <!--td><?php //echo h($note['Note']['pending_amount']); ?>&nbsp;</td-->
                                <td><?php echo $this->Time->format(Configure::read('dateFormatSimple'),$note['Note']['due_date']); ?>&nbsp;</td>
                                <td><?php echo $this->Time->format(Configure::read('dateFormatSimple'),$note['Note']['payment_date']); ?>&nbsp;</td>
                                <td><?php echo h($note['NoteStatus']['name']); ?>    </td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $note['Note']['id']), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php if ($showActions): ?>

                                        <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $note['Note']['id']), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                        <?php if ($note['Note']['deletable']): ?>
                                            <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $note['Note']['id']), array('title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false,'confirm'=> __('Are you sure you want to delete # %s?' , $note['Note']['title'] ))); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
