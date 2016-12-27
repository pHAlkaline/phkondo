
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Fiscal Year','Fiscal Years',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Fiscal Year'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('open_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('close_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('active'); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions');  ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fiscalYears as $fiscalYear): ?>
                        <?php 
                        $deleteDisabled='';
                        $activeDisabled='';
                        if (!$fiscalYear['FiscalYear']['deletable']) { 
                            $deleteDisabled=' disabled';
                        }
                        if ($fiscalYear['FiscalYear']['active_string']){
                            $activeDisabled=' disabled';
                        }
                                        
                            
                            ?>
                            <tr>
                                <td><?php echo h($fiscalYear['FiscalYear']['title']); ?>&nbsp;</td>
                                <td><?php echo h($fiscalYear['FiscalYear']['open_date']); ?>&nbsp;</td>
                                <td><?php echo h($fiscalYear['FiscalYear']['close_date']); ?>&nbsp;</td>
                                <td><?php echo h($fiscalYear['FiscalYear']['active_string']); ?>&nbsp;</td>
                                <td class="actions hidden-print">
                                     <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-check"></span> ', array('action' => 'active', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('title' => __('Active'), 'class' => 'btn btn-default btn-xs'.$activeDisabled, 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $fiscalYear['FiscalYear']['id'],'?'=>$this->request->query), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs'.$deleteDisabled, 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $fiscalYear['FiscalYear']['title']))); ?>
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
