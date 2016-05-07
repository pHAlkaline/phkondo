
<div id="page-container" class="row">
    
    <div id="page-content" class="col-sm-12">

        <div class="index">

            <h2 class="col-sm-9"><?php echo __n('Insurance','Insurances',2); ?></h2>
            <div class="actions hidden-print col-sm-3">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> '.__('New Insurance'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn btn-primary', 'style' => 'margin: 8px 0; float: right;', 'escape' => false));
                ?>
            </div><!-- /.actions -->
            <?php echo $this->element('search_tool'); ?>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                           
                            <th><?php echo $this->Paginator->sort('expiration_date'); ?></th>
                            <th><?php echo $this->Paginator->sort('title'); ?></th>
                            <th><?php echo $this->Paginator->sort('Fraction.description',__n('Fraction','Fractions',1)); ?></th>
                            <th><?php echo $this->Paginator->sort('insurance_company'); ?></th>
                            <th><?php echo $this->Paginator->sort('policy'); ?></th>
                            <th><?php echo $this->Paginator->sort('InsuranceType.name',__('Insurance Type')); ?></th>
                            <th class="actions hidden-print"><?php //echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($insurances as $insurance): ?>
                            <tr>
                                <td><?php echo h($insurance['Insurance']['expiration_date']); ?>&nbsp;</td>
                                <td><?php echo h($insurance['Insurance']['title']); ?>&nbsp;</td>
                                <td><?php echo h($insurance['Fraction']['description']); ?>&nbsp;</td>
                                <td><?php echo h($insurance['Insurance']['insurance_company']); ?>&nbsp;</td>
                                <td><?php echo h($insurance['Insurance']['policy']); ?>&nbsp;</td>
                                <td><?php echo h($insurance['InsuranceType']['name']); ?></td>
                                <td class="actions hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $insurance['Insurance']['id'],'?'=>$this->request->query), array('title'=>__('Details'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $insurance['Insurance']['id'],'?'=>$this->request->query), array('title'=>__('Edit'),'class' => 'btn btn-default btn-xs','escape'=>false)); ?>
                                    <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $insurance['Insurance']['id'],'?'=>$this->request->query), array('title'=>__('Remove'),'class' => 'btn btn-default btn-xs','escape'=>false,'confirm'=> __('Are you sure you want to delete # %s?' , $insurance['Insurance']['title'] ))); ?>
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
