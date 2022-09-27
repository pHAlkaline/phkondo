<?php

$this->Html->script('fraction_view', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left ">

    <div class="col-sm-2">
        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('Edit Fraction'), array('action' => 'edit', $fraction['Fraction']['id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <?php
                $deleteDisabled = '';
                if (!$fraction['Fraction']['deletable'] == true) {
                    $deleteDisabled = ' disabled';
                }
                ?>
                <li ><?php echo $this->Form->postLink(__('Delete Fraction'), array('action' => 'delete', $fraction['Fraction']['id'], '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $fraction['Fraction']['fraction']))); ?> </li>
                <li ><?php echo $this->Html->link(__('New Fraction'), array('action' => 'add', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link(__('List Fractions'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Owner', 'Owners', 2), array('controller' => 'fraction_owners', 'action' => 'index', '?' => array_merge(array('fraction_id' => $fraction['Fraction']['id']), $this->request->query)), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Note', 'Notes', 2), array('controller' => 'fraction_notes', 'action' => 'index', '?' => array_merge(array('fraction_id' => $fraction['Fraction']['id'],'note_status_id' => '1'), $this->request->query)), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Insurance', 'Insurances', 2), array('controller' => 'fraction_insurances', 'action' => 'index', '?' => array_merge(array('fraction_id' => $fraction['Fraction']['id']), $this->request->query)), array('class' => 'btn ', 'escape' => false)); ?></li>
                <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right"></span> ' . __n('Attachment', 'Attachments', 2), array('plugin' => 'attachments', 'controller' => 'fraction_attachments', 'action' => 'index', '?' => array_merge(array('fraction_id' => $fraction['Fraction']['id']), $this->request->query)), array('class' => 'btn ', 'escape' => false)); ?> </li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .span3 -->

    <div id="page-content" class="col-sm-10">
        <div class="fractions view">

            <legend><?php echo __n('Fraction', 'Fractions', 1); ?>&nbsp;<?php echo h($fraction['Fraction']['fraction']); ?></legend>
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
                                <tr>		
                                    <td class='col-sm-2'><strong><?php echo __n('Manager', 'Managers', 1); ?></strong></td>
                                    <td>
                            <?php
                            if ($fraction['Fraction']['manager_id'] == 0) {
                                echo __('All owners');
                            } else {
                                echo h($fraction['Manager']['name']);
                            }
                            ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>		<td><strong><?php echo __n('Fraction', 'Fractions', 1); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['fraction']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>		<td><strong><?php echo __n('Fraction Type', 'Fraction Types', 1); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['FractionType']['name']); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr><td><strong><?php echo __('Location'); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['location']); ?>
                                        &nbsp;
                                    </td>
                                </tr><tr>		<td><strong><?php echo __('Description'); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['description']); ?>
                                        &nbsp;
                                    </td>
                                </tr><tr>		<td><strong><?php echo __('Permillage'); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['permillage']); ?>
                                        &nbsp;
                                    </td>

                                <tr>		<td><strong><?php echo __('Modified'); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['modified']); ?>
                                        &nbsp;
                                    </td>
                                </tr><tr>		<td><strong><?php echo __('Created'); ?></strong></td>
                                    <td>
                            <?php echo h($fraction['Fraction']['created']); ?>
                                        &nbsp;
                                    </td>
                                </tr>

                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->



                    </div>
                    <div role="tabpanel" class="tab-pane" id="current-account" aria-labelledby="current-account-tab">
                        <br/>
                         <?php echo $this->Html->link('<i class="fa fa-print"></i>&nbsp;'.__('Print'), array('action' => 'current_account', '?' => array_merge(array('fraction_id' => $fraction['Fraction']['id']), $this->request->query)), array('target'=>'_blank','title' => __('Report'), 'class' => 'btn btn-default pull-right', 'escape' => false)); ?>

                        <table class="table table-hover table-condensed">
                            <tbody>
                                <tr>		
                                    <td class='col-sm-2'><strong><?php echo __n('Manager', 'Managers', 1); ?></strong></td>
                                    <td>
                            <?php
                            if ($fraction['Fraction']['manager_id'] == 0) {
                                echo __('All owners');
                            } else {
                                echo h($fraction['Manager']['name']);
                            }
                            $current_account=isset($totalDebit['Note']['amount'])?$totalDebit['Note']['amount']:0;
                            $credits=isset($totalCredit['Note']['amount'])?$totalCredit['Note']['amount']:0;
                            ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo __('Current Account'); ?></strong></td>
                                    <td>
                            <?php echo number_format($current_account, 2); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo  __('Crédits'); ?></strong></td>
                                    <td>
                            <?php echo number_format($credits, 2); ?>&nbsp;<?php echo Configure::read('Application.currencySign'); ?>
                                        &nbsp;
                                    </td>
                                </tr>


                            </tbody>
                        </table><!-- /.table table-hover table-condensed -->
                        <hr/>
                        <div class="fractions form">
                            <br/>
                        <?php echo $this->Form->create('Fraction', array(
                            'url' => array('controller'=>'Fractions','action' => 'send_current_account', $fraction['Fraction']['id'], '?' => $this->request->query),
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

                        <?php echo $this->Comments->display_for($fraction); ?>
                    </div>

                </div>
            </section>

        </div>
    </div><!-- /.view -->
</div><!-- /#page-content .span9 -->