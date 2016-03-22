
<div id="page-container" class="row">
    
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Administrator','Administrators',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Administrator'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            
                            <th><?php echo $this->Paginator->sort('Entity.name',__n('Entity','Entities',1)); ?></th>
                            <th><?php echo $this->Paginator->sort('FiscalYear.title',__n('Fiscal Year','Fiscal Years',1)); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($administrators as $administrator): ?>
                            <tr>
                                
                                <td>
                                    <?php echo h($administrator['Entity']['name']); ?>
                                </td>
                                <td>
                                    <?php echo h($administrator['FiscalYear']['title']); ?>
                                </td>
                                <td><?php echo h($administrator['Administrator']['title']); ?>&nbsp;</td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $administrator['Administrator']['id'],'?'=>$this->request->query), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $administrator['Administrator']['id'],'?'=>$this->request->query), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $administrator['Administrator']['id'],'?'=>$this->request->query), array('title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false), __('Are you sure you want to delete # %s?', $administrator['Administrator']['title'])); ?>
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
