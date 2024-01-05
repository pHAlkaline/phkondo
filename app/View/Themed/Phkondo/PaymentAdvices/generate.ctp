<?php $this->Html->script('payment_advice_add', false); ?>
<div id="page-container" class="row row-offcanvas row-offcanvas-left">
    <div class="col-sm-2">

        <div id="sidebar" class="hidden-print actions sidebar-offcanvas">

            <ul class="nav nav-pills nav-stacked">
                <li><?php echo $this->Html->link(__('List'), array('action' => 'index', '?' => $this->request->query), array('class' => 'btn')); ?></li>

            </ul><!-- /.list-group -->

        </div><!-- /.actions -->

    </div><!-- /#sidebar .col-sm-3 -->

    <div id="page-content" class="col-sm-10">

        <div class="payment_advices form">
           
                <div id="cancelWarning" class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo __('Warning: when a payment advice is generated, ALL PAYMENT ADVICES previously created will be removed, EXCEPT those that have already been paid.'); ?>
                </div>

          
            <?php echo $this->Form->create(
                'PaymentAdvice',
                array(
                    'class' => 'form-horizontal',
                    'role' => 'form',
                    'inputDefaults' => array(
                        'class' => 'form-control',
                        'label' => array(
                            'class' => 'col-sm-2 control-label'
                        ),
                        'between' => '<div class="col-sm-6">',
                        'after' => '</div>'
                    )
                )
            );
            ?>

            <?php echo $this->Form->hidden('change_filter'); ?>
            <fieldset>
                <legend><?php echo __('Generate All'); ?></legend>
                <div class="form-group">
                    <?php echo $this->Form->input('condo_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('fraction_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('entity_id', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('document_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('due_date', array('type' => 'text', 'class' => 'form-control datefield')); ?>
                </div><!-- .form-group -->
                <!--div class="form-group">
                    <?php //echo $this->Form->input('status_id', array('class' => 'form-control')); 
                    ?>
                </div--><!-- .form-group -->
                <!--div class="form-group">
                    <?php //echo $this->Form->input('receipt_payment_type_id', array('class' => 'form-control')); 
                    ?>
                </div--><!-- .form-group -->
                <div class="form-group">
                    <?php echo $this->Form->input('observations', array('class' => 'form-control')); ?>
                </div><!-- .form-group -->


            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <?php echo $this->Form->button(__('Generate All'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>

        </div><!-- /.form -->

    </div><!-- /#page-content .col-sm-9 -->

</div><!-- /#page-container .row-fluid -->