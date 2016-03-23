
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $editDisabled = '';
                $deleteDisabled = '';
                $createNotesDisabled = 'disabled';
                $hasNotesDisabled = 'disabled';
                if (!$budget['Budget']['editable']) {
                    $editDisabled = ' disabled';
                }
                if (!$budget['Budget']['deletable']) {
                    $deleteDisabled = ' disabled';
                }

                if (count($budget['Note']) == 0 && $budget['Budget']['budget_status_id'] == 2) {
                    $createNotesDisabled = '';
                }

                if (count($budget['Note']) > 0) {
                    $hasNotesDisabled = '';
                }
                ?>
                <li ><?php echo $this->Html->link(__('Edit Budget'), array('action' => 'edit', $budget['Budget']['id'],'?'=>$this->request->query), array('class' => 'btn ' . $editDisabled)); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Budget'), array('action' => 'delete', $budget['Budget']['id'],'?'=>$this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $budget['Budget']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Budget'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Budgets'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Create Notes'), array('controller' => 'budget_notes', 'action' => 'create','?'=>array('budget_id'=>$budget['Budget']['id'])), array('class' => 'btn ' . $createNotesDisabled, 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Note','Notes',2), array('controller' => 'budget_notes', 'action' => 'index','?'=>array('budget_id'=>$budget['Budget']['id'])), array('class' => 'btn ' . $hasNotesDisabled, 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Settled Shares Map'), array('action' => 'shares_map', $budget['Budget']['id'],'?'=>array('budget_id'=>$budget['Budget']['id'])), array('class' => 'btn ', 'target' => '_blank', 'escape' => false)); ?> </li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="budgets view">

            <legend><?php echo __n('Budget', 'Budgets', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		
                        <td class='col-sm-2'><strong><?php echo __n('Fiscal Year', 'Fiscal Years', 1); ?></strong></td>
                        <td>
                            <?php echo h($budget['FiscalYear']['title']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		
                        <td><strong><?php echo __('Budget Type'); ?></strong></td>
                        <td>
                            <?php echo h($budget['BudgetType']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Budget Status'); ?></strong></td>
                        <td>
                            <?php echo h($budget['BudgetStatus']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Title'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['title']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Budget Date'); ?></strong></td>
                        <td>
                            <?php echo h( $budget['Budget']['budget_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Requested Amount'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['requested_amount']); ?>
                            &nbsp;<?php echo  Configure::read('currencySign'); ?>
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Amount'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['amount']); ?>
                            &nbsp;<?php echo  Configure::read('currencySign'); ?>
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Common Reserve Fund (%)'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['common_reserve_fund']); ?>
                            &nbsp;&percnt;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Begin Date'); ?></strong></td>
                        <td>
                            <?php echo h( $budget['Budget']['begin_date']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Share', 'Shares', 2); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['shares']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Share Periodicity'); ?></strong></td>
                        <td>
                            <?php echo h($budget['SharePeriodicity']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Share Distribution'); ?></strong></td>
                        <td>
                            <?php echo h($budget['ShareDistribution']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Due Days'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['due_days']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Meeting Draft'); ?></strong></td>
                        <td>
                            <?php echo h($budget['Budget']['meeting_draft']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h( $budget['Budget']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h( $budget['Budget']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		
                        <td><strong><?php echo __('Comments'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($budget['Budget']['comments'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
