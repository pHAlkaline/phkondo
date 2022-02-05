<?php ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left ">

    <div class="col-sm-2">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">
            <ul class="nav nav-pills nav-stacked">			
                <li ><?php echo $this->Html->link(__('Edit Owner'), array('action' => 'edit', $entity['Entity']['id'],'?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Remove %s', __n('Owner', 'Owners', 1)), array('action' => 'remove', $entity['Entity']['id'],'?'=>$this->request->query), array('class' => 'btn ', 'confirm' => __('Are you sure you want to remove # %s?', $entity['Entity']['name']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Owner'), array('action' => 'add','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Owners'), array('action' => 'index','?'=>$this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Note','Notes',2), array('controller' => 'owner_notes', 'action' => 'index','?'=>array_merge(array('owner_id'=>$entity['Entity']['id']),$this->request->query)), array('class' => 'btn ', 'escape' => false)); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Receipt', 'Receipts', 2), array('controller' => 'owner_receipts', 'action' => 'index','?'=>array_merge(array('owner_id'=>$entity['Entity']['id']),$this->request->query)), array('class' => 'btn ', 'escape' => false)); ?> </li>
            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-10">

        <div class="entities view">

            <legend><?php echo __n('Owner', 'Owners', 1); ?></legend>
            <section>

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab"><?= __('Details'); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#current-account" aria-controls="current-account" role="tab" data-toggle="tab"><?= __('Current Account'); ?></a>
                    </li>
                    <li role="presentation">
                        <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><?= __('Comments'); ?></a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="details" aria-labelledby="details-tab">

                        <br/>
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
                                <tr>
                                    <td><strong><?php echo __('Current Account'); ?></strong></td>
                                    <td>
                            <?php
                                $current_account=isset($totalDebit['Note']['amount'])?$totalDebit['Note']['amount']:0;
                            $credits=isset($totalCredit['Note']['amount'])?$totalCredit['Note']['amount']:0;
                        
                            echo number_format($current_account, 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo  __('Crédits'); ?></strong></td>
                                    <td>
                            <?php echo number_format($credits, 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?>
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
                                    <td><strong><?php echo __('Observations'); ?></strong></td>
                                    <td>
                            <?php echo nl2br(h($entity['Entity']['comments'])); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->



                    </div>
                    <div role="tabpanel" class="tab-pane" id="current-account" aria-labelledby="current-account-tab">
                        <br/>
                        <?php echo $this->Html->link('<i class="fa fa-print"></i>&nbsp;'.__('Print'), array('action' => 'current_account', '?' => array_merge(array('owner_id' => $entity['Entity']['id']), $this->request->query)), array('target'=>'_blank','title' => __('Report'), 'class' => 'btn btn-default pull-right', 'escape' => false)); ?>

                        <table class="table table-hover table-condensed">
                            <tbody>
                                <tr>		
                                    <td class='col-sm-2'><strong><?php echo __('Owner'); ?></strong></td>
                                    <td><?php echo h($entity['Entity']['name']);?>&nbsp;</td>
                                    </td>
                                </tr>
                                <?php 
                                 $current_account=isset($totalDebit['Note']['amount'])?$totalDebit['Note']['amount']:0;
                            $credits=isset($totalCredit['Note']['amount'])?$totalCredit['Note']['amount']:0;
                            ?>

                                <tr>
                                    <td><strong><?php echo __('Current Account'); ?></strong></td>
                                    <td>
                            <?php echo number_format($current_account, 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo  __('Crédits'); ?></strong></td>
                                    <td>
                            <?php echo number_format($credits, 2); ?>&nbsp;<?php echo Configure::read('currencySign'); ?>
                                        &nbsp;
                                    </td>
                                </tr>

                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->
                        <hr/>
                        <div class="fractions form">
                            <br/>
                        <?php echo $this->Form->create('Entity', array(
                            'url' => array('controller'=>'FractionOwners','action' => 'send_current_account', $entity['Entity']['id'], '?' => $this->request->query),
                            'class' => 'form-horizontal', 
                            'role' => 'form', 
                            'inputDefaults' => array(
                                'class' => 'form-control', 
                                'label' => array('class' => 'col-sm-2 control-label'), 
                                'between' => '<div class="col-sm-6">', 
                                'after' => '</div>'
                                )
                            )
                                ); ?>
                            <fieldset>
                            <?php echo $this->Form->input('id'); ?>

                                <div class="form-group">
                                        <?php echo $this->Form->input('send_to', ['type'=>'select','label' => array('text' => __d('email','Send To'), 'class' => 'col-sm-2 control-label'), 'class' => 'form-control select2-phkondo', 'options' => $notificationEntities, 'multiple' => true, 'value' => $notificationEntities, 'data-allow-clear' => true, 'data-tags' => true, 'data-maximum-selection-length'=>5, 'required'=>'required']); ?>
                                </div>
                                <div class="form-group">
                                <?php echo $this->Form->input('subject', array('label' => array('text' => __d('email','Subject'), 'class' => 'col-sm-2 control-label'),'required'=>'required', 'class' => 'form-control', 'default' => $emailNotifications['current_account_subject'])); ?>
                                </div><!-- .form-group -->

                                <div class="form-group">
                                <?php echo $this->Form->input('message', array('label' => array('text' => __d('email','Message'), 'class' => 'col-sm-2 control-label'),'required'=>'required', 'type'=>'textarea','class' => 'form-control', 'default' => $emailNotifications['current_account_message'])); ?>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                        <?php echo $this->Form->input('attachment_format', ['type'=>'select','label' => array('text' => __d('email','Format'), 'class' => 'col-sm-2 control-label'), 'class' => 'form-control select2-phkondo', 'options' => ['pdf'=>__d('email','PDF'), 'html'=>__d('html','HTML')], 'value' => $emailNotifications['current_account_attachment_format'], 'required'=>'required']); ?>
                                </div>

                                <!-- .form-group -->

                            </fieldset>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-6">
                                    <?php echo $this->Form->button(__d('email','Send'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                                </div>
                            </div>
                        <?php echo $this->Form->end(); ?>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="comments" aria-labelledby="comments-tab">
                        <br/>
                        <?php echo $this->Comments->display_for($entity,['model'=>'Entity']); ?>
                    </div>

                </div>
            </section>



        </div><!-- /.view -->


    </div><!-- /#page-content .span9 -->

</div><!-- /#page-container .row-fluid -->
