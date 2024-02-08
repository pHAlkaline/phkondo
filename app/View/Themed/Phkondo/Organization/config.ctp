<?php $this->Html->script('organization_config', false); ?>
<div id="page-content" class="col-sm-12 col-md-10">
    <legend>
        <?php echo __('Edit Organization'); ?>
    </legend>
    <section>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#details" aria-controls="details" role="tab" data-toggle="tab"><?= __('Details'); ?></a>
            </li>
            <li role="presentation">
                <a href="#payment-advice" aria-controls="notes" role="tab" data-toggle="tab"><?= __n('Payment Advice', 'Payemnt Advices', 1); ?></a>
            </li>

        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="details" aria-labelledby="details-tab">

                <div class="organization form">
                    <div class="row">
                        <br />

                        <?php echo $this->Form->create(false, array(
                            'type' => 'file',
                            'class' => 'form-horizontal',
                            'role' => 'form',
                            'inputDefaults' => array(
                                'class' => 'form-control',
                                'label' => array('class' => 'col-sm-2 control-label'),
                                'between' => '<div class="col-sm-6">',
                                'after' => '</div>'
                            )
                        )); ?>
                        <fieldset>


                            <div class="form-group">
                                <?php echo $this->Form->input('name', array('default' => $organization['name'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('vat_number', array('default' => $organization['vat_number'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('representative', array('default' => $organization['representative'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('address', array('default' => $organization['address'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('contact', array('default' => $organization['contact'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('email', array('default' => $organization['email'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('logo', array('label' => array('text' => 'Logo (Max:380x65)', 'class' => 'col-sm-2 control-label'), 'type' => 'file', 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <h1 class=""><img src="<?php echo $logo_image_src; ?>" style="height:100%;" alt="phkondo" class="logoimg img-responsive center-block" /></h1>
                            </div><!-- .form-group -->

                        </fieldset>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="payment-advice" aria-labelledby="payment-advice-tab">
                <div class="organization form">
                    <div class="row">
                        <br />
                        <?php echo $this->Form->create(false, array(
                            'type' => 'file',
                            'class' => 'form-horizontal',
                            'role' => 'form',
                            'inputDefaults' => array(
                                'class' => 'form-control',
                                'label' => array('class' => 'col-sm-2 control-label'),
                                'between' => '<div class="col-sm-6">',
                                'after' => '</div>'
                            )
                        )); ?>
                        <fieldset>
                            <?php 
                            $paymentAdvices['observations']=$paymentAdvices['observations']=='_default_'? __('If you have made the payment, consider this notice to be ineffective. We also take this opportunity to remind you that payments made by bank transfer must be communicated to our services through the means made available.'):$paymentAdvices['observations'];
                            $paymentAdvices['payment_gateway']=$paymentAdvices['payment_gateway']=='_default_'? '':$paymentAdvices['payment_gateway'];
                            
                            ?>
                            <div class="form-group">
                                <?php echo $this->Form->input('observations', array('default' => $paymentAdvices['observations'], 'class' => 'form-control', 'type' => 'textarea')); ?>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <?php echo $this->Form->input('payment_gateway', array('default' => $paymentAdvices['payment_gateway'], 'class' => 'form-control')); ?>
                            </div><!-- .form-group -->

                        </fieldset>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <?php echo $this->Form->button(__('Submit'), array('class' => 'btn btn-large btn-primary pull-right')); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>