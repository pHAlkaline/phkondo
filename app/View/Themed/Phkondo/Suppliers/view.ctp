<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Supplier'), array('action' => 'edit', $supplier['Supplier']['id']), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled = '';
                if (!$supplier['Supplier']['deletable']) {
                    $deleteDisabled = ' disabled';
                }
                ?>


                <li ><?php echo $this->Form->postLink(__('Delete Supplier'), array('action' => 'delete', $supplier['Supplier']['id']), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $supplier['Supplier']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Supplier'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Suppliers'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="suppliers view">

            <legend><?php echo __n('Supplier', 'Suppliers', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Vat Number'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['vat_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Representative'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['representative']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Address'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($supplier['Supplier']['address'])); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Contact', 'Contacts', 2); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['contacts']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['email']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Bank'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['bank']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Nib'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['nib']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($supplier['Supplier']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Comments'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($supplier['Supplier']['comments'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->
        
    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
