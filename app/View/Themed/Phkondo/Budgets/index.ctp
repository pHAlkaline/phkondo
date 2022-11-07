<?php $this->Html->css('footable/footable.bootstrap.min', false); ?>
<?php $this->Html->script('moment-with-locales', false); ?>
<?php $this->Html->script('libs/footable/footable', false); ?>
<?php $this->Html->script('footable', false); ?>
<div id="page-container" class="row">
    
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Budget','Budgets',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Budget'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
             <div class="row text-center loading">
                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 40px;"></span>
            </div>
            <div class="col-sm-12 hidden">

                <table data-empty="<?= __('Empty'); ?>"  class="footable table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('BudgetType.name', __('Budget Type')); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('BudgetStatus', __('Budget Status')); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('budget_date'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('begin_date'); ?></th>
                            <th data-breakpoints="xs"><?php echo $this->Paginator->sort('shares'); ?></th>
                            <th data-breakpoints="xs" class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>
                            <th data-breakpoints="xs" class="actions hidden-print"><?php //echo __('Actions');  ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($budgets as $budget):; ?>
                            <tr>
                                <td><?php echo h($budget['BudgetType']['name']); ?></td>
                                <td><?php echo h($budget['BudgetStatus']['name']); ?></td>
                                <td><?php echo h($budget['Budget']['title']); ?>&nbsp;</td>
                                <td><?php echo h( $budget['Budget']['budget_date']); ?>&nbsp;</td>
                                <td><?php echo h( $budget['Budget']['begin_date']); ?>&nbsp;</td>
                                <td><?php echo h($budget['Budget']['shares']); ?>&nbsp;</td>
                                <td class="amount"><?php echo number_format($budget['Budget']['amount'],2); ?>&nbsp;<?php echo  Configure::read('Application.currencySign'); ?></td>
                                <td class="actions hidden-print">
                                    <?php 
                                    $editDisabled=' disabled';
                                    $deleteDisabled=' disabled';
                                    if ($budget['Budget']['editable']){
                                        $editDisabled='';
                                    }
                                    if ($budget['Budget']['deletable']){
                                        $deleteDisabled='';
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
