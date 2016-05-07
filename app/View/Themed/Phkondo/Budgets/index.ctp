
<div id="page-container" class="row">
    
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Budget','Budgets',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Budget'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('BudgetType.name', __('Budget Type')); ?></th>
                            <th><?php echo $this->Paginator->sort('BudgetStatus', __('Budget Status')); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('budget_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('begin_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('shares'); ?></th>
                            <th class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions');  ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($budgets as $budget):; ?>
                            <tr>
                                <td><?php echo $budget['BudgetType']['name']; ?></td>
                                <td><?php echo $budget['BudgetStatus']['name']; ?></td>
                                <td><?php echo h($budget['Budget']['title']); ?>&nbsp;</td>
                                <td><?php echo h( $budget['Budget']['budget_date']); ?>&nbsp;</td>
                                <td><?php echo h( $budget['Budget']['begin_date']); ?>&nbsp;</td>
                                <td><?php echo h($budget['Budget']['shares']); ?>&nbsp;</td>
                                <td class="amount"><?php echo h($budget['Budget']['amount']); ?>&nbsp;<?php echo  Configure::read('currencySign'); ?></td>
                                <td class="actions hidden-print">
                                    <?php 
                                    $editDisabled='';
                                    $deleteDisabled='';
                                    if (!$budget['Budget']['editable']){
                                        $editDisabled=' disabled';
                                    }
                                    if (!$budget['Budget']['deletable']){
                                        $deleteDisabled=' disabled';
                                    }
                                   ?>
                                    
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $budget['Budget']['id'],'?'=>$this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $budget['Budget']['id'],'?'=>$this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs '.$editDisabled, 'escape' => false));?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $budget['Budget']['id'],'?'=>$this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs '.$deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $budget['Budget']['title'])));?>
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
