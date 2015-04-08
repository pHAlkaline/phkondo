
<div id="page-container" class="row">

    <div id="sidebar" class="col-sm-3 hidden-print collapse navbar-collapse phkondo-navbar">

        <div class="actions">

            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Insurance'), array('action' => 'edit', $insurance['Insurance']['id']), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Insurance'), array('action' => 'delete', $insurance['Insurance']['id']), array('class' => 'btn ','confirm'=> __('Are you sure you want to delete # %s?' , $insurance['Insurance']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Insurance'), array('action' => 'add'), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Insurances'), array('action' => 'index'), array('class' => 'btn ')); ?> </li>
                

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="insurances view">

            <h2><?php echo __n('Insurance','Insurances',1); ?></h2>

            
                <table class="table table-hover table-condensed">
                    <tbody>
                        <tr>		<td class='col-sm-2'><strong><?php echo __('Expiration Date'); ?></strong></td>
                            <td>
                                <?php echo $this->Time->format(Configure::read('dateFormatSimple'),$insurance['Insurance']['expiration_date']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __n('Fraction','Fractions',1); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Fraction']['description']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Title'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Insurance']['title']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Insurance Company'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Insurance']['insurance_company']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Policy'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Insurance']['policy']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Insurance Type'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['InsuranceType']['name']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Insurance Amount'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Insurance']['insurance_amount']); ?>
                                &nbsp;<?= Configure::read('currencySign'); ?>
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Insurance Premium'); ?></strong></td>
                            <td>
                                <?php echo h($insurance['Insurance']['insurance_premium']); ?>
                                &nbsp;<?= Configure::read('currencySign'); ?>
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                            <td>
                                <?php echo $this->Time->format(Configure::read('dateFormat'),$insurance['Insurance']['modified']); ?>
                                &nbsp;
                            </td>
                        </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                            <td>
                                <?php echo $this->Time->format(Configure::read('dateFormat'),$insurance['Insurance']['created']); ?>
                                &nbsp;
                            </td>
                        </tr>					</tbody>
                </table><!-- /.table table-hover table-condensed -->
            

        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
