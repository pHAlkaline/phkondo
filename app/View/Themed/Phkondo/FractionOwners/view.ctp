<?php
?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left ">

    <div class="col-sm-3">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Owner'), array('action' => 'edit', $entity['Entity']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Remove %s', __n('Owner', 'Owners', 1)), array('action' => 'remove', $entity['Entity']['id'],'?'=>$this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to remove # %s?', $entity['Entity']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Owner'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Owners'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Note','Notes',2), array('controller' => 'owner_notes', 'action' => 'index','?'=>array_merge(array('owner_id'=>$entity['Entity']['id']),$this->request->query)), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Receipt', 'Receipts', 2), array('controller' => 'owner_receipts', 'action' => 'index','?'=>array_merge(array('owner_id'=>$entity['Entity']['id']),$this->request->query)), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __('Current Account'), array('action' => 'current_account','?'=>array_merge(array('owner_id'=>$entity['Entity']['id']),$this->request->query)), array('target' => '_blank', 'class' => '', 'escape' => false)); ?> </li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-9">

        <div class="entities view">

            <legend><?php echo __n('Owner', 'Owners', 1); ?></legend>


            <table class="table table-hover table-condensed">
                <tbody>
                    <tr>		<td class='col-sm-2'><strong><?php echo __('Name'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['name']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Vat Number'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['vat_number']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Owner Percentage'); ?></strong></td>
                        <td>
                            <?php echo h($entitiesFraction['EntitiesFraction']['owner_percentage']); ?>
                            &nbsp;&percnt;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Representative'); ?></strong></td>
                        <td>
                            <?php echo $entity['Entity']['representative'] ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Address'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($entity['Entity']['address'])); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __n('Contact', 'Contacts', 2); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['contacts']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Email'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['email']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Bank'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['bank']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Nib'); ?></strong></td>
                        <td>
                            <?php echo h($entity['Entity']['nib']); ?>
                            &nbsp;
                        </td>
                    </tr>
                   
                    <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                        <td>
                            <?php echo h( $entity['Entity']['modified']); ?>
                            &nbsp;
                        </td>
                    </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                        <td>
                            <?php echo h( $entity['Entity']['created']); ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>		
                        <td><strong><?php echo __('Comments'); ?></strong></td>
                        <td>
                            <?php echo nl2br(h($entity['Entity']['comments'])); ?>
                            &nbsp;
                        </td>
                    </tr>
                </tbody>
            </table><!-- /.table table-hover table-condensed -->


        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
