 
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus-sign"></span> ' . __('New Condo'), array('action' => 'add'), array('class' => 'btn btn-primary hidden-print', 'style' => 'margin: 8px 0; float:right;', 'escape' => false)); 
       ?> <div class="clearfix"></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    
    <div class="panel-heading"><strong><?php echo __n('Condo', 'Condos', 2); ?></strong></div>
    <div class="panel-body">
       
       <?php  
       echo $this->element('search_tool');?>
        <div class="clearfix"></div>
        <div class="table-responsive"> 
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th><?php echo $this->Paginator->sort('title', __('Condo')); ?></th>
                        <th class="hidden-xs"><?php echo $this->Paginator->sort('address'); ?></th>
                        <th class="hidden-xs"><?php echo __n('Fiscal Year', 'Fiscal Years', 1); ?></th>
                        <th class="actions hidden-print hidden-print"><?php echo ' '; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($condos as $condo): ?>
                        <?php
                        $viewGlyphiconState = array();
                        $viewGlyphicon = '';
                        foreach ($condo['Insurance'] as $insurance) {
                            if ($insurance['expire_out'] > -30) {
                                $viewGlyphiconState[] = 'info';
                            }
                            if ($insurance['expire_out'] > -15) {
                                $viewGlyphiconState[] = 'warning';
                            }
                            if ($insurance['expire_out'] > 0) {
                                $viewGlyphiconState[] = 'danger';
                            }
                        }
                        foreach ($condo['Maintenance'] as $maintenance) {
                            if ($maintenance['expire_out'] > -30) {
                                $viewGlyphiconState[] = 'info';
                            }
                            if ($maintenance['expire_out'] > -15) {
                                $viewGlyphiconState[] = 'warning';
                            }
                            if ($maintenance['expire_out'] > 0) {
                                $viewGlyphiconState[] = 'danger';
                            }
                            if ($maintenance['next_inspection_out'] > -30) {
                                $viewGlyphiconState[] = 'info';
                            }
                            if ($maintenance['next_inspection_out'] > -15) {
                                $viewGlyphiconState[] = 'warning';
                            }
                            if ($maintenance['next_inspection_out'] > 0) {
                                $viewGlyphiconState[] = 'danger';
                            }
                        }
                        if (in_array('info', $viewGlyphiconState)) {
                            $viewGlyphicon = '<span class="label label-info">'.__('Alert').'</span> ';
                        }
                        if (in_array('warning', $viewGlyphiconState)) {
                            $viewGlyphicon = '<span class="label label-warning">'.__('Alert').'</span> ';
                        }
                        if (in_array('danger', $viewGlyphiconState)) {
                            $viewGlyphicon = '<span class="label label-danger">'.__('Alert').'</span> ';
                        }
                        ?>
                        <tr>
                            <td><?php echo $viewGlyphicon; ?>&nbsp;</td>
                            <td><?php echo h($condo['Condo']['title']); ?>&nbsp;</td>
                            <td class="hidden-xs"><?php echo nl2br(h($condo['Condo']['address'])); ?>&nbsp;</td>
                            <td class="hidden-xs"><?php if (isset($condo['FiscalYear'][0]['title'])) echo h($condo['FiscalYear'][0]['title'] . ' ( ' . h($condo['FiscalYear'][0]['open_date']) . ' a ' . h($condo['FiscalYear'][0]['close_date']) . ' ) '); ?>&nbsp;</td>
                            <td class="actions hidden-print hidden-print">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $condo['Condo']['id']), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                <?php if (Configure::read('Application.mode') != 'demo'): ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $condo['Condo']['id']), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php if (in_array(AuthComponent::user('role'), array('admin', 'store_admin'))): ?>
                                        <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $condo['Condo']['id']), array('title' => __('Delete'), 'class' => 'btn btn-default btn-xs', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $condo['Condo']['title']))); ?>
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
        <div class="clearfix"></div>
        <ul class="hidden-print pagination pull-right">
            <?php
            echo $this->Paginator->prev('< ' . __('Previous'), array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'tag' => 'li', 'currentClass' => 'disabled'));
            echo $this->Paginator->next(__('Next') . ' >', array('tag' => 'li'), null, array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a'));
            ?>
        </ul><!-- /.pagination -->

    </div><!-- /.index -->

</div>
