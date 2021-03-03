<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<?php
$showActions = false;
if ($phkRequestData['budget_status'] == 1) {
    $showActions = true;
}
?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-xs-12 col-md-8"><?php echo __n('Note', 'Notes', 2); ?></h2>
            <div class="actions hidden-print col-xs-12 col-md-4 pull-right text-right">
                <?php
                
                if ($showActions) :
                    echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Note'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 2px;', 'escape' => false));
                    //if (in_array(AuthComponent::user('role'), array('admin', 'store_admin'))):
                        echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>' . __('Delete All'), array('action' => 'delete_all', $this->request->query['budget_id'], '?' => $this->request->query), array('title' => __('Delete'),'class' => 'btn btn-danger', 'style' => 'margin: 8px 2px; ', 'escape' => false, 'confirm' => __('Are you sure you want to delete all # %s?', __n('Note', 'Notes', 2))));
                    //endif;
                    //echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span> ' . __('Delete All'), array('action' => 'delete_all', '?' => $this->request->query), array('class' => 'btn btn-danger', 'style' => 'margin: 8px 2px; ', 'escape' => false));
                endif;
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool_notes'); ?>
            <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('document_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('NoteType.name', __('Note Type')); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('Fraction.fraction', __('Fraction', 'Fractions', 1)); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('Entity.name', __n('Entity', 'Entities', 1)); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('due_date'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('payment_date'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('NoteStatus.name', __('Note Status')); ?></th>
                            <th data-breakpoints="xs" class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>
                            <th data-breakpoints="xs" class="actions hidden-print"><?php //echo __('Actions');     ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td><?php echo h($note['Note']['document_date']); ?>&nbsp;</td>
                                <td><?php echo h($note['Note']['title']); ?>&nbsp;</td>
                                <td><?php echo h($note['NoteType']['name']); ?></td>
                                <td><?php echo h($note['Fraction']['fraction']); ?></td>
                                <td><?php echo h($note['Entity']['name']); ?></td>
                                <td><?php echo h($note['Note']['due_date']); ?>&nbsp;</td>
                                <td><?php if ($note['Note']['payment_date']) echo h($note['Note']['payment_date']); ?>&nbsp;</td>
                                <td><?php echo h($note['NoteStatus']['name']); ?>    </td>
                                <td class="amount"><?php echo number_format($note['Note']['amount'], 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?></td>

                                <td class="actions hidden-print">
                                    <?php
                                    $deleteDisabled = null;
                                    $editDisabled = null;
                                    if (!$note['Note']['editable'] || !$showActions) {
                                        $editDisabled = ' disabled';
                                    }
                                    if (!$note['Note']['deletable'] || !$showActions) {
                                        $deleteDisabled = ' disabled';
                                    }
                                    ?>  
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $note['Note']['id'], '?' => $this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $note['Note']['id'], '?' => $this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs ' . $editDisabled, 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $note['Note']['id'], '?' => $this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs ' . $deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $note['Note']['title']))); ?>


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
