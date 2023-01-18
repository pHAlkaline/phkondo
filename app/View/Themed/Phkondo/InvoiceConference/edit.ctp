<?php $this->Html->script('invoice_conference_edit', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li><?php echo $this->Html->link(__('View Invoice'), array('action' => 'view', $this->Form->value('InvoiceConference.id'), '?' => $this->request->query), array('class' => 'btn ')); ?> </li>

                <li><?php echo $this->Form->postLink(__('Delete Invoice'), array('action' => 'delete', $this->Form->value('InvoiceConference.id'), '?' => $this->request->query), array('class' => 'btn', 'confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('InvoiceConference.description')))); ?></li>
                <li><?php echo $this->Html->link(__('List Invoices'), array('action' => 'index_by_supplier', $this->Form->value('InvoiceConference.supplier_id'), '?' => $this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

        <div class="movements form">

            <?php echo $this->Form->create('InvoiceConference', array('class' => 'form-horizontal', 'role' => 'form', 'inputDefaults' => array('class' => 'form-control', 'label' => array('class' => 'col-sm-2 control-label'), 'between' => '<div class="col-sm-6">', 'after' => '</div>',))); ?>
            <fieldset>
                <legend><?php echo __('Edit Invoice'); ?></legend>
                <?php echo $this->Form->input('id'); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fiscal_year_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('supplier_id', array('empty' => true, 'class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('document', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('description', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php
                    echo $this->Form->input('document_date', array(
                        'type' => 'text',
                        'class' => 'form-control datefield',
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date']
                    ));
                    ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php
                    echo $this->Form->input('payment_due_date', array(
                        'type' => 'text',
                        'class' => 'form-control datefield',
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date']
                    ));
                    ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('comments', ['label' => ['text' => __('Observations'), 'class' => 'col-sm-2 control-label'], 'class' => 'form-control']); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('invoice_conference_status_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <?php
                $hidden = "hidden";
                $disabled = "disabled";

                if ($this->Form->value('invoice_conference_status_id') == '5') {
                    $hidden = null;
                    $disabled = null;
                }
                ?>
                <div class="form-group <?php echo $hidden; ?>" id="elem_payment_date">
                    <?php
                    echo $this->Form->input('payment_date', array(
                        'type' => 'text',
                        'class' => 'form-control datefield',
                        'disabled' => $disabled,
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date']
                    ));
                    ?>
                </div><!-- .form-group -->
                <div class="form-group <?php echo $hidden; ?>" id="elem_add_movement" >
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php echo $this->Form->input('add_movement', array('type' => 'checkbox', 'class' => 'checkbox styled', 'label' => __('New Movement'), 'div' => array('class' => 'checkbox checkbox-success'), 'between' => '', 'after' => '')); ?>
                    </div>
                </div><!-- .form-group -->
                <div id="new-movement" class="<?php echo $hidden; ?>" >
                    <hr />
                    <legend><?php echo __('New Movement'); ?></legend>
                    <?php
                    $amount = isset($this->request->data['Movement'][0]['amount']) ? $this->request->data['Movement'][0]['amount'] : $this->Form->value('InvoiceConference.amount');
                    $document = isset($this->request->data['Movement'][0]['document']) ? $this->request->data['Movement'][0]['document'] : $this->Form->value('InvoiceConference.document');
                    $description = isset($this->request->data['Movement'][0]['description']) ? $this->request->data['Movement'][0]['description'] : __('Invoice') . ' ' . $document;

                    $today = date('Y-m-d');
                    $today = strtotime($today);
                    //echo $paymentDate; // echos today! 
                    $fyStartDate = strtotime($fiscalYearData['FiscalYear']['open_date']);
                    $fyEndDate = strtotime($fiscalYearData['FiscalYear']['close_date']);
                    $hasDate = false;
                    if (($today >= $fyStartDate) && ($today <= $fyEndDate)) {
                        $hasDate = true;
                    } else {
                        $hasDate = false;
                    }
                    $documentDate = $hasDate ? date(Configure::read('Application.dateFormatSimple')) : null;
                    $documentDate = isset($this->request->data['Movement'][0]['movement_date']) ? $this->request->data['Movement'][0]['movement_date'] : $documentDate;
                    ?>
                     <?php echo $this->Form->hidden('Movement.0.document_model', array('value' => 'InvoiceConference')); ?>

                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.account_id', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.fiscal_year_id', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.movement_date', array(
                            'value' => $documentDate,
                            'type' => 'text',
                            'class' => 'form-control datefield',
                            'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                            'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date'],
                        )); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.description', array('value' => $description, 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.amount', array('value' => $amount, 'class' => 'form-control', 'min' => 0, 'step' => '0.01')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.movement_category_id', array('empty' => __('Select'), 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.movement_operation_id', array('empty' => __('Select'), 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.movement_type_id', array('class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                    <div class="form-group">
                        <?php echo $this->Form->input('Movement.0.document', array('value' => $document, 'class' => 'form-control')); ?>
                    </div><!-- .form-group -->
                </div>
            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6"> <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?> </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->