
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

   <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Movement'), array('action' => 'edit', $movement['Movement']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                 <?php if ($deletable) { ?>
                <li ><?php echo $this->Form->postLink(__('Delete Movement'), array('action' => 'delete', $movement['Movement']['id'],'?'=>$this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to delete # %s?', $movement['Movement']['description']))); ?> </li>
                 <?php } ?>
                <li ><?php echo $this->Html->link(__('New Movement'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Movements'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>


            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="movements view">

            <legend><?php echo __n('Movement', 'Movements', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>

                    <tr>
                        <td class='col-sm-2'><strong><?php echo __('Account'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Account']['title']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td class='col-sm-2'><strong><?php echo __('Fiscal Year'); ?></strong></td>
                        <td>
                            <?php echo h($movement['FiscalYear']['title']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td class='col-sm-2'><strong><?php echo __('Movement Date'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['movement_date']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Description'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['description']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Amount'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['amount']); ?>
                            &nbsp;<?php echo  Configure::read('currencySign'); ?>
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Movement Category'); ?></strong></td>
                        <td>
                            <?php echo $movement['MovementCategory']['name']; ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Movement Operation'); ?></strong></td>
                        <td>
                            <?php echo $movement['MovementOperation']['name']; ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Movement Type'); ?></strong></td>
                        <td>
                            <?php echo $movement['MovementType']['name']; ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Document'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['document']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h($movement['Movement']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>					</tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
