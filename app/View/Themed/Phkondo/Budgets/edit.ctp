<?php $this->Html->script('budget_edit', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <?php
                $readonlyDisabled = 'readonly';
                $editDisabled = ' disabled';
                $datefield = '';
                $deleteDisabled = ' disabled';
                $createNotesDisabled = 'disabled';
                $hasNotesDisabled = '';
                if ($budget['Budget']['editable']) {
                    $editDisabled = '';
                }
                if ($budget['Budget']['deletable']) {
                    $deleteDisabled = '';
                }

                if (count($budget['Note']) == 0 && $budget['Budget']['budget_status_id'] == 1) {
                    $createNotesDisabled = '';
                    $hasNotesDisabled=' disabled';
                }

                if ($budget['Budget']['budget_status_id'] == 1) {
                    $readonlyDisabled = '';
                    $datefield = ' datefield';
                }
                ?>
                <li ><?php echo $this->Html->link(__('View Budget'), array('action' => 'view', $budget['Budget']['id'], '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
                <li ><?php echo $this->Form->postLink(__('Delete Budget'), array('action' => 'delete', $budget['Budget']['id'], '?' => $this->request->query), array('class' => 'btn ' . $deleteDisabled, 'confirm' => __('Are you sure you want to delete # %s?', $budget['Budget']['title']))); ?> </li>
                <li ><?php echo $this->Html->link(__('List Budgets'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn ')); ?> </li>
               </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">
        <a name="warningzone" class="hide">
            <div id="cancelWarning" class="alert alert-warning hide">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo __('Warning: when you cancel a budget, ALL DEBIT NOTES created by this budget will be set as CANCELED, EXCEPT the ones already paid.'); ?></div>
                <div id="pendingWarning" class="alert alert-warning hide">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo __('Warning: when you set a budget as pending, ALL DEBIT NOTES created by this budget will be set as WAITING PAYMENT, EXCEPT the ones already paid.'); ?></div>
                <div id="disabledWarning" class="alert alert-warning hide">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo __('Warning: field set read only by budget status, you must change budget to pending to allow change.'); ?></div>
                 
        </a>
        <div class="budgets form">

            <?php echo $this->Form->create('Budget', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('Edit Budget'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('fiscal_year_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('budget_type_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('budget_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                
                <div class="form-group">
                    <?php echo $this->Form->input('title', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                
                <div class="form-group">
                    <?php
                    echo $this->Form->input('budget_date', array(
                        'type' => 'text',
                        'class' => 'form-control '.$datefield,
                        $readonlyDisabled,
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date']));
                    ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('amount', array($readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('common_reserve_fund', array($readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php
                    echo $this->Form->input('begin_date', array(
                        'type' => 'text',
                         'class' => 'form-control '.$datefield,
                        $readonlyDisabled,
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date']));
                    ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('shares', array($readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('share_periodicity_id', array($readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('share_distribution_id', array($readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('due_days', array( $readonlyDisabled, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('meeting_draft', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('comments', ['label' => ['text' => __('Observations'), 'class' => 'col-sm-2 control-label'], 'class' => 'form-control']); ?>
                </div><!-- .form-group -->

            </fieldset>
            <div class="form-group">    
                <div class="col-sm-offset-2 col-sm-6">    
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>    
                </div>       
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->
