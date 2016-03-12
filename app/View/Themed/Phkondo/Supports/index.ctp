<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">
        <div class="index">
            <h2 class="col-sm-9"><?php echo __n('Support', 'Supports', 2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Support'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 14px 0; float: right;', 'escape' => false)); ?>            </div><!-- /.actions -->
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('fraction_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('support_category_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('support_priority_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('support_status_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('request_entity_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('assigned_user_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('created'); ?></th>
                            <th><?php echo $this->Paginator->sort('modified'); ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supports as $support): ?>
                            <tr>
                                <td><?php echo h($support['Fraction']['description']); ?></td>
                                <td><?php echo h($support['Support']['title']); ?>&nbsp;</td>
                                <td><?php echo h($support['SupportCategory']['name']); ?></td>
                                <td><?php echo h($support['SupportPriority']['name']); ?></td>
                                <td><?php echo h($support['SupportStatus']['name']); ?></td>
                                <td><?php echo h($support['RequestEntity']['name']); ?></td>
                                <td><?php echo h($support['AssignedUser']['name']); ?></td>
                                <td><?php echo h($support['Support']['created']); ?>&nbsp;</td>
                                <td><?php echo h($support['Support']['modified']); ?>&nbsp;</td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $support['Support']['id'], '?' => $this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $support['Support']['id'], '?' => $this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $support['Support']['id'], '?' => $this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $support['Support']['title']))); ?>
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
