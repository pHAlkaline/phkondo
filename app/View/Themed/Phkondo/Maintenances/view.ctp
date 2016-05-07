
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Maintenance'), array('action' => 'edit', $maintenance['Maintenance']['id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Maintenance'), array('action' => 'delete', $maintenance['Maintenance']['id'], '?' => $this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to delete # %s?', $maintenance['Maintenance']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Maintenance'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Maintenances'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="maintenances view">

            <legend><?php echo __n('Maintenance', 'Maintenances', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Title'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['title']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Client Number'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['client_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Contract Number'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['contract_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Start Date'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['start_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Renewal Date'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['renewal_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Last Inspection'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['last_inspection']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Next Inspection'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['next_inspection']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Supplier', 'Suppliers', 1); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Supplier']['name']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Active'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['active_string']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($maintenance['Maintenance']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Comments'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($maintenance['Maintenance']['comments'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
