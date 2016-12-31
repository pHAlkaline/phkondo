<?php 
$balance="0.00";
if (isset($movements[0]['Account']['balance'])){
    $balance=$movements[0]['Account']['balance'];
}
?>
<div id="page-container" class="row">
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Movement','Movements',2).' ('.__('Balance').':'.$balance.')'; ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link( '<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Movement'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
               ?>
            </div><!-- /.actions -->
             <?php echo $this->element('search_tool'); ?>
                <div class="clearfix"></div>
                <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('movement_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('description'); ?></th>
                            <th><?php echo $this->Paginator->sort('MovementCategory.name',__('Movement Category')); ?></th>
                            <th><?php echo $this->Paginator->sort('MovementOperation.name',__('Movement Operation')); ?></th>
                            <th><?php echo $this->Paginator->sort('MovementType.name',__('Movement Type')); ?></th>
                            <th class="amount"><?php echo $this->Paginator->sort('amount'); ?></th>
                            
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movements as $movement): ?>
                            <tr>
                                <td><?php echo h($movement['Movement']['movement_date']); ?>&nbsp;</td>
                                <td><?php echo h($movement['Movement']['description']); ?>&nbsp;</td>
                                <td><?php echo h($movement['MovementCategory']['name']); ?></td>
                                <td><?php echo h($movement['MovementOperation']['name']); ?></td>
                                <td><?php echo h($movement['MovementType']['name']); ?></td>
                                <td class="amount"><?php if ($movement['MovementType']['id']==2) echo '-'; echo h($movement['Movement']['amount']); ?>&nbsp;<?php echo  Configure::read('currencySign'); ?></td>
                                
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $movement['Movement']['id'],'?'=>$this->request->query), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $movement['Movement']['id'],'?'=>$this->request->query), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php if ($movement['MovementOperation']['id']!='1' || ($movement['MovementOperation']['id']=='1' && count($movements)==1)) { ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $movement['Movement']['id'],'?'=>$this->request->query), array('title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false,'confirm'=> __('Are you sure you want to delete # %s?' , $movement['Movement']['description'] ))); ?>
                                    <?php } ?>
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
