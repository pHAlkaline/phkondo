
<div id="page-container" class="row row-offcanvas row-offcanvas-left">

    <div class="col-sm-3">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li ><?php echo $this->Html->link(__('List Budgets'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-9">

        <div class="budgets form">

            <?php
            echo $this->Form->create('Budget', array(
                'class' => 'form-horizontal',
                'role' => 'form',
                'inputDefaults' => array(
                    'class' => 'form-control',
                    'label' => array('class' => 'col-sm-2 control-label'),
                    'between' => '<div class="col-sm-6">',
                    'after' => '</div>',
            )));
            ?>
            <fieldset>
                <legend><?php echo __('New Budget'); ?></legend>
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
                        'class' => 'form-control datefield',
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date'],));
                    ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php echo $this->Form->input('amount', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('common_reserve_fund', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
                    <?php
                    echo $this->Form->input('begin_date', array(
                        'type' => 'text',
                        'class' => 'form-control datefield',
                        'data-date-start-date' => $fiscalYearData['FiscalYear']['open_date'],
                        'data-date-end-date' => $fiscalYearData['FiscalYear']['close_date']));
                    ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('shares', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('share_periodicity_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('share_distribution_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('due_days', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('meeting_draft', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->

                <div class="form-group">
<?php echo $this->Form->input('comments', array('class' => 'form-control')); ?>
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
