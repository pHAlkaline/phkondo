<!-- DataTables -->
<?php $this->Html->css('/plugins/datatables/dataTables.bootstrap', false); ?> 
<?php $this->Html->script('/plugins/datatables/jquery.dataTables.min', false); ?>
<?php $this->Html->script('/plugins/datatables/dataTables.bootstrap.min', false); ?>
<?php $this->Html->script('data_tables', false); ?>

<?php
$header_title = __n('Condo', 'Condos', 2);
$header_subtitle = __('Index');
?>
<?php
$this->startIfEmpty('content_header');
echo $this->element('content_header_block', compact('breadcrumbs', 'header_title', 'header_subtitle'));
$this->end();
?>
<div id="page-container" class="row">

    <div id="page-content" class="col-sm-12">

        <div class="condos index">

            <div class="actions hidden-print pull-right">
                <?php echo $this->Html->link('<i class="fa fa-plus-circle"></i> ' . __('New Condo'), array('action' => 'add'), array('class' => 'btn btn-app', 'escape' => false)); ?>
            </div><!-- /.actions -->

            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo __('title'); ?></th>
                            <th><?php echo __('address'); ?></th>
                            <th><?php echo __n('Fiscal Year', 'Fiscal Years', 1); //$this->Paginator->sort('FiscalYear.title', __n('Fiscal Year','Fiscal Years',1));           ?></th>
                            <th>&nbsp;</th>
                            <th class="actions hidden-print hidden-print"><?php //echo __('Actions');          ?></th>
                        </tr>
                    </thead>


                    <tfoot>
                        <tr>
                            <th><?php echo __('title'); ?></th>
                            <th><?php echo __('address'); ?></th>
                            <th><?php echo __n('Fiscal Year', 'Fiscal Years', 1); //$this->Paginator->sort('FiscalYear.title', __n('Fiscal Year','Fiscal Years',1));           ?></th>
                            <th>&nbsp;</th>
                            <th class="actions hidden-print hidden-print"><?php //echo __('Actions');          ?></th>
                        </tr>
                    </tfoot>

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
                                $viewGlyphicon = '<span class="label label-info"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></span> ';
                            }
                            if (in_array('warning', $viewGlyphiconState)) {
                                $viewGlyphicon = '<span class="label label-warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></span> ';
                            }
                            if (in_array('danger', $viewGlyphiconState)) {
                                $viewGlyphicon = '<span class="label label-danger"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></span> ';
                            }
                            ?>
                            <tr>
                                <td><?php echo h($condo['Condo']['title']); ?>&nbsp;</td>
                                <td><?php echo nl2br(h($condo['Condo']['address'])); ?>&nbsp;</td>
                                <td><?php if (isset($condo['FiscalYear'][0]['title'])) echo h($condo['FiscalYear'][0]['title'] . ' ( ' . h($condo['FiscalYear'][0]['open_date']) . ' a ' . h($condo['FiscalYear'][0]['close_date']) . ' ) '); ?>&nbsp;</td>
                                <td><?php echo $viewGlyphicon; ?>&nbsp;</td>
                                <td class="actions hidden-print hidden-print">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> ', array('action' => 'view', $condo['Condo']['id']), array('title' => __('Details'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ', array('action' => 'edit', $condo['Condo']['id']), array('title' => __('Edit'), 'class' => 'btn btn-default btn-xs', 'escape' => false)); ?>
                                    <?php if (in_array(AuthComponent::user('role'), array('admin', 'store_admin'))): ?>
                                        <?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span> ', array('action' => 'delete', $condo['Condo']['id']), array('title' => __('Remove'), 'class' => 'btn btn-default btn-xs', 'escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $condo['Condo']['title']))); ?>
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

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
