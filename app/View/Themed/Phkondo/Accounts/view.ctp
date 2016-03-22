<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Account'), array('action' => 'edit', $account['Account']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Account'), array('action' => 'delete', $account['Account']['id'],'?'=>$this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to delete # %s?', $account['Account']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Account'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Accounts'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <?php
                $movementsDisabled = '';
                if (!$phkRequestData['fiscal_year_id']) {
                    $movementsDisabled = ' disabled';
                }
                ?>     
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Movement', 'Movements', 2), array('controller' => 'movements', 'action' => 'index','?'=>array('account_id'=>$account['Account']['id'])), array('class' => 'btn ' . $movementsDisabled, 'escape' => false)); ?> </li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="accounts view">

            <legend><?php echo __n('Account', 'Accounts', 1); ?></legend>

            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __('Title'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['title']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Balance'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['balance']); ?>
                                &nbsp;<?php echo  Configure::read('currencySign'); ?>
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Bank'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['bank']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Balcony'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['balcony']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __n('Contact', 'Contacts', 2); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['contacts']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Account Number'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['account_number']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Nib'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['nib']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Iban'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['iban']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Swift'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['swift']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Main Account'); ?></strong></td>
                            <td>
                                <?php echo h($account['Account']['main_account']); ?>
                                &nbsp;
                            </td>
                        </tr>

                        <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo h( $account['Account']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo h( $account['Account']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><strong><?php echo __('Comments'); ?></strong></td>
                            <td>
                                <?php echo nl2br(h($account['Account']['comments'])); ?>
                                &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table><!-- /.table table-hover table-condensed -->
            </div>

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
