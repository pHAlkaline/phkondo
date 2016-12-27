
<div id="page-container" class="row">
      <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Maintenance','Maintenances',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Maintenance'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
             <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('client_number'); ?></th>
                            <th><?php echo $this->Paginator->sort('renewal_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('last_inspection'); ?></th>
                            <th><?php echo $this->Paginator->sort('next_inspection'); ?></th>
                            <th><?php echo $this->Paginator->sort('Supplier.name',__n('Supplier','Suppliers',1)); ?></th>
                            <th><?php echo $this->Paginator->sort('active'); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maintenances as $maintenance): ?>
                            <tr>
                                <td><?php echo h($maintenance['Maintenance']['title']); ?>&nbsp;</td>
                                <td><?php echo h($maintenance['Maintenance']['client_number']); ?>&nbsp;</td>
                                <td><?php echo h($maintenance['Maintenance']['renewal_date']); ?>&nbsp;</td>
                                <td><?php echo h($maintenance['Maintenance']['last_inspection']); ?>&nbsp;</td>
                                <td><?php echo h($maintenance['Maintenance']['next_inspection']); ?>&nbsp;</td>
                                <td>
                                    <?php echo h($maintenance['Supplier']['name']); ?>
                                </td>
                                <td><?php echo h($maintenance['Maintenance']['active_string']); ?>&nbsp;</td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $maintenance['Maintenance']['id'],'?'=>$this->request->query), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $maintenance['Maintenance']['id'],'?'=>$this->request->query), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $maintenance['Maintenance']['id'],'?'=>$this->request->query), array('title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false,'confirm'=> __('Are you sure you want to delete # %s?' , $maintenance['Maintenance']['title'] ))); ?>
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
